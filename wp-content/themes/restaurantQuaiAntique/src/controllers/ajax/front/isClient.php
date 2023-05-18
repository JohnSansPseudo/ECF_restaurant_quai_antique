<?php

function ajaxIsClient()
{
    if(!isset($_POST['mail']) && $_POST['mail'] === '' && !isset($_POST['password']) && $_POST['password'] === '' ) {
        return JsonAnswer::retour(0, 'Error form connexion, data are missing', '');
    }
    $sMail = sanitize_text_field($_POST['mail']);
    $sPass = sanitize_text_field($_POST['password']);
    $sPass = ClientConnection::generatePassword($sPass);

    new ClientConnection($sMail, $sPass);
    if(ClientConnection::isConnected() === false) return JsonAnswer::retour(0, '', '');
    else return JsonAnswer::retour(1, '', '');
}