<?php

$aMenus = RestaurantMenus::getInstance()->getAllData();
$aOptionMenus = RestaurantMenuOptions::getInstance()->getAllData();
$sMenus = '';
/**
 * @var $oMenus RestaurantMenu
 */
foreach($aMenus as $oMenus){
    $sHead = '<div class="head"><h2 class="titleMenu">' . $oMenus->getTitle() . '</h2></div>';
    /**
     * @var $oOptions RestaurantMenuOption
     */
    $sBody = '';
    foreach($aOptionMenus as $oOptions){
        if($oOptions->getIdMenu() === $oMenus->getId()){
            $sBody .= '<div class="ctnOptionMenu">
                            <div class="head">' . $oOptions->getTitle() . '</div>
                            <div class="body">' . $oOptions->getDescription() . '</div>
                            <div class="footer">' . $oOptions->getPrice() . '</div>
                        </div>';
        }
    }
    $sMenus .= '<div class="ctnMenuRestaurant">
                    ' . $sHead
                    . '<div class="ctnOptionsMenu">' . $sBody . '</div>
                </div>';
}
get_header();
?>

    <div class="row">
        <div class="col-3"></div>
        <div class="col-6"><h2>Le Quai Antique vour propose ses menus</h2></div>
        <div class="col-3"></div>
    </div>
    <div class="row">
        <div class="col-3"></div>
        <div class="col-6"><?= $sMenus ?></div>
        <div class="col-3"></div>
    </div>

<?php get_footer() ?>