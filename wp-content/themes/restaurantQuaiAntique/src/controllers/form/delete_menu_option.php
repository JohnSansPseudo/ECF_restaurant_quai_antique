<?php
function deleteMenuOption()
{
    $sBackPath = get_admin_url() .'admin.php?page=QuaiAntiqueParam';
    if(!isset($_POST['delete_menu_option'])) return false;

    if(!isset($_REQUEST['delete_menu_option_nonce']) || !wp_verify_nonce($_REQUEST['delete_menu_option_nonce'], 'deleteMenuOption' )){
        die('Vous n’avez pas l’autorisation d’effectuer cette action. <br/><br/><a href="' . $sBackPath . '">Retour</a>');
    }

    unset($_POST['err_del_menu_option']);
    unset($_POST['delete_menu_option']);
    unset($_REQUEST['delete_menu_option_nonce']);


    if(!isset($_POST['idMenuOption']) ){
        $_POST['err_del_menu_option'] = 'Error delete menu, id is missing';
        if(TEST_IN_PROGESS) return $_POST['err_del_menu_option'];
    }
    else{
        $id = intval(($_POST['idMenuOption']));
        try{
            $b = RestaurantMenuOptions::getInstance()->deleteById($id);
            if(!$b){
                $_POST['err_del_menu_option'] = 'Error please contact an admin';
                if(TEST_IN_PROGESS) return $b;
            }
            else if(TEST_IN_PROGESS) return true;
        }catch(Exception $e){
            $_POST['err_del_menu_option'] = $e->getMessage();
            if(TEST_IN_PROGESS) return $_POST['err_del_menu_option'];
        }
        if(!$b) $_POST['err_del_menu_option'] = 'Error delete menu option';
    }

}