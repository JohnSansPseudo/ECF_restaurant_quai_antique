<?php


final class DishTypes extends ManagerObjTable
{
    static public function getInstance() { return new DishTypes(); }

    static public function getTableName()
    {
        global $wpdb;
        return $wpdb->prefix . 'dish_type';
    }

    /**
     * @return bool
     */
    function createTable():bool
    {
        $oPDO = PDOSingleton::getInstance();
        $sql = "CREATE TABLE IF NOT EXISTS " . self::getTableName() . "(
                id INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
                title VARCHAR(50) NOT NULL UNIQUE)";
        $oStatement = $oPDO->prepare($sql);
        if(!$oStatement) return false;
        return $oStatement->execute();
    }

    /**
     * @var DishType $oDishType
     */
    public function add(object $oDishType)
    {
        $oPDO = PDOSingleton::getInstance();
        $oStatement = $oPDO->prepare("insert INTO " . self::getTableName() . "(title) VALUES(:title)");
        if(!$oStatement) return false;
        $oStatement->bindValue(':title', $oDishType->getTitle(), PDO::PARAM_STR);

        $bExec = $oStatement->execute();
        if(!$bExec) return $bExec;
        $oDishType->setId($oPDO->lastInsertId());
        return $oDishType;
    }


    /**
     * @return array
     */
    public function getAllData()
    {
        $oPDO = PDOSingleton::getInstance();
        $oStatement = $oPDO->prepare("SELECT * FROM " . self::getTableName());
        $aData = array();
        if($oStatement->execute()){
            $oStatement->setFetchMode(PDO::FETCH_CLASS | PDO::FETCH_PROPS_LATE, 'DishType', array('1', '2'));
            while ($o = $oStatement->fetch()) { $aData[$o->getId()] = $o; }
        }
        return $aData;
    }
}