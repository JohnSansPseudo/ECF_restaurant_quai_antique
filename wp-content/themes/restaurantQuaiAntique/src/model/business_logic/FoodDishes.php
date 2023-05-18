<?php


final class FoodDishes extends ManagerObjTable
{
    CONST CLASS_MANAGER = 'FoodDish';

    /**
     * @return FoodDishes
     */
    static public function getInstance() { return new FoodDishes(); }

    /**
     * @return string
     */
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
     * @var FoodDish $oFoodDish
     * @return FoodDish |bool
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

    public function fillLoremTable()
    {
        $aData = array();
        $aData[] = new FoodDish(1, 'Oeuf Cocotte truffes', 'Oeuf Cocotte Cuit Sur Table, Fusette Grillée Au Foie Gras & Truffes', '22');
        $aData[] = new FoodDish(1, 'Oeuf Cocotte Daurenki', 'Oeuf Cocotte Cuit Sur Table, Fusette Grillée Au Caviar Daurenki ', '19');
        $aData[] = new FoodDish(1, 'Terrine de Foie Gras', 'Terrine De Foie Gras Mi-Cuit Fait Maison, Réduction De Vinaigre Balsamique & Chutney De Figues', '23');
        $aData[] = new FoodDish(1, 'Terrine de Foie Gras', 'Carpaccio De Bar Fumé Et Mariné À La Truffe Et Sa Glace À La Truffe', '25');

        $aData[] = new FoodDish(2, 'Ris de veau', 'Ris De Veau Cuit Basse Température Braisé Rossini & Morilles', '35');
        $aData[] = new FoodDish(2, 'Carré d\'agneau', 'Carré D’agneau Rôti en Croute D’herbe Et Son Jus De Thym', '36');
        $aData[] = new FoodDish(2, 'Filet de pigeonneau', 'Filet De Pigeonneau Rossini & Truffe De Saison', '28');
        $aData[] = new FoodDish(2, 'Filet de bœuf', 'Filet De Bœuf Façon Tournedos Rossini Sauce Périgueux À La Truffe', '32');

        $aData[] = new FoodDish(3, 'Boules de glace', 'Vanille, fraise, myrtille, ananas, pêche, framboise', '6');
        $aData[] = new FoodDish(3, 'Crème brûlée', 'Crème brûlée avec caramel, pistache et framboise', '8');
        $aData[] = new FoodDish(3, 'Moelleux au chocolat', 'Moelleux au chocola, coeur fondant et sa nappe de caramel', '7');
        $aData[] = new FoodDish(3, 'Profiteroles', 'Spécialité maison, profiteroles au chocolat et crème chantilly', '6.5');

        foreach($aData as $o) $this->add($o);
    }


}