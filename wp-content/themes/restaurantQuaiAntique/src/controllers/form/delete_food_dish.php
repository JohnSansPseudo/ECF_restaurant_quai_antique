<?php
/**
 * @param bool $bTest
 * @return bool|string | void
 */
function deleteFoodDish($bTest=false)
{
    $sBackPath = get_admin_url() . 'admin.php?page=QuaiAntiqueParam&admin_action=dish';
    if (!isset($_POST['delete_food_dish'])) return false;

    if (!isset($_REQUEST['delete_food_dish_nonce']) || !wp_verify_nonce($_REQUEST['delete_food_dish_nonce'], 'deleteFoodDish')) {
        die('Vous n’avez pas l’autorisation d’effectuer cette action. <br/><br/><a href="' . $sBackPath . '">Retour</a>');
    }

    unset($_POST['err_delete_food_dish']);
    unset($_POST['delete_food_dish']);
    unset($_REQUEST['delete_food_dish_nonce']);

    if (isset($_POST['idFoodDish'])) {
        $id = intval(($_POST['idFoodDish']));
        try {
            $b = FoodDishes::getInstance()->deleteById($id);
            if (!$b){
                $_POST['err_delete_food_dish'] = 'Error delete food dish';
                if($bTest) return $_POST['err_delete_food_dish'];
            }else{
                if($bTest) return true;
            }
        } catch (Exception $e) {
            $_POST['err_delete_food_dish'] = $e->getMessage();
            if($bTest) return $_POST['err_delete_food_dish'];
        }
    } else {
        $_POST['err_delete_food_dish'] = 'Error delete food dish, id is missing';
        if($bTest) return $_POST['err_delete_food_dish'];
    }
}