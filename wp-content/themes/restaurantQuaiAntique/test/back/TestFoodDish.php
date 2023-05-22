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
            if($oFoodDish) $this->deleteFoodDishByForm($oFoodDish);

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
        $oFoodDish = addFoodDish(true);
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
        $b = deleteFoodDish(true);
        if($b === true) htmlMessageTest( __FUNCTION__);
        else{
            var_dump($b);
            dbr($b);
            htmlMessageTest( __FUNCTION__, false, ' Error');
        }
    }
}