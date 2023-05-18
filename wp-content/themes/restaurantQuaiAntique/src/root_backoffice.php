<?php
require_once ('controllers/backoffice_page.php');
function root_backoffice()
{
    $sAdminAction = '';
    if(isset($_GET['admin_action']) && $_GET['admin_action'] && $_GET['admin_action'] !== '') $sAdminAction = htmlspecialchars($_GET['admin_action']);
    if(!user_can_access_admin_page()){
        echo '<p class="error">Access denied</p>';
        die();
    }
    try{
        switch($sAdminAction){
            //PAGES
            case 'dish': getDishPage($sAdminAction); break;
            case 'opening': getOpeningTimePage($sAdminAction); break;
            case 'guest':  getGuestMaxPage($sAdminAction); break;
            case 'gallery': getGalleryPage($sAdminAction); break;
            default: getMenuPage($sAdminAction); break;
        }
    }catch (Exception $e){
        echo '<p>' . $e->getMessage() .'</p>';
        echo '<p>' . $e->getFile() .'</p>';
        echo '<p>' . $e->getTrace() .'</p>';
        die();
    }
}