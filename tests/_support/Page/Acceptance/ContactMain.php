<?php

namespace Page\Acceptance;

class ContactMain
{
    // include url of current page

    public static $URL       = '/s/contacts';
    public static $lead      = null;
    public static $NewButton = '//span[text()="New"]';

    public static function getLeadPageObject()
    {
        return [
            'title'       => "//input[@id='lead_title']",
            'firstname'   => '//input[@id="lead_firstname"]',
            'lastname'    => '//input[@id="lead_lastname"]',
            'email'       => '//input[@id="lead_email"]',
            'position'    => '//input[@id="lead_position"]',
            'address1'    => '//input[@id="lead_address1"]',
            'address2'    => '//input[@id="lead_address2"]',
            'city'        => '//input[@id="lead_city"]',
            'zipcode'     => '//input[@id="lead_zipcode"]',
            'attribution' => '//input[@id="lead_attribution"]',
            'mobile'      => '//input[@id="lead_mobile"]',
            'phone'       => '//input[@id="lead_phone"]',
            'points'      => '//input[@id="lead_points"]',
            'fax'         => '//input[@id="lead_fax"]',
            'website'     => '//input[@id="lead_website"]',
            'facebook'    => '//input[@id="lead_facebook"]',
            'foursquare'  => '//input[@id="lead_foursquare"]',
            'googleplus'  => '//input[@id="lead_googleplus"]',
            'instagram'   => '//input[@id="lead_instagram"]',
            'linkedin'    => '//input[@id="lead_linkedin"]',
            'skype'       => '//input[@id="lead_skype"]',
            'twitter'     => '//input[@id="lead_twitter"]',
            'cancel'      => '//button[@id="lead_buttons_cancel_toolbar"]',
            'saveClose'   => '//button[@id="lead_buttons_save_toolbar"]',
            'apply'       => '//button[@id="lead_buttons_apply_toolbar"]',
            'Company'     => '//*[@id="lead_companies_chosen"]/ul/li/input',
            'NewCompany'  => '//*[@id="lead_companies_chosen"]/div/ul/li',
            'State'       => '//*[@id="lead_state_chosen"]/a/span',
        ];
        // //*[@id="lead_state_chosen"]/div/ul/li[28]
    }
    /**
     * Declare UI map for this page here. CSS or XPath allowed.
     * public static $usernameField = '#username';
     * public static $formSubmitButton = "#mainForm input[type=submit]";.
     */

    /**
     * Basic route example for your current URL
     * You can append any additional parameter to URL
     * and use it in tests like: Page\Edit::route('/123-post');.
     */
    public static function route($param)
    {
        return static::$URL.$param;
    }
}
