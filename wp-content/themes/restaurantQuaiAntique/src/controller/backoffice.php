<?php
//Réunir le modèle et la vue

function quaiAntiqueParamPage()
{
    $aTab = array(
        'menu' => (object)array('id' => 'menu', 'title' => 'Menu', 'active' => true),
        'dish' => (object)array('id' => 'dish', 'title' => 'Dish', 'active' => false),
        'opening' => (object)array('id' => 'opening', 'title' => 'Opening time', 'active' => false),
        'guest' => (object)array('id' => 'guest', 'title' => 'Guest max', 'active' => false),
        'gallery' => (object)array('id' => 'gallery', 'title' => 'Gallery', 'active' => false));

    $aMenu = RestaurantMenus::getInstance()->getAllData();
    $aOptionMenu = RestaurantMenuOptions::getInstance()->getAllData();
    $aDishType = DishTypes::getInstance()->getAllData();
    $aFoodDish = FoodDishes::getInstance()->getAllData();
    $aOpeningTime = OpeningTimes::getInstance()->getAllData();

    //Templates
    require_once(get_template_directory() . '/templates/backoffice/layout.php');



}