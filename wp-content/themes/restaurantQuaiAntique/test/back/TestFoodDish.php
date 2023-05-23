<?php


class TestFoodDish
{
    function mainTestFoodDish()
    {
        $sFunction = __FUNCTION__;
        echo 'Start ' . $sFunction  .'<br/>';
        try {

            /**
             * @var $oFoodDish FoodDish
             */
            $oFoodDish = $this->testAddFoodDish();
            if($oFoodDish){
                $this->testUpdateFoodDishByForm($oFoodDish);
                $this->deleteFoodDishByForm($oFoodDish);
            }

            echo 'End ' . $sFunction  .'<br/>';

        } catch(Exception $e) {
            echo $e->getMessage();
            die();
        }
    }

    public function testAddFoodDish()
    {
        $_POST['selOptionDishType'] = 2;
        $_POST['inpTitleFoodDish'] = 'Mon Food dish';
        $_POST['txtDescFoodDish'] = 'Mon Food dish desc';
        $_POST['inpPriceFoodDish'] = 25.5;
        $_POST['addFoodDish'] = '';
        $_REQUEST['add_food_dish_nonce'] = wp_create_nonce('addFoodDish');
        /**
         * @var $oFoodDish FoodDish
         */
        $oFoodDish = addFoodDish();
        if($oFoodDish && is_object($oFoodDish) && get_class($oFoodDish) === FoodDish::class) {
            htmlMessageTest( __FUNCTION__);
            return $oFoodDish;
        }else{

            var_dump($oFoodDish);
            dbr($oFoodDish);
            htmlMessageTest( __FUNCTION__, false, ' Error');
        }
    }

    /**
     * @param $oFoodDish FoodDish
     */
    public function deleteFoodDishByForm($oFoodDish)
    {
        $_POST['delete_food_dish'] = '';
        $_REQUEST['delete_food_dish_nonce'] = wp_create_nonce('deleteFoodDish');
        $_POST['idFoodDish'] = $oFoodDish->getId();
        $b = deleteFoodDish();
        if($b === true) htmlMessageTest( __FUNCTION__);
        else{
            var_dump($b);
            dbr($b);
            htmlMessageTest( __FUNCTION__, false, ' Error');
        }
    }

    /**
     * @param $oFoodDish FoodDish
     */
    public function testUpdateFoodDishByForm($oFoodDish)
    {
        //array(1 => 'idDishType', 2 => 'title', 3 => 'description', 4 => 'price');
        $aField = FoodDishes::getArrayField();
        $this->testUpdateFieldFoodDishByForm($oFoodDish->getId(), 1, 3, $aField[1]);
        $this->testUpdateFieldFoodDishByForm($oFoodDish->getId(), 2, 'Mon title test', $aField[2]);
        $this->testUpdateFieldFoodDishByForm($oFoodDish->getId(), 3, 'Ma desc test', $aField[3]);
        $this->testUpdateFieldFoodDishByForm($oFoodDish->getId(), 4, 55.6, $aField[4]);

    }

    public function testUpdateFieldFoodDishByForm($id, $iField, $mValue, $sField)
    {
        $_POST['id'] = $id;
        $_POST['field'] = $iField;
        $_POST['value'] = $mValue;
        $b = ajaxUpdateFoodDish();
        if($b === true) htmlMessageTest( __FUNCTION__, true, 'ok => ' . $sField);
        else{
            var_dump($b);
            dbr($b);
            htmlMessageTest( __FUNCTION__, false, ' Error => ' . $sField);
        }
    }

}