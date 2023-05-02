<?php
function addDishType()
{
    $sBackPath = get_admin_url() .'admin.php?page=QuaiAntiqueParam?admin_action=dish';
    if(!isset($_POST['add_dish_type'])) return false;


    if(!isset($_REQUEST['add_dish_type_nonce']) || !wp_verify_nonce($_REQUEST['add_dish_type_nonce'], 'addDishType' )){
        die('Vous n\'avez pas l\'autorisation d\'effectuer cette action. <br/><br/><a href="' . $sBackPath . '">Retour</a>');
    }

    unset($_POST['err_add_dish_type']);

    if(isset($_POST['inpTitleDishType'])){

        $sTitle = sanitize_text_field($_POST['inpTitleDishType']);
        try{
            $oDishTypeManager = new DishTypes();
            $oDishType = new DishType($sTitle);
            if(count($oDishType->getErrArray()) > 0) {
                die(implode(', ', $oDishType->getErrArray()) . '<br/><br/> Error param form add dish type, please contact an admin <br/><br/><a href="' . $sBackPath . '">Retour</a>');
            }

            $mResult = $oDishTypeManager->getByWhere(array('title' => $oDishType->getTitle()));
            if(is_array($mResult) && count($mResult) > 0) $_POST['err_add_dish_type'] = 1;
            else {
                $bAdd = $oDishTypeManager->add($oDishType);//On l'ajoute
                if(!$bAdd)  die(implode(', ', $oDishType->getErrArray()) . '<br/><br/> Error form add menu, please contact an admin <br/><br/><a href="' . $sBackPath . '">Retour</a>');
                else unset($_POST['inpTitleDishType']);
            }
        } catch(Exception $e){
            echo $e->getMessage();
            die('<br/><br/><a href="' . $sBackPath . '">Retour</a>');
        }
    } else $_POST['err_add_dish_type'] = 'Error add dish type, title is missing';


}
//header($sBackPath);
//header(wp_get_referer());