<?php

use Page\Acceptance\DashboardPage as DashboardPage;
use Page\Acceptance\Login as LoginPage;

$I = new AcceptanceTester($scenario);
$I->wantTo('Login to Mautic');
$I->amOnPage(LoginPage::$URL);
$I->fillField(LoginPage::$username, 'admin');
$I->fillField(LoginPage::$password, 'admin123');
$I->click(LoginPage::$login);
$I->seeCurrentUrlEquals(DashboardPage::$URL);
