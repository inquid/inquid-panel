<?php

namespace inquid\panel;

use yii\base\Component;


class Utilities extends Component
{
    public static function getIp()
    {
        $ip = file_get_contents('https://api.ipify.org');
        return "The public IP address is: " . $ip;
    }
    public static function getDsnAttribute($name, $dsn)
    {
        if (preg_match('/' . $name . '=([^;]*)/', $dsn, $match)) {
            return $match[1];
        } else {
            return null;
        }
    }
}