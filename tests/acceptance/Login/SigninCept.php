<?php

use Page\Acceptance\DashboardPage as DashboardPage;
use Page\Acceptance\Login as LoginPage;

$I = new AcceptanceTester($scenario);
$I->wantTo('Login to Mautic');
$I->amOnPage(LoginPage::$URL);
$I->fillField(LoginPage::$username, $_ENV['MAUTIC_ADMIN_USERNAME']);
$I->fillField(LoginPage::$password, $_ENV['MAUTIC_ADMIN_PASSWORD']);
$I->click(LoginPage::$login);
$I->seeCurrentUrlEquals(DashboardPage::$URL);
