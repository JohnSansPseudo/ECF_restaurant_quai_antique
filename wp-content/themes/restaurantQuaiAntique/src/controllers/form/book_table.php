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

    unset($_POST['err_firstName']);
    unset($_POST['err_tel']);
    unset($_POST['err_lastName']);
    unset($_POST['err_allergy']);
    unset($_POST['err_email']);
    unset($_POST['err_nbGuest']);

    $oParam = (object)array(
        'date' => 'inpDateBook',
        'sStartTime' => 'startAppointement',
        'nbGuest' => 'inpNbGuest',
        'firstName' => 'inpFirstName',
        'lastName' => 'inpLastName',
        'mail' => 'inpMail',
        'tel' => 'inpTel');

    $bError = false;
    foreach ($oParam as $k => $sParam){
        if(!isset($_POST[$sParam])){
            $bError = true;
            switch($k){
                case 'date': $_POST['err_book_table'] = 'Merci de choisir une date disponible'; break;
                case 'sStartTime' : $_POST['err_book_table'] = 'Merci de choisir une heure disponible'; break;
                case 'nbGuest' : $_POST['err_nbGuest'] = 'Merci de renseigner un nombre d\'inivté valide'; break;
                case 'firstName' : $_POST['err_firstName'] = 'Merci de renseigner prénom'; break;
                case 'lastName' : $_POST['err_lastName'] = 'Merci de renseigner nom'; break;
                case 'mail' : $_POST['err_email'] = 'Merci de renseigner mail'; break;
                case 'tel' : $_POST['err_tel'] = 'Merci de renseigner votre téléphone'; break;
                default: $_POST['err_book_table'] = 'Erreur lors de la réservation, merci de retenter ou contactez un administrateur.';
            }
        }
    }

    //RECAPTCHA
    if(TEST_IN_PROGESS === false && LOCAL_SITE_USE === false){
        $bRecap = checkFormRecaptcha('err_book_table');
        if($bRecap === false) $bError = true;
    }

    if($bError === false) {

        $sStartTime = sanitize_text_field($_POST[$oParam->sStartTime]);
        $sStartTime .= ':00';

        $sDateFr = sanitize_text_field($_POST[$oParam->date]);
        $aDate = explode('/', $sDateFr);
        $sSqlDate = $aDate[2] . '-' . $aDate[1] . '-' . $aDate[0];
        if(!preg_match('/[0-9]{4}-[0-1][0-9]-[0-3][0-9]/', $sSqlDate)){
            $_POST['err_book_table'] = 'Erreur dans le format de date : ' . $sDateFr;
            if(TEST_IN_PROGESS) return $_POST['err_book_table'];
        }

        $iNbGuest = intval($_POST[$oParam->nbGuest]);
        $sFirstName = sanitize_text_field($_POST[$oParam->firstName]);
        $sLastName = sanitize_text_field($_POST[$oParam->lastName]);
        $sTel = sanitize_text_field($_POST[$oParam->tel]);
        $sMail = sanitize_text_field($_POST[$oParam->mail]);

        $sAllergie = '';
        if(isset($_POST['txtAllergie'])) $sAllergie = sanitize_textarea_field($_POST['txtAllergie']);

        $oOpening = OpeningTimes::getInstance()->getIdOpeningByDateAndHour($sSqlDate, $sStartTime);
        if($oOpening === false){
            $_POST['err_book_table'] = 'Error please check date and time are available';
            if(TEST_IN_PROGESS) return $_POST['err_book_table'];
        }else{

            $oBooking = new Booking($oOpening->getId(), $sMail, $sFirstName, $sLastName, $sTel, $sAllergie, $iNbGuest, $sStartTime, $sSqlDate);
            if($oBooking && count($oBooking->getErrArray()) > 0){
                $aErr = $oBooking->getErrArray();
                if(isset($aErr['firstName'])) $_POST['err_firstName'] = $aErr['firstName'];
                if(isset($aErr['tel'])) $_POST['err_tel'] = $aErr['tel'];
                if(isset($aErr['lastName'])) $_POST['err_lastName'] = $aErr['lastName'];
                if(isset($aErr['allergy'])) $_POST['err_allergy'] = $aErr['allergy'];
                if(isset($aErr['email'])) $_POST['err_email'] = $aErr['email'];
                if(isset($aErr['nbGuest'])) $_POST['err_nbGuest'] = $aErr['nbGuest'];
                if(TEST_IN_PROGESS) return $aErr;
            }else{
                try{
                    $bAdd = Bookings::getInstance()->add($oBooking);
                    if($bAdd){

                        if(TEST_IN_PROGESS === false)
                        {
                            if(LOCAL_SITE_USE === false){
                                //Mail
                                $sMess = 'Restaurant Quai Antique';
                                $sMess .= 'Votre table est réservée pour le ' . $sDateFr . ' à ' . $oBooking->getStartTime() . ' pour ' . $oBooking->getNbGuest() . ' personne(s)';
                                $sSender = 'contact@quaiantique.online';
                                $sHeaders = "From: " . $sSender . "\r\n". "Reply-To: contact@quaiantique.online\r\n";
                                mail($oBooking->getEmail(),'Quai Antique - Votre réservation', $sMess, $sHeaders, '');
                                //Fin mail
                            }
                            header('Location:' . $sBackPath . '?book=1&date=' . $sSqlDate . '&time=' . $sStartTime);
                        }else{

                            dbrDie('headerlosscsssatisson');
                            die();
                            return $oBooking;
                        }
                    } else {
                        $_POST['err_book_table'] = 'Erreur lors de la réservation contactez un administrateur.';
                        if(TEST_IN_PROGESS) return $bAdd;
                    }
                }catch(Exception $e){
                    $_POST['err_book_table'] = 'Erreur : ' . $e->getMessage();
                    if(TEST_IN_PROGESS) return $_POST['err_book_table'];
                }
            }
        }
    } else{
        $_POST['err_book_table'] = 'Erreur : ';
        if(TEST_IN_PROGESS) return $_POST['err_book_table'];
    }
}
