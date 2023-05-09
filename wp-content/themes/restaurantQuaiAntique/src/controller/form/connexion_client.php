<?php

function connexionClient()
{
    $sBackPath = get_site_url() . '/sign-in';
    if (!isset($_POST['conn-client'])) return false;

    if (!isset($_REQUEST['conn_client_nonce']) || !wp_verify_nonce($_REQUEST['conn_client_nonce'], 'connClient')) {
        die('Vous n\'avez pas l\'autorisation d\'effectuer cette action. <br/><br/><a href="' . $sBackPath . '">Retour</a>');
    }

    unset($_POST['err_conn_client']);
    unset($_POST['conn-client']);

    if(isset($_POST['log']) && $_POST['log'] !== '' && isset($_POST['pwd']) && $_POST['pwd'] !== ""){
        $sMail = sanitize_text_field($_POST['log']);
        $sPassword = sanitize_text_field($_POST['pwd']);
        $oClientConn = new ClientConnection($sMail, $sPassword);
        if($oClientConn->isConnected()) {
            unset($_POST['inpPasswordConn']);
        }else{
            $_POST['err_conn_client'] = 'These identifiers do not correspond to any account';
        }
    } else $_POST['err_conn_client'] = 'Error connexion client, please fill all fields';

}