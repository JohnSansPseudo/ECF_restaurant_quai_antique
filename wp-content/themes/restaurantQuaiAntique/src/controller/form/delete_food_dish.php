<?php

function deleteFoodDish()
{
    $sBackPath = get_admin_url() . 'admin.php?page=QuaiAntiqueParam&admin_action=dish';
    if (!isset($_POST['delete_food_dish'])) return false;

    unset($_POST['err_delete_food_dish']);

    if (!isset($_REQUEST['delete_food_dish_nonce']) || !wp_verify_nonce($_REQUEST['delete_food_dish_nonce'], 'deleteFoodDish')) {
        die('Vous n’avez pas l’autorisation d’effectuer cette action. <br/><br/><a href="' . $sBackPath . '">Retour</a>');
    }

    if (isset($_POST['idFoodDish'])) {
        $id = intval(($_POST['idFoodDish']));
        try {
            $b = FoodDishes::getInstance()->deleteById($id);
            if (!$b) $_POST['err_delete_food_dish'] = 'Error delete food dish';
        } catch (Exception $e) {
            $_POST['err_delete_food_dish'] = $e->getMessage();
        }
    } else {
        $_POST['err_delete_food_dish'] = 'Error delete food dish, id is missing';
    }
}