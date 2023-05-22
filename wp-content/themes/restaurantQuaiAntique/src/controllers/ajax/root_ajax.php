<?php

require_once('backoffice/updateMenu.php');
require_once('backoffice/updateOptionMenu.php');
require_once('backoffice/updateDishType.php');
require_once('backoffice/updateFoodDish.php');
require_once('backoffice/updateOpeningTime.php');
require_once ('backoffice/updateImgGallery.php');
require_once ('backoffice/deleteImgGallery.php');

require_once('front/updateBookingHour.php');
require_once('front/isUserNameAdmin.php');
require_once('front/isClient.php');



//FONCTION PRINCIPALE QUI ROUTE VERS LA BONNE FONCTION
function root_ajax()
{

    //Sécurité, pour s'assurer que la requête vient bien de la page admin
    if(!isset($_REQUEST['nonce']) || !wp_verify_nonce($_REQUEST['nonce'], 'root_ajax' )){
        wp_send_json_error( "Vous n’avez pas l’autorisation d’effectuer cette action.", 403 );
    }

    unset($_REQUEST['nonce']);

    if(isset($_POST['ajax']) && is_string($_POST['ajax']) && $_POST['ajax'] !== '')
    {
        $sAjax = sanitize_text_field($_POST['ajax']);
        unset($_POST['ajax']);
        $oJSON = new JsonAnswer();
        $oJSON->setCode(0)->setMess('Not processed (fn. ' . $sAjax . ')');

        try{
            switch($sAjax){
                //BACK
                case 'updateMenu': $oJSON = ajaxUpdateMenu(); break;
                case 'updateOptionMenu': $oJSON = ajaxUpdateOptionMenu(); break;
                case 'updateDishType': $oJSON = ajaxUpdateDishType(); break;
                case 'updateFoodDish': $oJSON = ajaxUpdateFoodDish(); break;
                case 'updateOpeningTime': $oJSON = ajaxUpdateOpeningTime(); break;
                case 'updateImgGallery': $oJSON = ajaxUpdateImgGallery(); break;
                case 'deleteImgGallery': $oJSON = ajaxDeleteImgGallery(); break;
                //FRONT
                case 'updateBookingHours': $oJSON = ajaxUpdateBookingHour(); break;
                case 'isUserNameAdmin': $oJSON = ajaxIsUserNameAdmin(); break;
                case 'isClient': $oJSON = ajaxIsClient(); break;
            }
        } catch (Exception $oErr) {
            $oJSON->setMess($sAjax . ' ' . $oErr->getMessage());
        }
        wp_send_json_success($oJSON->toArray());
        exit;
    }
}