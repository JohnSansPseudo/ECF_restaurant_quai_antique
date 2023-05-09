<?php

function ajaxUpdateBookingHour()
{
    if(!isset($_POST['sqlDay']) && $_POST['sqlDay'] === '') {
        return JsonAnswer::retour(0, 'Error update menu, data are missing', '');
    }
    $sSqlDate = $_POST['sqlDay'];
    if(!preg_match('/[0-9]{4}-[0-1][0-9]-[0-3][0-9]/', $sSqlDate)){
        return JsonAnswer::retour(0, 'Error on sql date format : ' . $sSqlDate , '');
    }

    $sHtml = OpeningTimes::getInstance()->getHtmlHourBooking($sSqlDate);
    if(!$sHtml) return JsonAnswer::retour(0, 'Error on function getHtmlHourBooking()' , '');
    else{
        return JsonAnswer::retour(1, '', $sHtml);
    }
}