<?php


function ajaxDeleteImgGallery($bTest=false)
{
    //Si une des données necéssaire est manquante
    if(!isset($_POST['idGallery'])) {
        if($bTest) return 'Error delete image gallery, data are missing';
        else return JsonAnswer::retour(0, 'Error delete image gallery, data are missing', '');
    }

    //Sécurisation des paramètres reçues
    $idGallery = intval(($_POST['idGallery']));
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
    $oImgGallery->setIdAttachment(0);
    $oImgGallery->setTitle('');

    if(count($oImgGallery->getErrArray()) > 0){
        if($bTest) return join(', ', $oImgGallery->getErrArray());
        else return JsonAnswer::retour(0, join(', ', $oImgGallery->getErrArray()), '');
    }
    $aDataUpload = array(
        'idAttachment' => $oImgGallery->getIdAttachment(),
        'title' => $oImgGallery->getTitle());
    try{
        $bUp = Gallery::getInstance()->updateById($idGallery, $aDataUpload);
        if(!$bUp) {
            if($bTest) return $bUp;
            else return JsonAnswer::retour(0, var_dump($bUp), '');
        }
        else {
            if($bTest) return true;
            return JsonAnswer::retour(1, 'Gallery image and text erased', '');
        }
    }catch(Exception $e){
        if($bTest) return $e->getMessage();
        return JsonAnswer::retour(0, 'Error gallery' . $e->getMessage(), '');
    }
}