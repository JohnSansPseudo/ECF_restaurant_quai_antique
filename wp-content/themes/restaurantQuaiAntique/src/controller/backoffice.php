<?php
//Réunir le modèle et la vue

function root_action_admin()
{
    $sAdminAction = '';
    if(isset($_GET['admin_action']) && $_GET['admin_action'] && $_GET['admin_action'] !== '') $sAdminAction = $_GET['admin_action'];
    switch($sAdminAction){
        //PAGES
        case 'dish': require('page/dish.php'); break;
        case 'opening': require('page/opening_time.php'); break;
        case 'guest': require('page/guest_max.php'); break;
        case 'gallery': require('page/gallery.php'); break;
        default: require('page/menu.php'); break;
    }

}