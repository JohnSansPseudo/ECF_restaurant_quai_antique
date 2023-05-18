<?php

function ajaxIsUserNameAdmin()
{
    if(!isset($_POST['mail']) && $_POST['mail'] === '') {
        return JsonAnswer::retour(0, 'Error form connexion, data are missing', '');
    }
    $sMail = sanitize_text_field($_POST['mail']);
    if(get_user_by('email', $sMail) !== false){
        unset($_SESSION['quai_antique']);
        return JsonAnswer::retour(1, '', '');
    } else return JsonAnswer::retour(0, '', '');
}