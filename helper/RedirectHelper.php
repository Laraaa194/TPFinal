<?php

class RedirectHelper
{
    public static function redirectTo($str)
    {
        header("Location: /". $str);
        exit();
    }
}