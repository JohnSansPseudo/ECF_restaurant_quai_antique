<?php


class PDOSingleton
{
    private CONST DB_NAME = 'ecf_restaurant_quai_antique';
    private static PDO $instance;

    private function __construct()
    {
    }

    private function __clone()
    {
    }

    public static function getInstance():PDO
    {
        if (!isset(self::$instance)) {
            try{
                self::$instance = new PDO('mysql:host=localhost;dbname=ecf_restaurant_quai_antique;charset=utf8', 'root', '');
            }
            catch(PDOException $oEx){
                echo $oEx->getMessage();
                die('Error PDO conn');
            }
        }
        return self::$instance;
    }
}