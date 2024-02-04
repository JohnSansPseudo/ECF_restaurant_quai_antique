<?php


final class Clients extends ManagerObjTable
{
    CONST CLASS_MANAGER = 'Client';

    static public function getInstance() { return new Clients(); }

    static public function getTableName():string
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
            allergy TEXT(500),
            nbGuest INT NOT NULL)";

        $oStatement = $oPDO->prepare($sql);
        if(!$oStatement) return false;
        return $oStatement->execute();
    }



    /**
     * @param $oClient Client
     * @return Client | bool
     */
    public function add($oClient)
    {
        $oPDO = PDOSingleton::getInstance();
        $oStatement = $oPDO->prepare(
            "insert INTO " . self::getTableName() . "(email, password, firstName, lastName, tel, allergy, nbGuest)  
            VALUES(:email, :password, :firstName, :lastName, :tel, :allergy, :nbGuest)");
        if(!$oStatement) return false;

        $oStatement->bindValue(':email', $oClient->getEmail(), PDO::PARAM_STR);
        $oStatement->bindValue(':password', $oClient->getPassword(), PDO::PARAM_STR);
        $oStatement->bindValue(':firstName', $oClient->getFirstName(), PDO::PARAM_STR);
        $oStatement->bindValue(':lastName', $oClient->getLastName(), PDO::PARAM_STR);
        $oStatement->bindValue(':tel', $oClient->getTel(), PDO::PARAM_STR);
        $oStatement->bindValue(':allergy', $oClient->getAllergy(), PDO::PARAM_STR);
        $oStatement->bindValue(':nbGuest', $oClient->getNbGuest(), PDO::PARAM_INT);

        $bExec = $oStatement->execute();
        if(!$bExec) return $bExec;
        $oClient->setId($oPDO->lastInsertId());
        return $oClient;
    }

    /**
     * @param $oState PDOStatement
     * @return array | bool
     */
    public function statementGetExecute($oState)
    {
        $bExec = $oState->execute();
        if(!$bExec) return $bExec;
        $aData = array();
        while ($o = $oState->fetch(PDO::FETCH_OBJ))
        {
            $aData[$o->id] = new Client($o->firstName, $o->lastName, $o->tel, $o->email, $o->allergy, $o->password, $o->nbGuest, $o->id);
        }
        return $aData;
    }

}