<?php

namespace DataObjects\Contacts;

use Codeception\Util\Debug;
use Page\Acceptance\NewContactPage;

class ContactsDataObjects
{
    public $contact              = null;
    public $social               = null;
    public $company              = null;
    protected $contactPageObject = null;

    public function __construct()
    {
        $this->contactPageObject = NewContactPage::getContactPageObject();

        $this->contact = [
            'lead[title]'       => 'Mr.',
            'lead[firstname]'   => 'New Button',
            'lead[lastname]'    => 'Contact',
            'lead[email]'       => 'newbuttoncontact@mailinator.com',
            'lead[position]'    => 'CTO',
            'lead[address1]'    => 'Contact Address line 1',
            'lead[address2]'    => 'Contact Address line 2',
            'lead[city]'        => 'Orlando',
            'lead[zipcode]'     => '33195',
            'lead[attribution]' => '150',
            'lead[mobile]'      => '3059999999',
            'lead[phone]'       => '3058888888',
            'lead[fax]'         => '3057777777',
            'lead[website]'     => 'www.newbuttoncontact.com',
            'lead[points]'      => '0',
        ];
        $this->social = ['lead[facebook]' => 'fb.com',
            'lead[foursquare]'            => 'f4.com',
            'lead[googleplus]'            => 'gplus.com',
            'lead[instagram]'             => 'ig.com',
            'lead[linkedin]'              => 'lnk.com',
            'lead[skype]'                 => 'skype.com',
            'lead[twitter]'               => 'twt.com', ];

        $this->company = ['company[companyname]' => 'New Button Company',
            'company[companyemail]'              => 'newbuttoncompany@mailinator.com',
            'company[companyaddress1]'           => 'Company Address 1',
            'company[companyaddress2]'           => 'Company Address 2',
            'company[companycity]'               => 'Miami',
            'company[companyzipcode]'            => '33178',
            'company[companyphone]'              => '3055555555',
            'company[companywebsite]'            => 'www.newbuttoncompany.com', ];
    }
    public function _2NoCompany()
    {
        $this->contact = [
            'lead[title]'     => 'Mrs.',
            'lead[firstname]' => 'No Company',
            'lead[lastname]'  => 'Contact',
            'lead[email]'     => 'nocompanycontact@mailinator.com',
            'lead[position]'  => 'CPA',
            'lead[address1]'  => 'ABC Lane 1',
            'lead[address2]'  => 'ABC Lane 2',
            'lead[city]'      => 'Faux',
            'lead[zipcode]'   => '33198',
            'lead[mobile]'    => '3059999998',
            'lead[phone]'     => '3058888887',
            'lead[fax]'       => '3057777776',
            'lead[website]'   => 'www.nocompanycontact.com',
            'lead[points]'    => '10',
        ];
        $this->company = null;
    }

    public function noWebsiteContact()
    {
        unset($this->contact['lead[website]']);
    }

    public function verifyContact(\AcceptanceTester $I, $state, $country, $primaryCompany)
    {
        foreach ($this->contact as $key => $data) {
            $I->canSee($data);
        }
        if ($this->company != null) {
            $I->canSee($this->company['company[companyname]']);
            if ($primaryCompany) {
                $I->assertEquals($I->grabAttributeFrom('//*[@id="company-1"]', 'class'), 'fa fa-check primary');
            } else {
                $I->assertEquals($I->grabAttributeFrom('//*[@id="company-1"]', 'class'), 'fa fa-check');
            }
        }

        $I->canSee($state);
        $I->canSee($country);
    }
    public function verifyContactSocial(\AcceptanceTester $I)
    {
        foreach ($this->social as $key => $data) {
            $I->canSee($data);
        }
    }

    public function verifyContactCompany(\AcceptanceTester $I, $state, $country)
    {
        foreach ($this->company as $key => $data) {
            if ($key == 'company[companywebsite]') {
                $text = (substr($data, 0, 5) != 'http:') ? 'http://'.$data : $data;
                $I->canSeeInField($key,  $text);
            } else {
                $I->canSeeInField($key, $data);
            }
        }
        $I->canSee($state);
        $I->canSee($country);
    }

    public function fillContact(\AcceptanceTester $I, $state, $country)
    {
        foreach ($this->contact as $key => $data) {
            $I->fillField($key, $data);
        }
        $this->fillContactState($I, $state);
        $this->fillContactCountry($I, $country);
    }

    public function fillContactSocial(\AcceptanceTester $I)
    {
        foreach ($this->social as $key => $data) {
            $I->fillField($key, $data);
        }
    }

    public function fillContactCompany(\AcceptanceTester $I, $state, $country)
    {
        foreach ($this->company as $key => $data) {
            $I->fillField($key, $data);
        }
        $this->fillContactCompanyState($I, $state);
        $this->fillContactCompanyCountry($I, $country);
    }

    private function fillContactState(\AcceptanceTester $I, $state)
    {
        Debug::debug($this->contactPageObject);
        if (isset($state)) {
            $I->click($this->contactPageObject['contactStateField']);

            if ($state == 'CA') {
                $I->click(str_replace('$', '6', $this->contactPageObject['contactStateOption']));
            }
            if ($state == 'FL') {
                $I->click(str_replace('$', '10', $this->contactPageObject['contactStateOption']));
            }
            if ($state == 'MA') {
                $I->click(str_replace('$', '22', $this->contactPageObject['contactStateOption']));
            }
        }
    }

    private function fillContactCountry(\AcceptanceTester $I, $country)
    {
        if (isset($country)) {
            $I->click($this->contactPageObject['contactCountryField']);
            $I->click(str_replace('$', '248', $this->contactPageObject['contactCountryOption']));
        }
    }

    private function fillContactCompanyState(\AcceptanceTester $I, $state)
    {
        if (isset($state)) {
            $I->click($this->contactPageObject['companyStateField']);
            if ($state == 'CA') {
                $I->click(str_replace('$', '6', $this->contactPageObject['companyStateOption']));
            }
            if ($state == 'FL') {
                $I->click(str_replace('$', '10', $this->contactPageObject['companyStateOption']));
            }
            if ($state == 'MA') {
                $I->click(str_replace('$', '22', $this->contactPageObject['companyStateOption']));
            }
        }
    }

    private function fillContactCompanyCountry(\AcceptanceTester $I, $country)
    {
        if (isset($country)) {
            $I->click($this->contactPageObject['companyCountryField']);
            $I->click(str_replace('$', '248', $this->contactPageObject['companyCountryOption']));
        }
    }
}
