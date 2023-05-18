<?php
function deleteMenu()
{

    $sBackPath = get_admin_url() .'admin.php?page=QuaiAntiqueParam';
    if(!isset($_POST['delete_menu'])) return false;

    if(!isset($_REQUEST['delete_menu_nonce']) || !wp_verify_nonce($_REQUEST['delete_menu_nonce'], 'deleteMenu' )){
        die('Vous n’avez pas l’autorisation d’effectuer cette action. <br/><br/><a href="' . $sBackPath . '">Retour</a>');
    }

    unset($_POST['err_del_menu']);
    unset($_POST['delete_menu']);
    unset($_REQUEST['delete_menu_nonce']);

    if(isset($_POST['idMenu']) ){

        $id = intval(($_POST['idMenu']));
        try{ RestaurantMenus::getInstance()->deleteById($id); }
        catch(Exception $e){ $_POST['err_del_menu'] = $e->getMessage(); }
    } else{
        $_POST['err_del_menu'] = 'Error delete menu, id is missing';
    }
}