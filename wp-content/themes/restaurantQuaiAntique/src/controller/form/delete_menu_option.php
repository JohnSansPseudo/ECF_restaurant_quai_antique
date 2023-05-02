<?php
function deleteMenuOption()
{
    $sBackPath = get_admin_url() .'admin.php?page=QuaiAntiqueParam';
    if(!isset($_POST['delete_menu_option'])) return false;

    unset($_POST['err_del_menu_option']);

    if(!isset($_REQUEST['delete_menu_option_nonce']) || !wp_verify_nonce($_REQUEST['delete_menu_option_nonce'], 'deleteMenuOption' )){
        die('Vous n’avez pas l’autorisation d’effectuer cette action. <br/><br/><a href="' . $sBackPath . '">Retour</a>');
    }

    if(!isset($_POST['idMenuOption']) )$_POST['err_del_menu_option'] = 'Error delete menu, id is missing';
    else{
        $id = intval(($_POST['idMenuOption']));
        try{
            $b = RestaurantMenuOptions::getInstance()->deleteById($id);
        }catch(Exception $e){
            $_POST['err_del_menu'] = $e->getMessage();
        }
        if(!$b) $_POST['err_del_menu'] = 'Error delete menu option';
    }

}