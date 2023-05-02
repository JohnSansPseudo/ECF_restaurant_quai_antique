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
        return $oStatement->execute();
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
