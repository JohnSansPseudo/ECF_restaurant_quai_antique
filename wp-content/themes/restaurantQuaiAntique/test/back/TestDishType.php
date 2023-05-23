<?php


class TestDishType
{
    function mainTestDishType()
    {
        $sFunction = __FUNCTION__;
        echo 'Start ' . $sFunction  .'<br/>';
        try {

            /**
             * @var $oDishType DishType
             */
            $oDishType = $this->testAddDishTypeByForm();
            if($oDishType) {
                $this->testUpdateDishTypeByForm($oDishType);
                $this->testDeleteDishTypeByForm($oDishType);
            }

            echo 'End ' . $sFunction  .'<br/>';

        } catch(Exception $e) {
            echo $e->getMessage();
            die();
        }
    }

    function testAddDishTypeByForm()
    {
        $_POST['inpTitleDishType'] = 'Mon dish type';
        $_POST['add_dish_type'] = '';
        $_REQUEST['add_dish_type_nonce'] = wp_create_nonce('addDishType');
        /**
         * @var $oDishType DishType
         */
        $oDishType = addDishType();
        if($oDishType && is_object($oDishType) && get_class($oDishType) === DishType::class) {
            htmlMessageTest( __FUNCTION__);
            return $oDishType;
        }else{

            var_dump($oDishType);
            dbr($oDishType);
            htmlMessageTest( __FUNCTION__, false, ' Error');
        }

    }

    /**
     * @param $oDishType DishType
     */
    function testDeleteDishTypeByForm($oDishType)
    {
        $_POST['delete_dish_type'] = '';
        $_POST['idDishType'] = $oDishType->getId();
        $_REQUEST['delete_dish_type_nonce'] = wp_create_nonce('deleteDishType');
        $b = deleteDishType();
        if($b === true) htmlMessageTest( __FUNCTION__);
        else{
            var_dump($b);
            dbr($b);
            htmlMessageTest( __FUNCTION__, false, ' Error');
        }
    }

    /**
     * @param $oDishType DishType
     */
    function testUpdateDishTypeByForm($oDishType)
    {
        $_POST['id'] = $oDishType->getId();
        $_POST['title'] = 'My new title dish type';
        $b = ajaxUpdateDishType();
        if($b === true) htmlMessageTest( __FUNCTION__);
        else{
            var_dump($b);
            dbr($b);
            htmlMessageTest( __FUNCTION__, false, ' Error');
        }

    }

}