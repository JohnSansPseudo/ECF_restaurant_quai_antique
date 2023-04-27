<?php


final class RestaurantMenus extends ManagerObjTable
{
    static public function getInstance() { return new RestaurantMenus(); }

    static public function getTableName()
    {
        global $wpdb;
        return $wpdb->prefix . 'restaurant_menu';
    }

    /**
     * @param $id int
     * @return bool
     */
    public function deleteById($id)
    {
        $oPDO = PDOSingleton::getInstance();

        //On vérifie si l'id correspond à une entrée en BDD
        $mData = $this->getByWhere(array('id' => $_POST['id']));
        if(!$mData) throw new Exception('Error this id is not in database so it cannot be delete');

        //On vérifie si aucune oOption de menus n'utilisent ce menu
        $mOptions = RestaurantMenuOptions::getInstance()->getByWhere(array('idMenu' => $id));
        if($mOptions)
        {
            throw new Exception('Error this menu is associate whit option menu, please delete option(s) menu before');
        }
        $oStatement = $oPDO->prepare("DELETE FROM " . static::getTableName() . " WHERE id=:id");
        $oStatement->bindParam(':id', $id, PDO::PARAM_INT);
        return $oStatement->execute();
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

    /*
     * @return array
     */
    public function getAllData():array
    {
        $oPDO = PDOSingleton::getInstance();
        $oStatement = $oPDO->prepare("SELECT * FROM " . self::getTableName());
        return $this->statementGetExecute($oStatement);
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
        $oStatement->setFetchMode(PDO::FETCH_CLASS | PDO::FETCH_PROPS_LATE, 'RestaurantMenu', array('1', '2'));
        while ($o = $oStatement->fetch()) { $aData[$o->getId()] = $o; }
        if(count($aData) === 1) return array_pop($aData);
        return $aData;
    }
}