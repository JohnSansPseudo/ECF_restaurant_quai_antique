<?php


final class Clients extends ManagerObjTable
{

    static public function getInstance() { return new Clients(); }

    static public function getTableName()
    {
        global $wpdb;
        return $wpdb->prefix . 'client';
    }

    /**
     * @return bool
     */
    function createTable():bool
    {
        $oPDO = PDOSingleton::getInstance();
        $sql = "CREATE TABLE IF NOT EXISTS " . self::getTableName() . " (
            id INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
            email VARCHAR(50) NOT NULL UNIQUE,
            password VARCHAR(50) NOT NULL,
            firstName VARCHAR(50) NOT NULL,
            lastName VARCHAR(50) NOT NULL,
            tel VARCHAR(10) NOT NULL,
            allergy TEXT(500))";

        $oStatement = $oPDO->prepare($sql);
        if(!$oStatement) return false;
        return $oStatement->execute();
    }

    /**
     * @return $oClient Client
     */
    public function add(object $oClient):object
    {

        $oPDO = PDOSingleton::getInstance();
        $oStatement = $oPDO->prepare("insert INTO " . self::getTableName() . "(email, password, firstName, lastName, tel, allergy)  VALUES(:email, :password, :firstName, :lastName, :tel, :allergy)");
        if(!$oStatement) return false;

        $oStatement->bindValue(':email', $oClient->getEmail(), PDO::PARAM_STR);
        $oStatement->bindValue(':password', $oClient->getPassword(), PDO::PARAM_STR);
        $oStatement->bindValue(':firstName', $oClient->getFirstName(), PDO::PARAM_STR);
        $oStatement->bindValue(':lastName', $oClient->getLastName(), PDO::PARAM_STR);
        $oStatement->bindValue(':tel', $oClient->getTelephone(), PDO::PARAM_STR);
        $oStatement->bindValue(':allergy', $oClient->getAllergy(), PDO::PARAM_STR);


        $bExec = $oStatement->execute();
        if(!$bExec) return $bExec;
        $oClient->setId($oPDO->lastInsertId());
        return $oClient;
    }

    public function getAllData()
    {
        $oPDO = PDOSingleton::getInstance();
        $oStatement = $oPDO->prepare("SELECT * FROM " . self::getTableName());
        $aData = array();
        if($oStatement->execute()){
            $oStatement->setFetchMode(PDO::FETCH_CLASS | PDO::FETCH_PROPS_LATE, 'Client', array('1', '2', '3', '4', '5', '6', 7));
            while ($o = $oStatement->fetch()) { $aData[$o->getId()] = $o; }
        }
        return $aData;
    }
}