<?php

function addFoodDish()
{

    $sBackPath = get_admin_url() .'admin.php?page=QuaiAntiqueParam&admin_action=dish';
    if(!isset($_POST['addFoodDish'])) return false;

    if(!isset($_REQUEST['add_food_dish_nonce']) || !wp_verify_nonce($_REQUEST['add_food_dish_nonce'], 'addFoodDish' )){
        die('Vous n’avez pas l’autorisation d’effectuer cette action. <br/><br/><a href="' . $sBackPath . '">Retour</a>');
    }

    unset($_POST['err_add_food_dish']);
    unset($_POST['addFoodDish']);
    unset($_REQUEST['add_food_dish_nonce']);


    $aParam = (object)array('idDishType' => 'selOptionDishType', 'sTitle' => 'inpTitleFoodDish', 'sDesc' => 'txtDescFoodDish', 'price' => 'inpPriceFoodDish');
    foreach ($aParam as $sParam){
        if(!isset($_POST[$sParam])){
            $_POST['err_add_food_dish'] = 'Error add food dish, data are missing';
            if(TEST_IN_PROGESS) return  $_POST['err_add_food_dish'];
        }
    }

    if(!isset($_POST['err_add_food_dish']))
    {
        $idFoodDish = intval(($_POST[$aParam->idDishType]));
        $sTitle = sanitize_text_field($_POST[$aParam->sTitle]);
        $sDescription = sanitize_text_field($_POST[$aParam->sDesc]);
        $fPrice = floatval($_POST[$aParam->price]);

        try{
            $oFoodDish = new FoodDish($idFoodDish, $sTitle, $sDescription, $fPrice);

            if(count($oFoodDish->getErrArray()) > 0){
                $_POST['err_add_food_dish'] = implode(', ', $oFoodDish->getErrArray());
                if(TEST_IN_PROGESS) return  $_POST['err_add_food_dish'];
            }else {
                $bAdd = FoodDishes::getInstance()->add($oFoodDish);
                if(!$bAdd){
                    $_POST['err_add_food_dish'] = $bAdd;
                    if(TEST_IN_PROGESS) return $_POST['err_add_food_dish'];
                }
                else{
                    foreach ($aParam as $sParam){ unset($_POST[$sParam]); }
                    if(TEST_IN_PROGESS) return $bAdd;
                }
            }

        }catch(Exception $e){
            $_POST['err_add_food_dish'] = $e->getMessage();
            if(TEST_IN_PROGESS) return $_POST['err_add_food_dish'];
        }
    } else{
        if(TEST_IN_PROGESS) return  $_POST['err_add_food_dish'];
    }
}
