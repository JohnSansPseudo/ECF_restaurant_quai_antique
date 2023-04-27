<?php

function switch_ajax()
{
    //Sécurité, pour s'assurer que la requête vient bien de la page admin
    if(!isset($_REQUEST['nonce']) || !wp_verify_nonce($_REQUEST['nonce'], 'switch_ajax' )){
        wp_send_json_error( "Vous n’avez pas l’autorisation d’effectuer cette action.", 403 );
    }

    if(isset($_POST['ajax']) && is_string($_POST['ajax']) && $_POST['ajax'] !== '')
    {
        $sAjax = $_POST['ajax'];
        $oJSON = new JsonAnswer();
        $oJSON->setCode(0)->setMess('Not processed (fn. ' . $sAjax . ')');

        try{
            switch($_POST['ajax']){
                case 'deleteMenu': $oJSON = ajaxDeleteMenu(); break;
                case 'updateMenu': $oJSON = ajaxUpdateMenu(); break;
            }
        } catch (Exception $oErr) {
            $oJSON->setMess($_POST['ajax'] . ' ' . $oErr->getMessage());
        }
        wp_send_json_success($oJSON->toArray());
        exit;
    }


    //check_admin_referer()
    //sanitize_text_field( $_POST['name']);
}


function ajaxDeleteMenu()
{
    if(isset($_POST['id']) ){

        $id = intval(($_POST['id']));
        try{
            $b = RestaurantMenus::getInstance()->deleteById($id);
        }catch(Exception $e){
            return JsonAnswer::retour(0, 'ajaxDeleteMenu : ' . $e->getMessage(), '');
        }
        if($b === true) return JsonAnswer::retour(1, 'Delete menu complete', '');
        return JsonAnswer::retour(0, 'Error delete menu', $b);
    } else{
        return JsonAnswer::retour(0, 'Error delete menu, id is missing', '');
    }
}

function ajaxUpdateMenu()
{
    if(isset($_POST['id']) && isset($_POST['title'])){
        //Sécurisation des paramètres reçues
        $id = intval(($_POST['id']));
        $sTitle = sanitize_text_field( $_POST['title']);

        //Les paramètres sont à nouveau testés par les setter de la classe menu en php
        $oMenu = new RestaurantMenu($sTitle, $id);
        //Si il y a une erreur alors on fait un retour   Json avec l'erreur
        if(count($oMenu->getErrArray()) > 0) return JsonAnswer::retour(0, join(', ', $oMenu->getErrArray()), '');

        try{
            $b = RestaurantMenus::getInstance()->updateById($oMenu->getId(), array('title' => $oMenu->getTitle()));
        }catch(Exception $e){
            return JsonAnswer::retour(0, 'ajaxUpdateMenu : ' . $e->getMessage(), '');
        }
        if($b === true) return JsonAnswer::retour(1, 'Menu updated', '');
        return JsonAnswer::retour(0, 'Error update menu', $b);
    } else{
        return JsonAnswer::retour(0, 'Error update menu, data are missing', '');
    }
}