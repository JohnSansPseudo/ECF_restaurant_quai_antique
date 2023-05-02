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
    public function deleteById($id)
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
        return $oStatement->execute();
    }

    /**
     * @var RestaurantMenu $oRestaurantMenu
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