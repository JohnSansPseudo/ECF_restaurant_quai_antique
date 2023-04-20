<?php


final class RestaurantMenus extends MotherObjTable
{
    static public function getInstance() { return new RestaurantMenus(); }

    static public function getTableName()
    {
        global $wpdb;
        return $wpdb->prefix . 'restaurant_menu';
    }

    /**
     * @return bool
     */
    public function createTable():bool
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
     * @var RestaurantMenu $oRestaurantMenu
     */
    public function add(object $oRestaurantMenu):object
    {

        $oPDO = PDOSingleton::getInstance();
        $oStatement = $oPDO->prepare("insert INTO " . self::getTableName() . "(title) VALUES(:title)");
        if(!$oStatement) return false;
        $oStatement->bindValue(':title', $oRestaurantMenu->getTitle(), PDO::PARAM_STR);
        $bExec = $oStatement->execute();
        if(!$bExec) return $bExec;
        $oRestaurantMenu->setId($oPDO->lastInsertId());
        return $oRestaurantMenu;
    }

    public function getAllData()
    {
        $oPDO = PDOSingleton::getInstance();
        $oStatement = $oPDO->prepare("SELECT * FROM " . self::getTableName());
        $aData = array();
        if($oStatement->execute()){
            $oStatement->setFetchMode(PDO::FETCH_CLASS | PDO::FETCH_PROPS_LATE, 'RestaurantMenu', array('1', '2'));
            while ($o = $oStatement->fetch()) { $aData[$o->getId()] = $o; }
        }
        return $aData;
    }
}