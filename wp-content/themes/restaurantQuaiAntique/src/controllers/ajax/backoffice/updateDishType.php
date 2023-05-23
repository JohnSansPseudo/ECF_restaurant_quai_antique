<?php

function ajaxUpdateDishType()
{
    //Si une des données necéssaire est manquante
    if(!isset($_POST['id']) || !isset($_POST['title'])) {
        return JsonAnswer::retour(0, 'Error update dish type, data are missing', '');
    }

    //Sécurisation des paramètres reçues
    $id = intval(($_POST['id']));
    $sTitle = sanitize_text_field( $_POST['title']);

    //Les paramètres sont à nouveau testés par les setter de la classe menu en php
    $oDishType = new DishType($sTitle, $id);
    //Si il y a une erreur alors on fait un retour   Json avec l'erreur
    if(count($oDishType->getErrArray()) > 0){
        if(TEST_IN_PROGESS) return join(', ', $oDishType->getErrArray());
        else return JsonAnswer::retour(0, join(', ', $oDishType->getErrArray()), '');
    }

    try{
        $b = DishTypes::getInstance()->updateById($oDishType->getId(), array('title' => $oDishType->getTitle()));
        if($b === true){
            if(TEST_IN_PROGESS) return $b;
            else return JsonAnswer::retour(1, 'Dish type updated', '');
        } else {
            if(TEST_IN_PROGESS) return 'Error update dish type';
            return JsonAnswer::retour(0, 'Error update dish type', $b);
        }
    }catch(Exception $e){
        if(TEST_IN_PROGESS) return $e->getMessage();
        else return JsonAnswer::retour(0, 'ajaxUpdateDishTpye : ' . $e->getMessage(), '');
    }

}