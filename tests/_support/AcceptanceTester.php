<?php

use Page\Acceptance\DashboardPage;
use Page\Acceptance\Login as LoginPage;

/**
 * Inherited Methods.
 *
 * @method void wantToTest($text)
 * @method void wantTo($text)
 * @method void execute($callable)
 * @method void expectTo($prediction)
 * @method void expect($prediction)
 * @method void amGoingTo($argumentation)
 * @method void am($role)
 * @method void lookForwardTo($achieveValue)
 * @method void comment($description)
 * @method \Codeception\Lib\Friend haveFriend($name, $actorClass = NULL)
 *
 * @SuppressWarnings(PHPMD)
 */
class AcceptanceTester extends \Codeception\Actor
{
    use _generated\AcceptanceTesterActions;

   /*
    * Define custom actions here
    */
   public function loginToMautic()
   {
       $I = $this;
       // if snapshot exists - skipping login
       if ($I->loadSessionSnapshot('login')) {
           return;
       }
       $I->amOnPage(LoginPage::$URL);
       $I->fillField(LoginPage::$username, 'admin');
       $I->fillField(LoginPage::$password, 'admin123');
       $I->click(LoginPage::$login);
       $I->seeCurrentUrlEquals(DashboardPage::$URL);

       // saving snapshot
       $I->saveSessionSnapshot('login');
   }
}
