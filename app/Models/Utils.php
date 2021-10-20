<?php

namespace App\Models;

class Utils
{
    public static function getNameFromEmail($email)
    {
        return substr($email, 0, strripos($email, "@"));
    }

    public static function getSessionRandomMD5()
    {
        return md5(time());
    }
}
