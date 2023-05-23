<?php

function ajaxUpdateMenu()
{
    //Si une des données necéssaire est manquante
    if(!isset($_POST['id']) || !isset($_POST['title'])) {
        return JsonAnswer::retour(0, 'Error update menu, data are missing', '');
    }

    //Sécurisation des paramètres reçues
    $id = intval(($_POST['id']));
    $sTitle = sanitize_text_field( $_POST['title']);

    //Les paramètres sont à nouveau testés par les setter de la classe menu en php
    $oMenu = new RestaurantMenu($sTitle, $id);
    //Si il y a une erreur alors on fait un retour   Json avec l'erreur
    if(count($oMenu->getErrArray()) > 0){
        if(TEST_IN_PROGESS) return join(', ', $oMenu->getErrArray());
        else return JsonAnswer::retour(0, join(', ', $oMenu->getErrArray()), '');
    }

    try{
        $b = RestaurantMenus::getInstance()->updateById($oMenu->getId(), array('title' => $oMenu->getTitle()));
        if($b === true){
            if(TEST_IN_PROGESS) return $b;
            else return JsonAnswer::retour(1, 'Menu updated', '');
        } else {
            if(TEST_IN_PROGESS) return 'Error update menu';
            else return JsonAnswer::retour(0, 'Error update menu', $b);
        }
    }catch(Exception $e){
        if(TEST_IN_PROGESS) return $e->getMessage();
        else return JsonAnswer::retour(0, 'ajaxUpdateMenu : ' . $e->getMessage(), '');
    }
}