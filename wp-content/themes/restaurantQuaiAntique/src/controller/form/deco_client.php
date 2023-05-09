<?php

function decoClient()
{
    $sBackPath = get_site_url() . '/sign-in';
    if (!isset($_POST['deco-client'])) return false;

    if (!isset($_REQUEST['deco_client_nonce']) || !wp_verify_nonce($_REQUEST['deco_client_nonce'], 'decoClient')) {
        die('Vous n\'avez pas l\'autorisation d\'effectuer cette action. <br/><br/><a href="' . $sBackPath . '">Retour</a>');
    }

    ClientConnection::deconnection();
}