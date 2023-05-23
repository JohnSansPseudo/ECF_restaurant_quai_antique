<?php

function addClient()
{
    $sBackPath = get_site_url() . '/' . PageWordpress::ACCOUNT_NAME;
    if(!isset($_POST['add-client'])) return false;

    if(!isset($_REQUEST['add_client_nonce']) || !wp_verify_nonce($_REQUEST['add_client_nonce'], 'addClient' )){
        die('Vous n\'avez pas l\'autorisation d\'effectuer cette action. <br/><br/><a href="' . $sBackPath . '">Retour</a>');
    }

    unset($_POST['err_add_client']);
    unset($_POST['success_add_client']);
    unset($_POST['add-client']);
    unset($_REQUEST['add_client_nonce']);

    unset($_POST['err_firstName']);
    unset($_POST['err_tel']);
    unset($_POST['err_lastName']);
    unset($_POST['err_allergy']);
    unset($_POST['err_email']);
    unset($_POST['err_nbGuest']);


    $oParam = (object)array(
        'firstName' => 'inpFirstName',
        'lastName' => 'inpLastName',
        'tel' => 'inpTel',
        'mail' => 'inpMail',
        'nbGuest' => 'inpNbGuestDef');
    $bError = false;
    foreach ($oParam as $k => $sParam){
        if(!isset($_POST[$sParam])){
            $bError = true;
            switch($k){
                case 'nbGuest' : $_POST['err_nbGuest'] = 'Merci de renseigner un nombre d\'inivté valide'; break;
                case 'firstName' : $_POST['err_firstName'] = 'Merci de renseigner prénom'; break;
                case 'lastName' : $_POST['err_lastName'] = 'Merci de renseigner nom'; break;
                case 'mail' : $_POST['err_email'] = 'Merci de renseigner mail'; break;
                case 'tel' : $_POST['err_tel'] = 'Merci de renseigner votre téléphone'; break;
                default: $_POST['err_add_client'] = 'Erreur lors de la création du compte, merci de retenter ou contactez un administrateur.';
            }
        }
    }

    $oParam->allergie = 'txtAllergie';
    if($bError === false){

        $oParamSan = (object)array(
            'firstName' => sanitize_text_field($_POST[$oParam->firstName]),
            'lastName' => sanitize_text_field($_POST[$oParam->lastName]),
            'tel' => sanitize_text_field($_POST[$oParam->tel]),
            'mail' =>  sanitize_text_field($_POST[$oParam->mail]),
            'nbGuest' => intval($_POST[$oParam->nbGuest]));

        if(isset($_POST[$oParam->allergie]))$oParamSan->allergie = sanitize_text_field($_POST[$oParam->allergie]);
        else $oParamSan->allergie = '';
        $oClient = ClientConnection::isConnected();
        if($oClient){
            $b = updateAccountClient($oClient, $oParamSan, $sBackPath);
            if(TEST_IN_PROGESS) return $b;
        }
        else{
            $b = creatAccountClient($oParamSan, $sBackPath);
            if(TEST_IN_PROGESS) return $b;
        }
    }else{
        if(TEST_IN_PROGESS) return $_POST;
    }
}




/**
 * @param $oParamSan object
 * @param $sBackPath string
 */
function creatAccountClient($oParamSan, $sBackPath)
{
    //RECAPTCHA
    if(TEST_IN_PROGESS === false && LOCAL_SITE_USE === false){
        $bRecap = checkFormRecaptcha('err_add_client');
        if($bRecap === false) return false;
    }

    if (!isset($_POST['inpPassword']) || $_POST['inpPassword'] === ''){
        $_POST['err_add_client'] = 'Error add client, data are missing, please ';
        if(TEST_IN_PROGESS) return $_POST['err_add_client'];
    }else{
        $sPasswordInit = sanitize_text_field(($_POST['inpPassword']));
        $sPassword = ClientConnection::generatePassword($sPasswordInit);
        $oClient = new Client($oParamSan->firstName, $oParamSan->lastName, $oParamSan->tel, $oParamSan->mail, $oParamSan->allergie, $sPassword, $oParamSan->nbGuest);
        if (!empty($oClient->getErrArray())) {
            unset($_POST['inpPassword']);
            $aErr = $oClient->getErrArray();
            if(isset($aErr['firstName'])) $_POST['err_firstName'] = $aErr['firstName'];
            if(isset($aErr['tel'])) $_POST['err_tel'] = $aErr['tel'];
            if(isset($aErr['lastName'])) $_POST['err_lastName'] = $aErr['lastName'];
            if(isset($aErr['allergy'])) $_POST['err_allergy'] = $aErr['allergy'];
            if(isset($aErr['email'])) $_POST['err_email'] = $aErr['email'];
            if(isset($aErr['nbGuest'])) $_POST['err_nbGuest'] = $aErr['nbGuest'];
            if(TEST_IN_PROGESS) return $oClient->getErrArray();
        }else{
            try{
                $bAdd = Clients::getInstance()->add($oClient);

                if($bAdd){
                    unset($_POST['inpPassword']);
                    new ClientConnection($oClient->getEmail(), $oClient->getPassword());
                    if(TEST_IN_PROGESS === false){
                        if(LOCAL_SITE_USE === false) {
                            //Mail
                            $sMess = 'Restaurant Quai Antique';
                            $sMess .= 'votre compte client est créé, vos identifiants,';
                            $sMess .= 'login : ' . $oClient->getEmail() . ' mot de passe : ' . $sPasswordInit;
                            $sMess .= ' connectez-vous : https://quaiantique.online/sign-in/';
                            $sSender = 'contact@quaiantique.online';
                            $sHeaders = "From: " . $sSender . "\r\n" . "Reply-To: contact@quaiantique.online\r\n";
                            mail($oClient->getEmail(), 'Quai Antique - Votre compte client', $sMess, $sHeaders, '');
                            //Fin mail
                        }
                        header('Location: ' . $sBackPath . '?success_add_client=1');//Otherwise firfox keep the request in memory and reload it on F5 keypress
                    }
                    else{ return $bAdd; }
                }else{
                    if(TEST_IN_PROGESS) return $bAdd;
                }
            }catch(PDOException $e){
                $_POST['err_add_client'] = $e->getMessage() . '<br/><br/>Error form add create account, please contact an admin';
                if(TEST_IN_PROGESS) return $_POST['err_add_client'];
            }
        }
    }
}

/**
 * @param $oClient Client
 * @param $oParam object
 * @param $sBackPath string
 */
function updateAccountClient($oClient, $oParam, $sBackPath)
{
    //**** Update client
    $oClient->setFirstName($oParam->firstName);
    $oClient->setLastName($oParam->lastName);
    $oClient->setTel($oParam->tel);
    $oClient->setAllergy($oParam->allergie);
    $oClient->setEmail($oParam->mail);
    $oClient->setNbGuest($oParam->nbGuest);


    if (!empty($oClient->getErrArray())) {
        $aErr = $oClient->getErrArray();
        if(isset($aErr['firstName'])) $_POST['err_firstName'] = $aErr['firstName'];
        if(isset($aErr['tel'])) $_POST['err_tel'] = $aErr['tel'];
        if(isset($aErr['lastName'])) $_POST['err_lastName'] = $aErr['lastName'];
        if(isset($aErr['allergy'])) $_POST['err_allergy'] = $aErr['allergy'];
        if(isset($aErr['email'])) $_POST['err_email'] = $aErr['email'];
        if(isset($aErr['nbGuest'])) $_POST['err_nbGuest'] = $aErr['nbGuest'];

    }else{
        $aDataUp = array(
            'firstName' => $oClient->getFirstName(),
            'lastName' => $oClient->getLastName(),
            'email' => $oClient->getEmail(),
            'tel' => $oClient->getTel(),
            'allergy' => $oClient->getAllergy(),
            'nbGuest' => $oClient->getNbGuest()
        );
        try{
            $bUp = Clients::getInstance()->updateById($oClient->getId(), $aDataUp);

            if(!$bUp) {
                $_POST['err_add_client'] = var_dump($bUp) . ' An error occured while updating client account, please contact an admin';
                if(TEST_IN_PROGESS) return $bUp;
            }else{
                $_POST['success_add_client'] = 'Votre compte est modifié';
                if(!TEST_IN_PROGESS) header('Location: ' . $sBackPath . '?update_client=1');
                else return $bUp;
            }
        }catch (Exception $e){
            $_POST['err_add_client'] = 'Erreur : ' . $e->getMessage();
            if(TEST_IN_PROGESS) return $_POST['err_add_client'];
        }
    }
}