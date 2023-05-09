<?php


final class RestaurantMenuOptions extends ManagerObjTable
{
    CONST CLASS_MANAGER = 'RestaurantMenuOption';

    static public function getInstance() { return new RestaurantMenuOptions(); }

    /**
     * @return string
     */
    static public function getTableName():string
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
        $aMenus = RestaurantMenus::getInstance()->getAllData();
        if(!$aMenus) return;
        $aIdMenus = array();
        foreach($aMenus as $oMenu) { $aIdMenus[] = $oMenu->getId(); }
        $aData = array();
        $aData[] = new RestaurantMenuOption($aIdMenus[0], 'Entrée + Plat' ,'Entrée<br/> au choix à la carte<br/>Plat<br/> au choix à la carte', 25.5);
        $aData[] = new RestaurantMenuOption($aIdMenus[0], 'Plat + Dessert' ,'Entrée<br/> au choix à la carte<br/>Plat<br/> au choix à la carte', 19);
        $aData[] = new RestaurantMenuOption($aIdMenus[1], 'Entrée + Plat + Dessert' ,'Entrée<br/> au choix à la carte<br/>Plat<br/> au choix à la carte<br/>Dessert<br/> au choix à la carte', 36.5);
        $aData[] = new RestaurantMenuOption($aIdMenus[2], 'Entrée + Plat' ,'Entrée<br/> au choix à la carte<br/>Plat<br/> au choix à la carte', 28);
        $aData[] = new RestaurantMenuOption($aIdMenus[2], 'Plat + Dessert' ,'Entrée<br/> au choix à la carte<br/>Plat<br/> au choix à la carte', 23);
        $aData[] = new RestaurantMenuOption($aIdMenus[2], 'Entrée + Plat + Dessert' ,'Entrée<br/> au choix à la carte<br/>Plat<br/> au choix à la carte<br/>Dessert<br/> au choix à la carte', 39);
        foreach($aData as $o) $this->add($o);
    }

    /**
     * @var RestaurantMenuOption $oMenuOption
     */
    public function add($oMenuOption)
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





}
