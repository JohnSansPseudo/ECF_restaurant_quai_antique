<?php
function addDishType($bTest=false)
{

    $sBackPath = get_admin_url() .'admin.php?page=QuaiAntiqueParam?admin_action=dish';
    if(!isset($_POST['add_dish_type'])) return false;


    if(!isset($_REQUEST['add_dish_type_nonce']) || !wp_verify_nonce($_REQUEST['add_dish_type_nonce'], 'addDishType' )){
        die('Vous n\'avez pas l\'autorisation d\'effectuer cette action. <br/><br/><a href="' . $sBackPath . '">Retour</a>');
    }

    unset($_POST['add_dish_type']);
    unset($_POST['err_add_dish_type']);
    unset($_REQUEST['add_dish_type_nonce']);

    if(isset($_POST['inpTitleDishType'])){


        $sTitle = sanitize_text_field($_POST['inpTitleDishType']);
        try{
            $oDishTypeManager = new DishTypes();
            $oDishType = new DishType($sTitle);
            if(count($oDishType->getErrArray()) > 0) {
                $_POST['err_add_dish_type'] = implode(', ', $oDishType->getErrArray());
                if($bTest) return $_POST['err_add_dish_type'];
            }

            $mResult = $oDishTypeManager->getByWhere(array('title' => $oDishType->getTitle()));
            if(is_array($mResult) && count($mResult) > 0){
                $_POST['err_add_dish_type'] = 1;
                if($bTest) return 'This dish type already exist' . var_dump($mResult);
            }
            else {
                $bAdd = $oDishTypeManager->add($oDishType);//On l'ajoute
                if(!$bAdd){
                    $_POST['err_add_dish_type'] = implode(', ', $oDishType->getErrArray());
                    if($bTest) return $_POST['err_add_dish_type'];
                }
                else{
                    unset($_POST['inpTitleDishType']);
                    if($bTest) return $bAdd;
                }
            }
        } catch(Exception $e){
            $_POST['err_add_dish_type'] = $e->getMessage();
            if($bTest) return $_POST['err_add_dish_type'];
        }
    } else{
        $_POST['err_add_dish_type'] = 'Error add dish type, title is missing';
        if($bTest) return $_POST['err_add_dish_type'];
    }
}