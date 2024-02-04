<?php


class TestMenu
{
    function mainTestMenu()
    {
        $sFunction = __FUNCTION__;
        echo 'Start ' . $sFunction  .'<br/>';
        try {

            $oMenu = $this->testAddMenuByForm();
            if($oMenu) {
                $this->testUpdateMenuByForm($oMenu);
                $this->testDeleteMenuByForm($oMenu);
            }

            echo 'End ' . $sFunction  .'<br/>';

        } catch(Exception $e) {
            echo $e->getMessage();
            die();
        }
    }

    function testAddMenuByForm()
    {
        $_POST['inpTitleMenu'] = 'Mon menu';
        $_POST['add-menu'] = '';
        $_REQUEST['add_menu_nonce'] = wp_create_nonce('addMenu');
        /**
         * @var $oMenu RestaurantMenu
         */
        $oMenu = addMenu();
        if($oMenu && is_object($oMenu) && get_class($oMenu) === RestaurantMenu::class) {
            htmlMessageTest( __FUNCTION__);
            return $oMenu;
        }else{

            var_dump($oMenu);
            dbr($oMenu);
            htmlMessageTest( __FUNCTION__, false, ' Error');
        }
    }

    /**
     * @param $oMenu RestaurantMenu
     * @return void
     */
    function testDeleteMenuByForm($oMenu)
    {
        $_POST['delete_menu'] = '';
        $_REQUEST['delete_menu_nonce'] = wp_create_nonce('deleteMenu');
        $_POST['idMenu'] = $oMenu->getId();
        $b = deleteMenu();
        if($b === true) htmlMessageTest( __FUNCTION__);
        else{
            var_dump($b);
            dbr($b);
            htmlMessageTest( __FUNCTION__, false, ' Error');
        }
    }

    /**
     * @param $oMenu RestaurantMenu
     * @return void
     */
    function testUpdateMenuByForm($oMenu)
    {
        $_POST['id'] = $oMenu->getId();
        $_POST['title'] = 'My new title menu';
        $b = ajaxUpdateMenu();
        if($b === true) htmlMessageTest( __FUNCTION__);
        else{
            var_dump($b);
            dbr($b);
            htmlMessageTest( __FUNCTION__, false, ' Error');
        }
    }
}