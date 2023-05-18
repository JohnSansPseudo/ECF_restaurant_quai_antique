<?php

function bookTable()
{
    $sBackPath = get_site_url() . '/' . PageWordpress::BOOK_TABLE_NAME;
    if (!isset($_POST['book-table'])) return false;

    if (!isset($_REQUEST['book_table_nonce']) || !wp_verify_nonce($_REQUEST['book_table_nonce'], 'bookTable')) {
        die('Vous n\'avez pas l\'autorisation d\'effectuer cette action. <br/><br/><a href="' . $sBackPath . '">Retour</a>');
    }

    unset($_POST['book-table']);
    unset($_POST['book_table_nonce']);
    unset($_POST['err_book_table']);
    unset($_POST['success_book_table']);

    $oParam = (object)array(
        'date' => 'inpDateBook',
        'idOpening' => 'idOpening',
        'sStartTime' => 'startAppointement',
        'nbGuest' => 'inpNbGuest',
        'firstName' => 'inpFirstName',
        'lastName' => 'inpLastName',
        'mail' => 'inpMail',
        'tel' => 'inpTel');
    foreach ($oParam as $sParam){
        if(!isset($_POST[$sParam])) $_POST['err_book_table'] = 'Error booking table, data are missing, please contact an admin';
    }

    if(!isset($_POST['err_book_table'])) {

        $sStartTime = sanitize_text_field($_POST[$oParam->sStartTime]);
        $sStartTime .= ':00';

        $sDate = sanitize_text_field($_POST[$oParam->date]);
        $aDate = explode('/', $sDate);
        $sSqlDate = $aDate[2] . '-' . $aDate[1] . '-' . $aDate[0];
        if(!preg_match('/[0-9]{4}-[0-1][0-9]-[0-3][0-9]/', $sSqlDate)){
            $_POST['err_book_table'] = 'Erreur dans le format de date : ' . $sDate;
        }

        $idOpening = intval($_POST[$oParam->idOpening]);
        $iNbGuest = intval($_POST[$oParam->nbGuest]);
        $sFirstName = sanitize_text_field($_POST[$oParam->firstName]);
        $sLastName = sanitize_text_field($_POST[$oParam->lastName]);
        $sTel = sanitize_text_field($_POST[$oParam->tel]);
        $sMail = sanitize_text_field($_POST[$oParam->mail]);

        $sAllergie = '';
        if(isset($_POST['txtAllergie'])) $sAllergie = sanitize_textarea_field($_POST['txtAllergie']);

        $oBooking = new Booking($idOpening, $sMail, $sFirstName, $sLastName, $sTel, $sAllergie, $iNbGuest, $sStartTime, $sSqlDate);
        if($oBooking && count($oBooking->getErrArray()) > 0){
            $aErr = $oBooking->getErrArray();
            if(isset($aErr['firstName'])) $_POST['err_firstName'] = $aErr['firstName'];
            if(isset($aErr['tel'])) $_POST['err_tel'] = $aErr['tel'];
            if(isset($aErr['lastName'])) $_POST['err_lastName'] = $aErr['lastName'];
            if(isset($aErr['allergy'])) $_POST['err_allergy'] = $aErr['allergy'];
            if(isset($aErr['email'])) $_POST['err_email'] = $aErr['email'];
            if(isset($aErr['nbGuest'])) $_POST['err_nbGuest'] = $aErr['nbGuest'];
        }else{
            try{

                try{
                    $bAdd = Bookings::getInstance()->add($oBooking);
                    if($bAdd){
                        header('Location:' . $sBackPath . '?book=1&date=' . $sSqlDate . '&time=' . $sStartTime);
                    } else {
                        $_POST['err_book_table'] = 'Erreur lors de la réservation contactez un administrateur.';
                    }
                }catch(Exception $e)  {
                    $_POST['err_book_table'] = $e->getMessage();
                }
            }catch(PDOException $e){
                $_POST['err_book_table'] = 'Erreur  la réservation n\'a pas pu aboutir <br/><br/>' . $e->getMessage();
            }
        }
    }
}
