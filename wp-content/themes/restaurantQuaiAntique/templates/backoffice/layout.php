<?php
$sContent = '';
//Templates

require_once('menu.php');


/*require_once('templates/backoffice/dish.php');*/
/*require_once('templates/backoffice/opening_time.php');*/
/*require_once('templates/backoffice/guest_max.php');*/
/*require_once('templates/backoffice/gallery.php');*/


$sHtmlTab = '';
$sContentBody = '';
foreach($aTab as $oTab)
{
    //Génération des onglets
    $sClassActive = '';
    if($oTab->active){ $sClassActive = 'active'; }
    $sHtmlTab .= '<div class="tabBackOffice mHover ' . $sClassActive . '" data-id_tab="' . $oTab->id . '">' . $oTab->title .'</div>';
}
?>

<div id="RestaurantQuaiAntiqueBackOffice">
    <div class="head">
        <?= wp_nonce_field('switch_ajax', "nc_ajax") ?>
        <div id="ctnTabBackOffice"><?= $sHtmlTab ?></div>
    </div>
    <div class="body"><?= $sContent ?></div>
</div>
