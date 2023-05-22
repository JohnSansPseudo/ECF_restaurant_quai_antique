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
        $oMenuOption = addMenuOption(true);
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
        $b = deleteMenuOption(true);
        if($b === true) htmlMessageTest( __FUNCTION__);
        else{
            var_dump($b);
            dbr($b);
            htmlMessageTest( __FUNCTION__, false, ' Error');
        }
    }
}