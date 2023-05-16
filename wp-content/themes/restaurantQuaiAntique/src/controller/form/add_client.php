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
    unset($_POST['add_client_nonce']);
    unset($_POST['add-client']);
    unset($_REQUEST['add_client_nonce']);


    $oParam = (object)array(
        'firstName' => 'inpFirstName',
        'lastName' => 'inpLastName',
        'tel' => 'inpTel',
        'mail' => 'inpMail',
        'nbGuest' => 'inpNbGuestDef');
    foreach ($oParam as $sParam){
        if(!isset($_POST[$sParam])) $_POST['err_add_client'] = 'Error add client, data are missing';
    }
    $oParam->allergie = 'txtAllergie';

    if(!isset($_POST['err_add_client'])){
        $oParamSan = (object)array(
            'firstName' => sanitize_text_field($_POST[$oParam->firstName]),
            'lastName' => sanitize_text_field($_POST[$oParam->lastName]),
            'tel' => sanitize_text_field($_POST[$oParam->tel]),
            'mail' =>  sanitize_text_field($_POST[$oParam->mail]),
            'nbGuest' => intval($_POST[$oParam->nbGuest]));

        if(isset($_POST[$oParam->allergie]))$oParamSan->allergie = sanitize_text_field($_POST[$oParam->allergie]);
        else $oParamSan->allergie = '';
        $oClient = ClientConnection::isConnected();
        if($oClient) updateAccountClient($oClient, $oParamSan, $sBackPath);
        else creatAccountClient($oParamSan, $sBackPath);
    }
}

/**
 * @param $oParamSan object
 * @param $sBackPath string
 */
function creatAccountClient($oParamSan, $sBackPath)
{
    if (!isset($_POST['inpPassword']) || $_POST['inpPassword'] === ''){
        $_POST['err_add_client'] = 'Error add client, data are missing, please ';
    }else{
        $sPassword = sanitize_text_field(($_POST['inpPassword']));
        $sPassword = ClientConnection::generatePassword($sPassword);
        $oClient = new Client($oParamSan->firstName, $oParamSan->lastName, $oParamSan->tel, $oParamSan->mail, $oParamSan->allergie, $sPassword, $oParamSan->nbGuest);
        if (!empty($oClient->getErrArray())) {
            unset($_POST['inpPassword']);
            $_POST['err_add_client'] = (implode(', <br>', $oClient->getErrArray()));
        }else{
            try{
                $bAdd = Clients::getInstance()->add($oClient);
                if($bAdd){
                    unset($_POST['inpPassword']);
                    new ClientConnection($oClient->getEmail(), $oClient->getPassword());
                    $_POST['success_add_client'] = 1;
                    header('Location: ' . $sBackPath . '?success_add_client=1');//Otherwise firfox keep the reuqest in memory and reload it on F5 keypress
                }
            }catch(PDOException $e){
                $_POST['err_add_client'] = $e->getMessage() . '<br/><br/>Error form add create account, please contact an admin';
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
        $sMess = '<br/><br/> Error param form update account, please contact an admin <br/><br/>';
        $_POST['err_add_client'] = implode(', ', $oClient->getErrArray()) . $sMess;

    }else{
        $aDataUp = array(
            'firstName' => $oClient->getFirstName(),
            'lastName' => $oClient->getLastName(),
            'email' => $oClient->getEmail(),
            'tel' => $oClient->getTel(),
            'allergy' => $oClient->getAllergy(),
            'nbGuest' => $oClient->getNbGuest()
        );
        $bUp = Clients::getInstance()->updateById($oClient->getId(), $aDataUp);
        if(!$bUp) {
            $_POST['err_add_client'] = var_dump($bUp) . ' An error occured while updating client account, please contact an admin';
        }else{
            $_POST['success_add_client'] = 'Votre compte est modifié';
            header('Location: ' . $sBackPath . '?update_client=1');
        }
    }

}