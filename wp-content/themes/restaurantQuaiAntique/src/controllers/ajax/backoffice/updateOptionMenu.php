<?php

function ajaxUpdateOptionMenu()
{
    //Si une des données necéssaire est manquante
    if(!isset($_POST['id']) || !isset($_POST['field']) || !isset($_POST['value'])) {
        if(TEST_IN_PROGESS) return 'Error update option menu, data are missing';
        else return JsonAnswer::retour(0, 'Error update option menu, data are missing', '');
    }

    //Sécurisation des paramètres reçues
    $idOption = intval(($_POST['id']));

    /**
     * @var RestaurantMenuOption $oOption
     */
    $oOption = null;
    //On vérifie que l'option existe en base et on la récupère
    $aOption = RestaurantMenuOptions::getInstance()->getByWhere(array('id' => $idOption));
    if($aOption && is_array($aOption)){
        $oOption = array_pop($aOption);
    }else{
        if(TEST_IN_PROGESS) return 'Error id option is not exist in database';
        else return JsonAnswer::retour(0, 'Error id option is not exist in database', '');
    }

    if(count($oOption->getErrArray()) > 0){
        if(TEST_IN_PROGESS) return join(', ', $oOption->getErrArray());
        else return JsonAnswer::retour(0, join(', ', $oOption->getErrArray()), '');
    }

    $sField = sanitize_text_field( $_POST['field']);
    $mValue = null;
    $aDataUpdate = array();
    $aField = RestaurantMenuOptions::getArrayField();
    switch($sField)
    {
        case 1:
            //1 => 'idMenu', 2 => 'title', 3 => 'description', 4 => 'price'
            $mValue = intval($_POST['value']);
            $oOption->setIdMenu($mValue);
            if(count($oOption->getErrArray()) > 0){
                if(TEST_IN_PROGESS) return join(', ', $oOption->getErrArray());
                else return JsonAnswer::retour(0, join(', ', $oOption->getErrArray()), '');
            }
            $aDataUpdate[$aField[$sField]] = $oOption->getIdMenu();
            break;
        case 2:
            $mValue = sanitize_text_field( $_POST['value']);
            $oOption->setTitle($mValue);
            if(count($oOption->getErrArray()) > 0){
                if(TEST_IN_PROGESS) return join(', ', $oOption->getErrArray());
                else return JsonAnswer::retour(0, join(', ', $oOption->getErrArray()), '');
            }
            $aDataUpdate[$aField[$sField]] = $oOption->getTitle();
            break;
        case 3:
            $mValue = sanitize_text_field( $_POST['value']);
            $oOption->setDescription($mValue);
            if(count($oOption->getErrArray()) > 0){
                if(TEST_IN_PROGESS) return join(', ', $oOption->getErrArray());
                else return JsonAnswer::retour(0, join(', ', $oOption->getErrArray()), '');
            }
            $aDataUpdate[$aField[$sField]] = $oOption->getDescription();
            break;
        case 4:
            $mValue = floatval($_POST['value']);
            $oOption->setPrice($mValue);
            if(count($oOption->getErrArray()) > 0){
                if(TEST_IN_PROGESS) return join(', ', $oOption->getErrArray());
                else return JsonAnswer::retour(0, join(', ', $oOption->getErrArray()), '');
            }
            $aDataUpdate[$aField[$sField]] = $oOption->getPrice();
            break;
        default:
            if(TEST_IN_PROGESS) return join(', ', $oOption->getErrArray());
            else return JsonAnswer::retour(0, 'Error switch update $sField(' . $sField . ') is unknow', '');
    }

    try{
        $b = RestaurantMenuOptions::getInstance()->updateById($oOption->getId(), $aDataUpdate);
        if($b === true){
            if(TEST_IN_PROGESS) return true;
            else return JsonAnswer::retour(1, 'Option menu updated', '');
        } else {
            if(TEST_IN_PROGESS) return $b;
            else return JsonAnswer::retour(0, 'Error update option menu', $b);
        }
    }catch(Exception $e){
        if(TEST_IN_PROGESS) return 'Error ajaxUpdateMenuOption : ' . $e->getMessage();
        else return JsonAnswer::retour(0, 'Error ajaxUpdateMenuOption : ' . $e->getMessage(), '');
    }
}