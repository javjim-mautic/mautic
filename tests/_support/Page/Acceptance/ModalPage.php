<?php

namespace Page\Acceptance;

class ModalPage
{
    // include url of current page

    public static $SaveButton  = '//*[@id="MauticSharedModal"]/div/div/div[3]/div/button[2]';


    public static function route($param)
    {
        return static::$URL.$param;
    }
}
