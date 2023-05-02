<?php

$aMenu = RestaurantMenus::getInstance()->getAllData();
$aOptionMenu = RestaurantMenuOptions::getInstance()->getAllData();
require_once(get_template_directory() .'/templates/backoffice/menu.php');
require_once(get_template_directory() . '/templates/backoffice/layout.php');