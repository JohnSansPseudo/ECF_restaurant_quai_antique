<?php
function addMenuOption($bTest=false)
{
    $sBackPath = get_admin_url() .'admin.php?page=QuaiAntiqueParam';
    if(!isset($_POST['addMenuOption'])) return false;

    if(!isset($_REQUEST['add_menu_option_nonce']) || !wp_verify_nonce($_REQUEST['add_menu_option_nonce'], 'addMenuOption' )){
        die('Vous n’avez pas l’autorisation d’effectuer cette action. <br/><br/><a href="' . $sBackPath . '">Retour</a>');
    }

    unset($_POST['err_add_menu_option']);
    unset($_POST['addMenuOption']);
    unset($_REQUEST['add_menu_option_nonce']);

    $aParam = (object)array('idMenu' => 'selOptionMenu', 'sTitle' => 'inpTitleOption', 'sDesc' => 'txtDescOption', 'nPrice' => 'inpPriceOption');
    foreach ($aParam as $sParam){
        if(!isset($_POST[$sParam])){
            $_POST['err_add_menu_option'] = 'Error add menu option, data are missing';
            if($bTest) return $_POST['err_add_menu_option'];
        }
    }

   if(!isset($_POST['err_add_menu_option']))
    {
        $idMenu = intval(($_POST[$aParam->idMenu]));
        $sTitle = sanitize_text_field($_POST[$aParam->sTitle]);
        $sDescription = sanitize_text_field($_POST[$aParam->sDesc]);
        $fPrice = floatval($_POST[$aParam->nPrice]);
        try{
            $oOption = new RestaurantMenuOption($idMenu, $sTitle, $sDescription, $fPrice);

            if(count($oOption->getErrArray()) > 0){
                $_POST['err_add_menu_option'] = implode(', ', $oOption->getErrArray());
                if($bTest) return $_POST['err_add_menu_option'];
            }
            $bAdd = RestaurantMenuOptions::getInstance()->add($oOption);
            if(!$bAdd){
                $_POST['err_add_menu_option'] = $bAdd;
                if($bTest) return $_POST['err_add_menu_option'];
            }
            else {
                foreach ($aParam as $sParam){ unset($_POST[$sParam]); }
                if($bTest) return $bAdd;
            }
        }catch(Exception $e){
            $_POST['err_add_menu_option'] = $e->getMessage();
            if($bTest) return $_POST['err_add_menu_option'];
        }
    } else {
       if($bTest) return $_POST['err_add_menu_option'];
   }
}