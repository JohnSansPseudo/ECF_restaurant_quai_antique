<?php
function addMenu($bTest=false)
{
    $sBackPath = get_admin_url() .'admin.php?page=QuaiAntiqueParam';
    if(!isset($_POST['add-menu'])) return false;


    if(!isset($_REQUEST['add_menu_nonce']) || !wp_verify_nonce($_REQUEST['add_menu_nonce'], 'addMenu' )){
        die('Vous n\'avez pas l\'autorisation d\'effectuer cette action. <br/><br/><a href="' . $sBackPath . '">Retour</a>');
    }

    unset($_POST['err_add_menu']);
    unset($_POST['add-menu']);
    unset($_REQUEST['add_menu_nonce']);

    if(isset($_POST['inpTitleMenu'])){

        $sTitle = sanitize_text_field($_POST['inpTitleMenu']);
        try{
            $oRestaurantMenus = new RestaurantMenus();
            $oMenu = new RestaurantMenu($sTitle);
            if(count($oMenu->getErrArray()) > 0) {
                $_POST['err_add_menu'] = implode(', ', $oMenu->getErrArray());
                if($bTest) return $_POST['err_add_menu'];
            }

            $mResult = $oRestaurantMenus->getByWhere(array('title' => $oMenu->getTitle()));
            if(is_array($mResult) && count($mResult) > 0){
                $_POST['err_add_menu'] = 1;
                if($bTest) return 'This menu already exist' . var_dump($mResult);
            }
            else {
                $bAdd = RestaurantMenus::getInstance()->add($oMenu);//On l'ajoute
                if(!$bAdd){
                    $_POST['err_add_menu'] = $bAdd . '<br/><br/> Error form add menu, please contact an admin';
                    if($bTest) return $_POST['err_add_menu'];
                }
                else{
                    unset($_POST['inpTitleMenu']);
                    if($bTest) return $bAdd;
                }
            }
        } catch(Exception $e){
            $_POST['err_add_menu'] =  $e->getMessage();
            if($bTest) return $_POST['err_add_menu'];
        }
    } else{
        $_POST['err_add_menu'] = 'Error add menu, title is missing';
        if($bTest) return $_POST['err_add_menu'];
    }


}
//header($sBackPath);
//header(wp_get_referer());