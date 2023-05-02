<?php


final class FoodDishes extends ManagerObjTable
{
    CONST CLASS_MANAGER = 'FoodDish';

    static public function getInstance() { return new FoodDishes(); }

    static public function getTableName():string
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
    public function add($oFoodDish)
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


}