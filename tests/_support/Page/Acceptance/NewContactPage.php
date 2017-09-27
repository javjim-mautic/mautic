<?php

namespace Page\Acceptance;

class NewContactPage
{
    // include url of current page

    public static $URL  = '/s/contacts/new';
    public static $lead = null;

    public static function getContactPageObject()
    {
        return [
            'newButton'               => '//span[text()="New"]',
            'quickAddButton'          => '//*[@id="toolbar"]/div[1]/a[1]/span/span',
            'importButton'            => '//*[@id="toolbar"]/div[1]/ul/li[2]/a/span/span',
            'contactListLink'         => '//*[@id="leadTable"]/tbody/tr/td[$]/a/div[1]',
            'cancelButton'            => '//button[@id="lead_buttons_cancel_toolbar"]',
            'saveCloseButton'         => '//button[@id="lead_buttons_save_toolbar"]',
            'applyButton'             => '//button[@id="lead_buttons_apply_toolbar"]',
            'companyField'            => '//*[@id="lead_companies_chosen"]/ul',
            'contactCompanyOption'    => '//*[@id="lead_companies_chosen"]/div/ul/li[$]',
            'contactNewCompanyOption' => '//*[@id="lead_companies_chosen"]/div/ul/li',
            'contactStateField'       => '//*[@id="lead_state_chosen"]/a/span',
            'contactStateOption'      => '//*[@id="lead_state_chosen"]/div/ul/li[$]',
            'contactCountryField'     => '//*[@id="lead_country_chosen"]/a/span',
            'contactCountryOption'    => '//*[@id="lead_country_chosen"]/div/ul/li[$]',
            'companyStateField'       => '//*[@id="company_companystate_chosen"]/a/span',
            'companyStateOption'      => '//*[@id="company_companystate_chosen"]/div/ul/li[$]',
            'companyCountryField'     => '//*[@id="company_companycountry_chosen"]/a/span',
            'companyCountryOption'    => '//*[@id="company_companycountry_chosen"]/div/ul/li[$]',
            'saveCompanyButton'       => '//div[@class="modal-form-buttons"]/button[2]',
        ];
    }

    public static function route($param)
    {
        return static::$URL.$param;
    }
}
