<?php

namespace App\Models;

/**
 * 所有模型 Models 所使用的静态方法类
 */
class Utils
{
    /**
     * 从 email 中获取 name
     */
    public static function getNameFromEmail($email)
    {
        return substr($email, 0, strripos($email, "@"));
    }

    /**
     * 使用 md5 来生成所需的 session
     */
    public static function getSessionRandomMD5()
    {
        return md5(time());
    }
}
