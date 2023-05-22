<?php

function getDishPage($sAdminAction)
{
    //ADD DISH TYPE
    $sErrAddDishType = '';
    if(isset($_POST['err_add_dish_type'])) $sErrAddDishType = 'Ce type de plat existe déjà, merci d\'essayer avec un autre nom';
    $sNameDishType = '';
    if(isset($_POST['inpTitleDishType']))$sNameDishType = htmlspecialchars($_POST['inpTitleDishType']);

//DELETE DISH TYPE
    $aErrDeleteDishType = array();
    if(isset($_POST['err_del_dish_type'])){
        $aErrDeleteDishType[$_POST['idDishType']] =  htmlspecialchars($_POST['err_del_dish_type']);
    }

//ADD FOOD DISH
    $sErrAddFoodDish = '';
    if(isset($_POST['err_add_food_dish'])) $sErrAddFoodDish = htmlspecialchars($_POST['err_add_food_dish']);

//$aParam = (object)array('idDishType' => 'selOptionDishType', 'sTitle' => 'inpTitleFoodDish', 'sDesc' => 'txtDescFoodDish', 'price' => 'inpPriceFoodDish');
    $sTitleFoodDish = '';
    if(isset($_POST['inpTitleFoodDish']))$sTitleFoodDish = htmlspecialchars($_POST['inpTitleFoodDish']);

    $sDescFoodDish = '';
    if(isset($_POST['txtDescFoodDish']))$sDescFoodDish = htmlspecialchars($_POST['txtDescFoodDish']);

    $sPriceFoodDish = '';
    if(isset($_POST['inpPriceFoodDish']))$sDescFoodDish = htmlspecialchars($_POST['inpPriceFoodDish']);


// DELETE FOOD DISH
    $aErrDeleteFoodDish = array();
    if(isset($_POST['err_delete_food_dish'])){
        $aErrDeleteFoodDish[$_POST['idFoodDish']] =  htmlspecialchars($_POST['err_delete_food_dish']);
    }

    $aDishType = DishTypes::getInstance()->getAllData(' ORDER BY title');
    $aFoodDish = FoodDishes::getInstance()->getAllData(' ORDER BY idDishType');
    require_once(get_template_directory() .'/templates/backoffice/dish.php');
    require_once(get_template_directory() . '/templates/backoffice/layout.php');
}

function getGalleryPage($sAdminAction)
{
    $aAttachment = Gallery::getInstance()->getAllImgAttachmentWp();
    $aItemGallery = Gallery::getInstance()->getAllData();
    $sError = '';
    $sSuccess = '';
    if(isset($_POST['success_file'])) $sSuccess = htmlspecialchars($_POST['success_file']);
    if(isset($_POST['error_file'])) $sError = htmlspecialchars($_POST['error_file']);
    require_once(get_template_directory() .'/templates/backoffice/gallery.php');
    require_once(get_template_directory() . '/templates/backoffice/layout.php');
}

function getGuestMaxPage($sAdminAction)
{
    require_once(get_template_directory() .'/templates/backoffice/guest_max.php');
    require_once(get_template_directory() . '/templates/backoffice/layout.php');
}

function getMenuPage($sAdminAction)
{
    //ADD MENU
    $sErrAddMenu = '';
    if(isset($_POST['err_add_menu'])) $sErrAddMenu = 'Ce menu existe déjà, merci d\'essayer avec un autre nom';
    $sNameMenu = '';
    if(isset($_POST['inpTitleMenu']))$sNameMenu = htmlspecialchars($_POST['inpTitleMenu']);

//DELETE MENU
    $aErrDeleteMenu = array();
    if(isset($_POST['err_del_menu'])){
        $aErrDeleteMenu[$_POST['idMenu']] =  htmlspecialchars($_POST['err_del_menu']);
    }

//ADD MENU OPTION
    $sErrAddMenuOption = '';
    if(isset($_POST['err_add_menu_option'])) $sErrAddMenuOption = htmlspecialchars($_POST['err_add_menu_option']);

//DELETE MENU OPTION
    $aErrDeleteMenuOption = array();
    if(isset($_POST['err_del_menu_option'])){
        $aErrDeleteMenuOption[$_POST['idMenuOption']] =  htmlspecialchars($_POST['err_del_menu_option']);
    }

    $aMenu = RestaurantMenus::getInstance()->getAllData();
    $aOptionMenu = RestaurantMenuOptions::getInstance()->getAllData();
    require_once(get_template_directory() .'/templates/backoffice/menu.php');
    require_once(get_template_directory() . '/templates/backoffice/layout.php');
}

function getOpeningTimePage($sAdminAction)
{
    $aOpeningTime = OpeningTimes::getInstance()->getAllData(' ORDER BY day, timeDay');
    require_once(get_template_directory() .'/templates/backoffice/opening_time.php');
    require_once(get_template_directory() . '/templates/backoffice/layout.php');
}