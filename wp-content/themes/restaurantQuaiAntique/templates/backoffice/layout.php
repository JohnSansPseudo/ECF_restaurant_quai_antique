<?php

$aTab = array(
    'menu' => (object)array('id' => 'menu', 'title' => 'Menus', 'active' => false),
    'dish' => (object)array('id' => 'dish', 'title' => 'Plats', 'active' => false),
    'opening' => (object)array('id' => 'opening', 'title' => 'Jours & horaires', 'active' => false),
    'guest' => (object)array('id' => 'guest', 'title' => 'Nombre de clients max', 'active' => false),
    'gallery' => (object)array('id' => 'gallery', 'title' => 'Photos suggestion', 'active' => false));

$sHtmlTab = '';
$sContentBody = '';
$sPath = get_admin_url() . 'admin.php?page=QuaiAntiqueParam&admin_action=';
foreach($aTab as $oTab)
{
    if($sAdminAction === $oTab->id)$oTab->active = true;
    //Génération des onglets
    $sClassActive = '';
    if($oTab->active){ $sClassActive = 'active'; }
    $sHtmlTab .= '<a href="' . $sPath . $oTab->id . '" class="tabBackOffice mHover ' . $sClassActive . '">' . $oTab->title .'</a>';
    //$sHtmlTab .= '<a href="' . get_admin_url() . 'admin.php?page=QuaiAntiqueParam&admin_action=' . $oTab->id . '" class="tabBackOffice mHover ' . $sClassActive . '" data-id_tab="' . $oTab->id . '">' . $oTab->title .'</div>';
}
?>

<div id="RestaurantQuaiAntiqueBackOffice">
    <div class="head">
        <?= wp_nonce_field('root_ajax', "nc_ajax") ?>
        <div id="ctnTabBackOffice"><?= $sHtmlTab ?></div>
    </div>
    <div id="boxCtnToast"></div>
    <div class="body"><?= $sContent ?></div>
</div>
