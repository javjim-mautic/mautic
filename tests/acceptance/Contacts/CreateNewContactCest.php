<?php

use DataObjects\Contacts\ContactsDataObjects;
use Page\Acceptance\DashboardPage;
use Page\Acceptance\NewContactPage;
use Codeception\Module\Cli;

class CreateNewContactCest
{
    private $contactPageObjects = null;
    public function _before(AcceptanceTester $I)
    {
        $I->loginToMautic();
        $this->contactPageObjects = NewContactPage::getContactPageObject();
    }

    public function _after(AcceptanceTester $I)
    {
    }

    // tests
    public function CreateAContactAllFieldsAndCompany(AcceptanceTester $I)
    {
        $I->wantTo('Create a contact with all fields and new company (Primary) from new button with points not set up');
        $I->amGoingTo('Open Contacts and click on New button');
        $I->amOnPage(DashboardPage::$URL);
        $I->click(DashboardPage::$ContactPage);
        $I->amOnPage('/s/contacts');
        $I->click($this->contactPageObjects['newButton']);
        $I->amOnPage(NewContactPage::$URL);

        $I->amGoingTo('Fill Contact Data');
        $newContact = new ContactsDataObjects();
        $newContact->fillContact($I, 'FL', 'US');

        $I->amGoingTo('Fill Contact Social Data');
        $I->click('Social');
        $I->wait(3);
        $I->waitForText('Facebook');
        $newContact->fillContactSocial($I);

        $I->amGoingTo('Fill New Company Data');
        $I->click('Core');
        $I->wait(5);
        $I->click($this->contactPageObjects['companyField']);
        $I->click($this->contactPageObjects['contactNewCompanyOption']);
        $I->waitForText('Company Name');
        $newContact->fillContactCompany($I, 'CA', 'US');

        $I->amGoingTo('Save Company and Contact');
        $I->click($this->contactPageObjects['saveCompanyButton']);
        $I->wait(5);
        $I->click($this->contactPageObjects['saveCloseButton']);

        $I->amGoingTo('Review all data contact core data is saved correctly with 0 points and New Company is primary');
        $I->wait(5);
        $I->amOnPage('s/contacts/view/1');
        $I->waitForText('Engagements');
        $I->click('//a[@data-target="#lead-details"]');
        $newContact->verifyContact($I, 'Florida', 'United States', true, 1);

        $I->amGoingTo(' Verify data in Social is correct');
        $I->click('//a[@href="#social"]');
        $I->waitForText('Facebook');
        $newContact->verifyContactSocial($I);

        $I->amGoingTo('Verify new Company information is correct');
        $I->amOnPage('s/companies/edit/1');
        $I->waitForText('Edit Company');
        $newContact->verifyContactCompany($I, 'California', 'United States');
    }
    public function CreateAContactNoCompany10Points(AcceptanceTester $I)
    {
        $I->wantTo('Create a contact with all fields and no company from new button with 10 points set up');
        $I->amGoingTo('Open Contacts and click on create new');
        $I->amOnPage(DashboardPage::$URL);
        $I->click(DashboardPage::$ContactPage);
        $I->amOnPage('/s/contacts');
        $I->click($this->contactPageObjects['newButton']);
        $I->amOnPage(NewContactPage::$URL);

        $I->amGoingTo('Fill Contact core data');
        $newContact = new ContactsDataObjects();
        $newContact->_2NoCompany10Points();
        $newContact->fillContact($I, 'FL', 'US');
        $I->wait(5);
        $I->click($this->contactPageObjects['saveCloseButton']);

        $I->amGoingTo('Verify all data is entered correctly without a company and with 10 points');
        $I->wait(5);
        $I->amOnPage('s/contacts/view/2');
        $I->waitForText('Engagements');
        $I->click('//a[@data-target="#lead-details"]');
        $newContact->verifyContact($I, 'Florida', 'United States', null, null);
    }

    public function CreateAContactWithExistingCompany(AcceptanceTester $I)
    {
        $I->wantTo('Create a contact with existing company');

        $I->amGoingTo('Open Contacts and click on create new');
        $I->amOnPage(DashboardPage::$URL);
        $I->click(DashboardPage::$ContactPage);
        $I->amOnPage('/s/contacts');
        $I->click($this->contactPageObjects['newButton']);
        $I->amOnPage(NewContactPage::$URL);

        $I->amGoingTo('Fill Contact Data');
        $newContact = new ContactsDataObjects();
        $newContact->_3ExistingCompany();
        $newContact->fillContact($I, 'FL', 'US');

        $I->amGoingTo('Select "New Button Company"');
        $I->click($this->contactPageObjects['companyField']);
        $I->click(str_replace('$', '2', $this->contactPageObjects['contactCompanyOption']));
        $I->wait(5);
        $I->click($this->contactPageObjects['saveCloseButton']);

        $I->amGoingTo('Review all data contact core data is saved correctly with 0 points and Existing Company is primary');
        $I->wait(5);
        $I->amOnPage('s/contacts/view/3');
        $I->waitForText('Engagements');
        $I->click('//a[@data-target="#lead-details"]');
        $newContact->verifyContact($I, 'Florida', 'United States', true, 1);
    }

    public function ImportContactsFromCsv(AcceptanceTester $I)
    {
        $I->wantTo('Create contacts and companies by importing a CSV');

        $I->amGoingTo('Open Contacts and click on create new');
        $I->amOnPage(DashboardPage::$URL);
        $I->click(DashboardPage::$ContactPage);
        $I->amOnPage('/s/contacts');
        $I->click($this->contactPageObjects['dropdownMenu']);
        $I->click($this->contactPageObjects['importButton']);
        $I->waitForText('Import');
        $I->attachFile('lead_import[file]', 'importcompany.csv');
        $I->click('lead_import[start]');
        $I->waitForText('Import contacts');
        $I->click('//*[@id="lead_field_import_buttons_save_toolbar"]');
        $I->wait(15);
        $I->canSee('Success');
        $I->canSee('20 created,');
        $newContact = new ContactsDataObjects();
        $newContact->verifyImportContacts($I);
    }

    public function filterContacts(AcceptanceTester $I){
        $I->wantTo('Use filters to find contacts');
        $I->amOnPage('s/contacts');
        $I->fillField('//*[@id="list-search"]','Contact');
        $I->wait(4);
        $I->canSee('New Button Contact');
        $I->canSee('No Company Contact');
        $I->canSee('2 items,');
    }

    public function changeSegment(AcceptanceTester $I){
        $I->wantTo('Change a contacts segment');
        $I->amOnPage('/s/contacts');
        $I->checkOption('cb1');
        $I->checkOption('cb2');
        $I->click('//*[@id="leadTable"]/thead/tr/th[1]/div/div/button/i');
        $I->click('Change Segments');
        $I->click('//*[@id="lead_batch_add_chosen"]/ul');
        $I->click('//*[@id="lead_batch_add_chosen"]/div/ul/li[2]');
        $I->wait(3);
        $I->click('//*[@id="MauticSharedModal"]/div/div/div[3]/div/button[2]');
        $I->runShellCommand('php app/console mautic:segments:update');
        $I->wait(12);
        $I->click(DashboardPage::$SegmentsPage);
        $I->waitForText('Contact Segments');
        $I->click('View 2 Contacts');
        $I->wait(3);
        $I->canSee('New Button Contact');
        $I->canSee('No Company Contact');

    }

    public function  changeCampaign(AcceptanceTester $I){
         $I->wantTo("Change a contacts campaign");
         
    }




}
