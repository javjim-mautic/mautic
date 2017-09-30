<?php

use DataObjects\Contacts\ContactsDataObjects;
use Page\Acceptance\DashboardPage;
use Page\Acceptance\NewContactPage;

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
        $newContact->verifyContact($I, 'Florida', 'United States', true);

        $I->amGoingTo(' Verify data in Social is correct');
        $I->click('//a[@href="#social"]');
        $I->waitForText('Facebook');
        $newContact->verifyContactSocial($I);

        $I->amGoingTo('Verify new Company information is correct');
        $I->amOnPage('s/companies/edit/1');
        $I->waitForText('Edit Company');
        $newContact->verifyContactCompany($I, 'California', 'United States');
    }
    public function CreateAContactNoCompany(AcceptanceTester $I)
    {
        $I->wantTo('Create a contact with all fields and no company from new button points not set up');
        $I->amGoingTo('Open Contacts and click on create new');
        $I->amOnPage(DashboardPage::$URL);
        $I->click(DashboardPage::$ContactPage);
        $I->amOnPage('/s/contacts');
        $I->click($this->contactPageObjects['newButton']);
        $I->amOnPage(NewContactPage::$URL);

        $I->amGoingTo('Fill Contact core data');
        $newContact = new ContactsDataObjects();
        $newContact->_2NoCompany();
        $newContact->fillContact($I, 'FL', 'US');
        $I->wait(5);
        $I->click($this->contactPageObjects['saveCloseButton']);

        $I->amGoingTo('Verify all data is entered correctly without a company and with 10 points');
        $I->wait(5);
        $I->amOnPage('s/contacts/view/2');
        $I->waitForText('Engagements');
        $I->click('//a[@data-target="#lead-details"]');
        $newContact->verifyContact($I, 'Florida', 'United States', null);
    }
}
