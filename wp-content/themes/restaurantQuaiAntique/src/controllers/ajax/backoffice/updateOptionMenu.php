<?php

function ajaxUpdateOptionMenu()
{
    //Si une des données necéssaire est manquante
    if(!isset($_POST['id']) || !isset($_POST['field']) || !isset($_POST['value'])) {
        return JsonAnswer::retour(0, 'Error update option menu, data are missing', '');
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
    }else return JsonAnswer::retour(0, 'Error id option is not exist in database', '');

    if(count($oOption->getErrArray()) > 0){
        return JsonAnswer::retour(0, join(', ', $oOption->getErrArray()), '');
    }

    $sField = sanitize_text_field( $_POST['field']);
    $mValue = null;
    $aDataUpdate = array();
    switch($sField)
    {
        case 'idMenu':
            $mValue = intval($_POST['value']);
            $oOption->setIdMenu($mValue);
            if(count($oOption->getErrArray()) > 0){
                return JsonAnswer::retour(0, join(', ', $oOption->getErrArray()), '');
            }
            $aDataUpdate[$sField] = $oOption->getIdMenu();
            break;
        case 'title':
            $mValue = sanitize_text_field( $_POST['value']);
            $oOption->setTitle($mValue);
            if(count($oOption->getErrArray()) > 0){
                return JsonAnswer::retour(0, join(', ', $oOption->getErrArray()), '');
            }
            $aDataUpdate[$sField] = $oOption->getTitle();
            break;
        case 'description':
            $mValue = sanitize_text_field( $_POST['value']);
            $oOption->setDescription($mValue);
            if(count($oOption->getErrArray()) > 0){
                return JsonAnswer::retour(0, join(', ', $oOption->getErrArray()), '');
            }
            $aDataUpdate[$sField] = $oOption->getDescription();
            break;
        case 'price':
            $mValue = floatval($_POST['value']);
            $oOption->setPrice($mValue);
            if(count($oOption->getErrArray()) > 0){
                return JsonAnswer::retour(0, join(', ', $oOption->getErrArray()), '');
            }
            $aDataUpdate[$sField] = $oOption->getPrice();
            break;
        default: return JsonAnswer::retour(0, 'Error switch update $sField(' . $sField . ') is unknow', '');
    }

    try{
        $b = RestaurantMenuOptions::getInstance()->updateById($oOption->getId(), $aDataUpdate);
    }catch(Exception $e){
        return JsonAnswer::retour(0, 'Error ajaxUpdateMenuOption : ' . $e->getMessage(), '');
    }
    if($b === true) return JsonAnswer::retour(1, 'Option menu updated', '');
    return JsonAnswer::retour(0, 'Error update option menu', $b);
}