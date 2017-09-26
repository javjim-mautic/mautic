<?php

use Page\Acceptance\ContactMain as ContactMainPage;
use Page\Acceptance\Dashboard as DashboardPage;

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
        $lead = ContactMainPage::getLeadPageObject();
        $I->wantTo('Create a contact with all fields and new company from new button');
        $I->amOnPage(DashboardPage::$URL);
        $I->click(DashboardPage::$ContactPage);
        $I->amOnPage(ContactMainPage::$URL);
        $I->click(ContactMainPage::$NewButton);
        $I->amOnPage('/s/contacts/new');
        $I->fillField('lead[title]', 'Mr.');
        $I->fillField('lead[firstname]', 'New Button');
        $I->fillField('lead[lastname]', 'Contact');
        $I->fillField('lead[email]', 'newbuttoncontact@mailinator');
        $I->fillField('lead[position]', 'CTO');
        $I->fillField('lead[address1]', 'Contact Address line 1');
        $I->fillField('lead[address2]', 'Contact Address line 2');
        $I->fillField('lead[city]', 'Orlando');
        $I->fillField('lead[zipcode]', '33195');
        $I->fillField('lead[attribution]', '150');
        $I->fillField('lead[mobile]', '3059999999');
        $I->fillField('lead[phone]', '3058888888');
        //$I->fillField('lead[points]', '0');
        $I->fillField('lead[fax]', '3057777777');
        $I->fillField('lead[website]', 'www.newbuttoncontact.com');

        $I->click('//*[@id="lead_state_chosen"]/a/span');
        $I->click('//*[@id="lead_state_chosen"]/div/ul/li[10]');

        $I->click('//*[@id="lead_country_chosen"]/a/span');
        $I->click('//*[@id="lead_country_chosen"]/div/ul/li[248]');

        $I->click('Social');
        $I->waitForText('Facebook');
        $I->fillField('lead[facebook]', 'fb.com');
        $I->fillField('lead[foursquare]', 'f4.com');
        $I->fillField('lead[googleplus]', 'gplus.com');
        $I->fillField('lead[instagram]', 'ig.com');
        $I->fillField('lead[linkedin]', 'lnk.com');
        $I->fillField('lead[skype]', 'skype.com');
        $I->fillField('lead[twitter]', 'twt.com');

        $I->click('Core');
        $I->wait(5);
        $I->click('//*[@id="lead_companies_chosen"]/ul');
        $I->click('//*[@id="lead_companies_chosen"]/div/ul/li');
        $I->waitForText('Company Name');
        $I->fillField('company[companyname]', 'New Button Company');
        $I->fillField('company[companyemail]', 'newbuttoncompany@mailinator.com');
        $I->fillField('company[companyaddress1]', 'Company Address 1');
        $I->fillField('company[companyaddress2]', 'Company Address 2');
        $I->fillField('company[companycity]', 'Miami');
        $I->fillField('company[companyzipcode]', '33178');
        $I->fillField('company[companyphone]', '3055555555');
        $I->fillField('company[companywebsite]', 'www.newbuttoncompany.com');
        $I->click('State');
        $I->click('//*[@id="company_companystate_chosen"]/div/ul/li[10]');
        $I->click('//*[@id="company_companycountry_chosen"]/a/span');
        $I->click('//*[@id="company_companycountry_chosen"]/div/ul/li[248]');
        $I->click('//div[@class="modal-form-buttons"]/button[2]');
        $I->wait(5);

        $I->click($lead['saveClose']);
        $I->wait(5);
        $I->amOnPage('s/contacts/view/1');
        $I->waitForText('ID');
        $I->click('//a[@data-target="#lead-details"]');
        $I->canSee('Mr.');
        $I->canSee('New Button');
        $I->canSee('Contact');
        $I->canSee('newbuttoncontact@mailinator');
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
        $I->wait(10);
        $I->click('Social');
        $I->canSee('Facebook');
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
        $I->click($lead['Company']);
        $I->click('//*[@id="lead_companies_chosen"]/div/ul/li');
        $I->waitForText('Company Name');
        $I->fillField('company[companyname]', 'adfadf');
        $I->wait(10);
    }
}
