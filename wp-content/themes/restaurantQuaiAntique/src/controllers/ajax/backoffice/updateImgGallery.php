<?php

function ajaxUpdateImgGallery($bTest=false)
{
    //Si une des données necéssaire est manquante
    if(!isset($_POST['idGallery']) || !isset($_POST['value']) || !isset($_POST['field']) ) {
        if($bTest) return 'Error update image gallery, data are missing';
        return JsonAnswer::retour(0, 'Error update image gallery, data are missing', '');
    }

    //Sécurisation des paramètres reçues
    $idGallery = intval(($_POST['idGallery']));
    $sField = sanitize_text_field($_POST['field']);

    /**
     *@var  ImageGallery $oImgGallery
     */
    $oImgGallery = null;
    $aData = Gallery::getInstance()->getByWhere(array('id' => $idGallery));
    if(is_array($aData) && count($aData) === 1) $oImgGallery = array_pop($aData);
    else{
        if($bTest) return 'Error this id img gallery does not exists : ' . $idGallery;
        else return JsonAnswer::retour(0, 'Error this id img gallery does not exists : ' . $idGallery, '');
    }
    $aDataUpload = array();
    switch($sField)
    {
        case 'idAttachment':
            $idAttachment = intval($_POST['value']);
            $oImgGallery->setIdAttachment($idAttachment);
            if(count($oImgGallery->getErrArray()) > 0){
                if($bTest) return join(', ', $oImgGallery->getErrArray());
                else return JsonAnswer::retour(0, join(', ', $oImgGallery->getErrArray()), '');
            }
            $aDataUpload = array($sField => $idAttachment);
            break;
        case 'title' :
            $sTitle = sanitize_text_field($_POST['value']);
            $oImgGallery->setTitle($sTitle);
            if(count($oImgGallery->getErrArray()) > 0){
                if($bTest) return join(', ', $oImgGallery->getErrArray());
                else return JsonAnswer::retour(0, join(', ', $oImgGallery->getErrArray()), '');
            }
            $aDataUpload = array($sField => $sTitle);
            break;
        default : return JsonAnswer::retour(0, 'Error upload contact an admin ', '');
    }

    try{
        $bUp = Gallery::getInstance()->updateById($idGallery, $aDataUpload);
        if(!$bUp){
            if($bTest) return $bUp;
            else return JsonAnswer::retour(0, var_dump($bUp), '');
        } else {
            if($bTest) return true;
            else return JsonAnswer::retour(1, 'Gallery updated', '');
        }
    }catch(Exception $e){
        if($bTest) return $e->getMessage();
        else return JsonAnswer::retour(0, 'Error update gallery ' . $e->getMessage(), '');
    }

}