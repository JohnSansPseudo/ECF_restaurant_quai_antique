<?php


final class DishTypes extends ManagerObjTable
{
    CONST CLASS_MANAGER = 'DishType';

    static public function getInstance() { return new DishTypes(); }

    static public function getTableName():string
    {
        global $wpdb;
        return $wpdb->prefix . 'dish_type';
    }

    /**
     * @param $id
     * @return bool
     */
    public function deleteById($id)
    {
        //On vérifie si l'id correspond à une entrée en BDD
        $mData = $this->getByWhere(array('id' => $id));
        if(!$mData) throw new Exception('Error this id is not in database so it cannot be delete');

        //On vérifie si aucun plats n'utilisent ce type de plat
        $mOptions = FoodDishes::getInstance()->getByWhere(array('idDishType' => $id));
        if($mOptions && count($mOptions) > 0)
        {
            throw new Exception('Error this dish type is associate with food dish, please delete food dish before');
        }
        else return parent::deleteById($id);//On delete
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
        $b = $oStatement->execute();
        if(!$b) {
            throw new Exception('Error creating table ' . self::getTableName());
            return false;
        }

        //On vérifie si la table est bien initalisée sinon on l'initialise
        $sql = "SELECT * FROM " . self::getTableName();
        $oStatement = $oPDO->prepare($sql);
        if(!$oStatement) return false;
        $b = $oStatement->execute();
        if(!$b) {
            throw new Exception('Error get table from creating table ' . self::getTableName());
            return false;
        }
        $aResult = $oStatement->fetchAll(PDO::FETCH_ASSOC);
        if(is_array($aResult) && count($aResult) == 0) $this->fillLoremTable();
        return $b;
    }

    /**
     * @var DishType $oDishType
     */
    public function add($oDishType)
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

    public function fillLoremTable()
    {
        $aData = array();
        $aData[] = new DishType('Nos entrées');
        $aData[] = new DishType('Nos Plats');
        $aData[] = new DishType('Nos Desserts');
        foreach($aData as $o) $this->add($o);
    }

}