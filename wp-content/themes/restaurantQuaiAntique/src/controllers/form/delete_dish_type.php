<?php
/**
 * @return bool | string | void
 */
function deleteDishType()
{

    $sBackPath = get_admin_url() .'admin.php?page=QuaiAntiqueParam&admin_action=dish';
    if(!isset($_POST['delete_dish_type'])) return false;

    if(!isset($_REQUEST['delete_dish_type_nonce']) || !wp_verify_nonce($_REQUEST['delete_dish_type_nonce'], 'deleteDishType' )){
        die('Vous n’avez pas l’autorisation d’effectuer cette action. <br/><br/><a href="' . $sBackPath . '">Retour</a>');
    }

    unset($_POST['err_del_dish_type']);
    unset($_POST['delete_dish_type']);
    unset($_REQUEST['delete_dish_type_nonce']);

    if(isset($_POST['idDishType']) ){
        $id = intval(($_POST['idDishType']));
        try{
            $b = DishTypes::getInstance()->deleteById($id);
            if(!$b){
                $_POST['err_del_dish_type'] = 'Error delete dish type';
                if(TEST_IN_PROGESS) return $_POST['err_del_dish_type'];
            }else{
                if(TEST_IN_PROGESS) return true;
            }
        } catch(Exception $e){
            $_POST['err_del_dish_type'] = $e->getMessage();
            if(TEST_IN_PROGESS) return $_POST['err_del_dish_type'];
        }
    } else{
        $_POST['err_del_dish_type'] = 'Error delete dish type, id is missing';
        if(TEST_IN_PROGESS) return $_POST['err_del_dish_type'];
    }
}