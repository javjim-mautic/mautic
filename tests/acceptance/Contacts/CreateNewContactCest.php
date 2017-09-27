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
        $I->canSee('Mr.');
        $I->canSee('New Button');
        $I->canSee('Contact');
        $I->canSee('newbuttoncontact@mailinator.com');
        $I->canSee('CTO');
        $I->canSee('Contact Address line 1');
        $I->canSee('Contact Address line 2');
        $I->canSee('Orlando');
        $I->canSee('33195');
        $I->canSee('150');
        $I->canSee('3059999999');
        $I->canSee('3058888888');
        $I->canSee('0 points');
        $I->canSee('3057777777');
        $I->canSee('www.newbuttoncontact.com');
        $I->click('//a[@href="#social"]');
        $I->waitForText('Facebook');
        $I->canSee('fb.com');
        $I->canSee('f4.com');
        $I->canSee('gplus.com');
        $I->canSee('ig.com');
        $I->canSee('lnk.com');
        $I->canSee('skype.com');
        $I->canSee('twt.com');
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
