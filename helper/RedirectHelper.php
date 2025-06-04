<?php

class RedirectHelper
{
    public static function redirectTo($str)
    {
        header("Location: ".BASE_URL. $str);
        exit();
    }
}