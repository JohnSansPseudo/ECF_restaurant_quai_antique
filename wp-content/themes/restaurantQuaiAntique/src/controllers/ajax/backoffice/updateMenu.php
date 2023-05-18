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
    if(count($oMenu->getErrArray()) > 0) return JsonAnswer::retour(0, join(', ', $oMenu->getErrArray()), '');

    try{
        $b = RestaurantMenus::getInstance()->updateById($oMenu->getId(), array('title' => $oMenu->getTitle()));
    }catch(Exception $e){
        return JsonAnswer::retour(0, 'ajaxUpdateMenu : ' . $e->getMessage(), '');
    }
    if($b === true) return JsonAnswer::retour(1, 'Menu updated', '');
    return JsonAnswer::retour(0, 'Error update menu', $b);

}