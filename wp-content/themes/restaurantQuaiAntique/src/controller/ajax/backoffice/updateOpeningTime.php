<?php
function ajaxUpdateOpeningTime()
{
    //Si une des données necéssaire est manquante
    if(!isset($_POST['id']) || !isset($_POST['timeStart']) || !isset($_POST['timeEnd'])) {
        return JsonAnswer::retour(0, 'Error update menu, data are missing', '');
    }


    //Sécurisation des paramètres reçues
    $id = intval(($_POST['id']));
    $sTimeStart = null;
    $sTimeEnd = null;
    if($_POST['timeStart'] !== '') $sTimeStart = sanitize_text_field( $_POST['timeStart']);
    if($_POST['timeEnd'] !== '') $sTimeEnd = sanitize_text_field( $_POST['timeEnd']);


    //Complément de saisie
    if(strlen($sTimeStart) === 5){
        $sTimeStart = $sTimeStart . ':00';
    }
    if(strlen($sTimeEnd) === 5){
        $sTimeEnd = $sTimeEnd . ':00';
    }
    //Vérifier si les deux champs sont bien remplis !! par l'un en null et l'autre en remplis...
    if(($sTimeStart === null && $sTimeEnd !== null) || $sTimeStart !== null && $sTimeEnd === null)
    {
        return JsonAnswer::retour(0,'Please enter each time field');
    }
    /**
     * @var OpeningTime $oOpening
     */
    $oOpeningTimes = new OpeningTimes();
    $aOpening = $oOpeningTimes->getByWhere(array('id' => $id));
    if($aOpening && count($aOpening) > 0) $oOpening = array_pop($aOpening);
    else return JsonAnswer::retour(0, 'Error id Opening is not exist in database', '');

    $oOpening->setStartTimeDay($sTimeStart)->setEndTimeDay($sTimeEnd);
    //Si il y a une erreur sur les param alors on fait un retour   Json avec l'erreur
    if(count($oOpening->getErrArray()) > 0) return JsonAnswer::retour(0, join(', ', $oOpening->getErrArray()), '');



    //Vérifier si il a une réservation qui risque d'être exclus !!

    $aBooking = Bookings::getInstance()->getByWhere(array('idOpening' => $oOpening->getId()));
    if(is_array($aBooking) && count($aBooking) > 0){

        /**
         * @var $oBooking Booking
         */
        /*foreach($aBooking as $oBooking) {
            $oDateBookStart = new Date('H:m:s', $oBooking->getStartTime());
            $oDateOpenStart = new Date('H:m:s', $oOpening->getStartTimeDay());

            if($oBooking->getStartTime() > $oOpening->getStartTimeDay()){

            }

        }*/

        //Vérifier l'heure

        //Si ma nouvelle heure de début est après l'heure de résa
        //Si ma nouvelle heure de fin est avant l'heure de résa

    }
    //Prendre toute les résevations
    //Celle qui ont l'idOpening


    try{
        $b = $oOpeningTimes->updateById($oOpening->getId(), array('startTimeDay' => $oOpening->getStartTimeDay(), 'endTimeDay' => $oOpening->getEndTimeDay()));
    }catch(Exception $e){
        return JsonAnswer::retour(0, 'ajaxUpdateOpeningTime : ' . $e->getMessage(), '');
    }
    if($b === true) return JsonAnswer::retour(1, 'Opening time updated', '');
    return JsonAnswer::retour(0, 'Error update opening time', $b);

}