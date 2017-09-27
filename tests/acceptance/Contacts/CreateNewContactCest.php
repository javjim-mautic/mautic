<?php

use DataObjects\Contacts\ContactsDataObjects;
use Page\Acceptance\DashboardPage;
use Page\Acceptance\NewContactPage;

class CreateNewContactCest
{
    public function _before(AcceptanceTester $I)
    {
        $I->loginToMautic();
    }

    public function _after(AcceptanceTester $I)
    {
    }

    // tests
    public function CreateAContactAllFields(AcceptanceTester $I)
    {
        $contactPageObjects = NewContactPage::getContactPageObject();

        $I->wantTo('Create a contact with all fields and new company from new button points not set up');
        $I->amOnPage(DashboardPage::$URL);
        $I->click(DashboardPage::$ContactPage);
        $I->amOnPage('/s/contacts');
        $I->click($contactPageObjects['newButton']);
        $I->amOnPage(NewContactPage::$URL);

        $newContact = new ContactsDataObjects();
        $newContact->fillContact($I, 'FL', 'US');
        $I->click('Social');
        $I->waitForText('Facebook');

        $newContact->fillContactSocial($I);
        $I->click('Core');
        $I->wait(5);

        $I->click($contactPageObjects['companyField']);
        $I->click($contactPageObjects['contactNewCompanyOption']);

        $I->waitForText('Company Name');

        $newContact->fillContactCompany($I, 'CA', 'US');
        $I->click($contactPageObjects['saveCompanyButton']);
        $I->wait(5);

        $I->click($contactPageObjects['saveCloseButton']);
        $I->wait(5);

        $I->amOnPage('s/contacts/view/1');
        $I->waitForText('Engagements');
        $I->click('//a[@data-target="#lead-details"]');

        $newContact->verifyContact($I, 'Florida', 'United States');
        $I->click('//a[@href="#social"]');
        $I->waitForText('Facebook');
        $newContact->verifyContactSocial($I);

        $I->amOnPage('s/companies/edit/1');
        $I->waitForText('Edit Company');
        $newContact->verifyContactCompany($I, 'California', 'United States');
    }
    public function TryCompany(AcceptanceTester $I)
    {
        $lead = ContactMainPage::getLeadPageObject();
        $I->wantTo('Create a contact with all fields and new company from new button');
        $I->amOnPage(DashboardPage::$URL);
        $I->click(DashboardPage::$ContactPage);
        $I->amOnPage(ContactMainPage::$URL);
        $I->click(ContactMainPage::$NewButton);
        $I->waitForText('New Contact');
        $I->fillField('lead[firstname]', 'heya');
        $I->selectOption('//*[@id="lead_state_chosen"]/div/ul', 'Alabama');

        //$I->selectOption('//*[@id="lead_state_chosen"]/div/ul','Alabama');
        $I->wait(10);
    }
}
