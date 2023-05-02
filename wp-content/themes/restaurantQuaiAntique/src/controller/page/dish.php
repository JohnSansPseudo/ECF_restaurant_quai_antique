<?php

$aDishType = DishTypes::getInstance()->getAllData(' ORDER BY title');
$aFoodDish = FoodDishes::getInstance()->getAllData(' ORDER BY idDishType');
require_once(get_template_directory() .'/templates/backoffice/dish.php');
require_once(get_template_directory() . '/templates/backoffice/layout.php');
