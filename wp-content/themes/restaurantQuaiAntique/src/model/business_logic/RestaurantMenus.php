<?php


final class RestaurantMenus extends ManagerObjTable
{
    CONST CLASS_MANAGER = 'RestaurantMenu';

    static public function getInstance() { return new RestaurantMenus(); }

    static public function getTableName():string
    {
        global $wpdb;
        return $wpdb->prefix . 'restaurant_menu';
    }

    /**
     * @param $id int
     * @return bool
     */
    public function deleteById(int $id)
    {
        //On vérifie si l'id correspond à une entrée en BDD
        $mData = $this->getByWhere(array('id' => $id));
        if(!$mData) throw new Exception('Error this id is not in database so it cannot be delete');

        //On vérifie si aucune oOption de menus n'utilisent ce menu
        $mOptions = RestaurantMenuOptions::getInstance()->getByWhere(array('idMenu' => $id));
        if($mOptions && count($mOptions) > 0)
        {
            throw new Exception('Error this menu is associate whit option menu, please delete option(s) menu before');
        }
        else return parent::deleteById($id);//On delete
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
        $b = $oStatement->execute();
        if(!$b) {
            throw new Exception('Error get table from creating table ' . self::getTableName());
        }

        //On vérifie si la table est bien initalisée sinon on l'initialise
        $sql = "SELECT * FROM " . self::getTableName();
        $oStatement = $oPDO->prepare($sql);
        if(!$oStatement) return false;
        $b = $oStatement->execute();
        if(!$b) {
            throw new Exception('Error get table from creating table ' . self::getTableName());
        }
        $aResult = $oStatement->fetchAll(PDO::FETCH_ASSOC);
        if(is_array($aResult) && count($aResult) == 0) $this->fillLoremTable();
        return $b;
    }

    public function fillLoremTable()
    {
        $aData = array();
        $aData[] = new RestaurantMenu('Menu liberté');
        $aData[] = new RestaurantMenu('Menu plaisir');
        $aData[] = new RestaurantMenu('Menu gourmand');
        foreach($aData as $o) $this->add($o);
    }

    /**
     * @var RestaurantMenu $oRestaurantMenu
     * @return RestaurantMenu |bool
     */
    public function add($oRestaurantMenu)
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
}