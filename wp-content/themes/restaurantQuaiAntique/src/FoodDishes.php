<?php


final class FoodDishes extends MotherObjTable
{

    static public function getInstance() { return new FoodDishes(); }

    static public function getTableName()
    {
        global $wpdb;
        return $wpdb->prefix . 'food_dish';
    }

    /**
     * @return bool
     */
    function createTable():bool
    {
        $oPDO = PDOSingleton::getInstance();
        $sql = "CREATE TABLE IF NOT EXISTS " . self::getTableName() . "(
                    id INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
                    idDishType INT NOT NULL,
                    title VARCHAR(50) NOT NULL,
                    description VARCHAR(250) NOT NULL,
                    price FLOAT NOT NULL,
                    FOREIGN KEY (idDishType) REFERENCES " . DishTypes::getTableName() . " (id))";
        $oStatement = $oPDO->prepare($sql);
        if(!$oStatement) return false;
        return $oStatement->execute();
    }

    /**
     * @var FoodDish $oFoodDish
     */
    public function add(object $oFoodDish)
    {
        $oPDO = PDOSingleton::getInstance();
        $oStatement = $oPDO->prepare("insert INTO " . self::getTableName() . "(idDishType, title, description, price) VALUES(:idDishType, :title, :description, :price)");
        if(!$oStatement) return false;
        $oStatement->bindValue(':idDishType', $oFoodDish->getIdDishType(), PDO::PARAM_INT);
        $oStatement->bindValue(':title', $oFoodDish->getTitle(), PDO::PARAM_STR);
        $oStatement->bindValue(':description', $oFoodDish->getDescription(), PDO::PARAM_STR);
        $oStatement->bindValue(':price', $oFoodDish->getPrice(), PDO::PARAM_STR);

        $bExec = $oStatement->execute();
        if(!$bExec) return $bExec;
        $oFoodDish->setId($oPDO->lastInsertId());
        return $oFoodDish;
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
            $oStatement->setFetchMode(PDO::FETCH_CLASS | PDO::FETCH_PROPS_LATE, 'FoodDish', array('1', '2', '3', '4', '5'));
            while ($o = $oStatement->fetch()) { $aData[$o->getId()] = $o; }
        }
        return $aData;
    }

}