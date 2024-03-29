<?php


class PDOSingleton
{
    //private CONST DB_NAME = 'ecf_restaurant_quai_antique';
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
                self::$instance = new PDO('mysql:host=' . DB_HOST . ';dbname=' . DB_NAME . ';charset=' . DB_CHARSET, DB_USER, DB_PASSWORD);
            }
            catch(PDOException $oEx){
                echo $oEx->getMessage();
                echo $oEx->getTrace();
                die('Error PDO conn');
            }
        }
        return self::$instance;
    }
}