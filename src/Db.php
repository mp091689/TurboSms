<?php

namespace Mp091689\TurboSms;


use PDO;

/**
 * Class Db
 * @package Mp091689\TurboSms
 */
class Db
{
    static $instance;

    private function __construct()
    {
    }

    private function __clone()
    {
    }

    public static function getInstance($host, $name, $user, $password)
    {
        if (!(self::$instance instanceof self)) {
            $pdo_options[PDO::ATTR_ERRMODE] = PDO::ERRMODE_EXCEPTION;
            self::$instance = new PDO('mysql:host=' . $host . ';dbname=' . $name, $user, $password, $pdo_options);
        }
        return self::$instance;
    }
}