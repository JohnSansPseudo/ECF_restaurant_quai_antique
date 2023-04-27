<?php


final class RestaurantMenuOptions extends ManagerObjTable
{
    static public function getInstance() { return new RestaurantMenuOptions(); }

    /**
     * @return string
     */
    static public function getTableName()
    {
        global $wpdb;
        return $wpdb->prefix . 'restaurant_menu_option';
    }

    /**
     * @return bool
     */
    function createTable():bool
    {
        $oPDO = PDOSingleton::getInstance();
        $sql = "CREATE TABLE IF NOT EXISTS " . self::getTableName() . " (
                    id INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
                    idMenu INT NOT NULL,
                    title VARCHAR(50) NOT NULL,
                    description VARCHAR(250) NOT NULL,
                    price FLOAT NOT NULL,
                    FOREIGN KEY (idMenu) REFERENCES " . RestaurantMenus::getTableName() . " (id))";

        $oStatement = $oPDO->prepare($sql);
        if(!$oStatement) return false;
        return $oStatement->execute();
    }

    /**
     * @var RestaurantMenuOption $oMenuOption
     */
    public function add(object $oMenuOption):object
    {

        $oPDO = PDOSingleton::getInstance();
        $oStatement = $oPDO->prepare("insert INTO " . self::getTableName() . "(idMenu, title, description, price) VALUES(:idMenu, :title, :description, :price)");
        if(!$oStatement) return false;
        $oStatement->bindValue(':idMenu', $oMenuOption->getIdMenu(), PDO::PARAM_INT);
        $oStatement->bindValue(':title', $oMenuOption->getTitle(), PDO::PARAM_STR);
        $oStatement->bindValue(':description', $oMenuOption->getDescription(), PDO::PARAM_STR);
        $oStatement->bindValue(':price', $oMenuOption->getPrice(), PDO::PARAM_STR);
        $bExec = $oStatement->execute();
        if(!$bExec) return $bExec;
        $oMenuOption->setId($oPDO->lastInsertId());
        return $oMenuOption;
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
            $oStatement->setFetchMode(PDO::FETCH_CLASS | PDO::FETCH_PROPS_LATE, 'RestaurantMenuOption', array('1', '2', '3', '4', '5'));
            while ($o = $oStatement->fetch()) { $aData[$o->getId()] = $o; }
        }
        return $aData;
    }

    /**
     * @param $aParam array
     * @return array | bool
     */
    public function getByWhere($aParam)
    {
        $oPDO = PDOSingleton::getInstance();
        $aDataRem = array();
        foreach($aParam as $key => $val) { $aDataRem[] = $key . '=:' . $key; }
        $sData = join(' AND ', $aDataRem);

        $oStatement = $oPDO->prepare("SELECT * FROM " . self::getTableName() . " WHERE " . $sData);
        foreach($aParam as $k => $v)
        {
            $oStatement->bindValue(':' . $k, $v);
        }
        return $this->statementGetExecute($oStatement);
    }

    /**
     * @param $oStatement PDOStatement
     * @return array | bool
     */
    private function statementGetExecute($oStatement)
    {
        //dbrDie($oStatement->queryString);
        $bExec = $oStatement->execute();

        if(!$bExec) return $bExec;

        $aData = array();
        $oStatement->setFetchMode(PDO::FETCH_CLASS | PDO::FETCH_PROPS_LATE, 'RestaurantMenuOption', array('1', '2', '3', '4', '5'));
        while ($o = $oStatement->fetch()) { $aData[$o->getId()] = $o; }
        if(count($aData) === 1) return array_pop($aData);
        return $aData;
    }
}
