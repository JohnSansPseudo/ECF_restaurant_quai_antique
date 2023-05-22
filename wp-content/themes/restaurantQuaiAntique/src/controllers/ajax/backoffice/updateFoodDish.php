<?php

function ajaxUpdateFoodDish()
{
    //Si une des données necéssaire est manquante
    if(!isset($_POST['id']) || !isset($_POST['field']) || !isset($_POST['value'])) {
        return JsonAnswer::retour(0, 'Error update food dish, data are missing', '');
    }

    //Sécurisation des paramètres reçues
    $idFoodDish = intval(($_POST['id']));
    /**
     * @var FoodDish $oFoodDish
     */
    $oFoodDish = null;
    //On vérifie que l'option existe en base et on la récupère
    $aFoodDish = FoodDishes::getInstance()->getByWhere(array('id' => $idFoodDish));
    if($aFoodDish && is_array($aFoodDish)){
        $oFoodDish = array_pop($aFoodDish);
    }else return JsonAnswer::retour(0, 'Error id food dish is not exist in database', '');

    if(count($oFoodDish->getErrArray()) > 0){
        return JsonAnswer::retour(0, join(', ', $oFoodDish->getErrArray()), '');
    }

    $sField = sanitize_text_field( $_POST['field']);
    $mValue = null;
    $aDataUpdate = array();
    $aField = FoodDishes::getArrayField();

    switch($sField)
    {
        //array(1 => 'idDishType', 2 => 'title', 3 => 'description', 4 => 'price');
        case '1':
            $mValue = intval($_POST['value']);
            $oFoodDish->setIdDishType($mValue);
            if(count($oFoodDish->getErrArray()) > 0){
                return JsonAnswer::retour(0, join(', ', $oFoodDish->getErrArray()), '');
            }
            $aDataUpdate[$aField[$sField]] = $oFoodDish->getIdDishType();
            break;
        case '2':
            $mValue = sanitize_text_field( $_POST['value']);
            $oFoodDish->setTitle($mValue);
            if(count($oFoodDish->getErrArray()) > 0){
                return JsonAnswer::retour(0, join(', ', $oFoodDish->getErrArray()), '');
            }
            $aDataUpdate[$aField[$sField]] = $oFoodDish->getTitle();
            break;
        case '3':
            $mValue = sanitize_text_field( $_POST['value']);
            $oFoodDish->setDescription($mValue);
            if(count($oFoodDish->getErrArray()) > 0){
                return JsonAnswer::retour(0, join(', ', $oFoodDish->getErrArray()), '');
            }
            $aDataUpdate[$aField[$sField]] = $oFoodDish->getDescription();
            break;
        case '4':
            $mValue = floatval($_POST['value']);
            $oFoodDish->setPrice($mValue);
            if(count($oFoodDish->getErrArray()) > 0){
                return JsonAnswer::retour(0, join(', ', $oFoodDish->getErrArray()), '');
            }
            $aDataUpdate[$aField[$sField]] = $oFoodDish->getPrice();
            break;
        default: return JsonAnswer::retour(0, 'Error switch update food dish $sField(' . $sField . ') is unknow', '');
    }

    try{
        $b = FoodDishes::getInstance()->updateById($oFoodDish->getId(), $aDataUpdate);
    }catch(Exception $e){
        return JsonAnswer::retour(0, 'Error ajaxUpdateFoodDIsh : ' . $e->getMessage(), '');
    }
    if($b === true) return JsonAnswer::retour(1, 'Food dish updated', '');
    return JsonAnswer::retour(0, 'Error update food dish', $b);
}