<?php


class TestMenuOption
{
    function mainTestMenuOption()
    {
        $sFunction = __FUNCTION__;
        echo 'Start ' . $sFunction  .'<br/>';
        try {

            /**
             * @var $oMenuOption RestaurantMenuOption
             */
            $oMenuOption = $this->testAddMenuOption();
            if($oMenuOption)
            {
                $this->testUpdateOptionMenuByForm($oMenuOption);
                $this->deleteOptionMenuByForm($oMenuOption);
            }
            echo 'End ' . $sFunction  .'<br/>';

        } catch(Exception $e) {
            echo $e->getMessage();
            die();
        }
    }

    public function testAddMenuOption()
    {
        // $aParam = (object)array('idMenu' => 'selOptionMenu', 'sTitle' => 'inpTitleOption', 'sDesc' => 'txtDescOption', 'nPrice' => 'inpPriceOption');
        $_POST['selOptionMenu'] = 2;
        $_POST['inpTitleOption'] = 'Mon option de menu';
        $_POST['txtDescOption'] = 'Mon option de menu desc';
        $_POST['inpPriceOption'] = 25.5;
        $_POST['addMenuOption'] = '';
        $_REQUEST['add_menu_option_nonce'] = wp_create_nonce('addMenuOption');
        /**
         * @var $oMenuOption RestaurantMenuOption
         */
        $oMenuOption = addMenuOption();
        if($oMenuOption && is_object($oMenuOption) && get_class($oMenuOption) === RestaurantMenuOption::class) {
            htmlMessageTest( __FUNCTION__);
            return $oMenuOption;
        }else{
            var_dump($oMenuOption);
            dbr($oMenuOption);
            htmlMessageTest( __FUNCTION__, false, ' Error');
        }
    }

    /**
     * @param $oMenuOption RestaurantMenuOption
     */
    public function deleteOptionMenuByForm($oMenuOption)
    {
        $_POST['idMenuOption'] = $oMenuOption->getId();
        $_POST['delete_menu_option'] = '';
        $_REQUEST['delete_menu_option_nonce'] = wp_create_nonce('deleteMenuOption');
        $b = deleteMenuOption();
        if($b === true) htmlMessageTest( __FUNCTION__);
        else{
            var_dump($b);
            dbr($b);
            htmlMessageTest( __FUNCTION__, false, ' Error');
        }
    }

    /**
     * @param $oMenuOption RestaurantMenuOption
     */
    public function testUpdateOptionMenuByForm($oMenuOption)
    {
        //return array(1 => 'idMenu', 2 => 'title', 3 => 'description', 4 => 'price');
        $aField = RestaurantMenuOptions::getArrayField();
        $this->testUpdateFieldOptionMenuByForm($oMenuOption->getId(), 1, 3, $aField[1]);
        $this->testUpdateFieldOptionMenuByForm($oMenuOption->getId(), 2, 'Mon title test option menu', $aField[2]);
        $this->testUpdateFieldOptionMenuByForm($oMenuOption->getId(), 3, 'Ma desc test option menu', $aField[3]);
        $this->testUpdateFieldOptionMenuByForm($oMenuOption->getId(), 4, 58.9, $aField[4]);
    }

    public function testUpdateFieldOptionMenuByForm($id, $iField, $mValue, $sField)
    {
        $_POST['id'] = $id;
        $_POST['field'] = $iField;
        $_POST['value'] = $mValue;
        $b = ajaxUpdateOptionMenu();
        if($b === true) htmlMessageTest( __FUNCTION__, true, 'ok => ' . $sField);
        else{
            var_dump($b);
            dbr($b);
            htmlMessageTest( __FUNCTION__, false, ' Error => ' . $sField);
        }
    }
}