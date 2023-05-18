<?php

$sMenus = '';
/**
 * @var $oMenus RestaurantMenu
 */
foreach($aMenus as $oMenus){
    $sHead = '<div class="head"><h3 class="titleMenu">' . $oMenus->getTitle() . '</h3></div>';
    /**
     * @var $oOptions RestaurantMenuOption
     */
    $sBody = '';
    foreach($aOptionMenus as $oOptions){
        if($oOptions->getIdMenu() === $oMenus->getId()){
            $sBody .= '<div class="ctnOptionMenu">
                            <div class="head fw-bold text-center mb-2">' . $oOptions->getTitle() . '</div>
                            <div class="body text-center">' . $oOptions->getDescription() . '</div>
                            <div class="footer fw-bold text-center mt-2">' . $oOptions->getPrice() . ' €</div>
                        </div>';
        }
    }
    if($sBody === '') continue; //Si le menu ne contient pas d'option on ne l'affiche pas
    $sMenus .= '<div class="ctnMenuRestaurant">
                    ' . $sHead
        . '<div class="ctnOptionsMenu">' . $sBody . '</div>
                </div>';
}


/**
 * @var ImageGallery $oImgGallery
 */
$sImg = '';
$sRow = '';
$i = 1;
foreach($aImgGallery as $oImgGallery) {

    if(!$oImgGallery->guid) continue;
    $sImg .= '<div class="col-12 col-md-4  ctnImgGallery">
                    <img src="' . $oImgGallery->guid . '" class="imgGallery">
                    <div class="ctnTitleImgGallery"><span class="titleImgGallery">' . $oImgGallery->getTitle() .'</span></div>
                </div>';
    if($i === 3){
        $sRow .= '<div class="row g-1 mb-1">' . $sImg . '</div>';
        $sImg = '';
        $i = 1;
    } else $i++;
}
get_header();
?>

    <div class="row firstRow">
        <div class="col-12">
            <h1>Bienvenue au Quai Antique</h1>
            <div class="sectionSepHome text-center">****</div>
        </div>
    </div>
    <div class="row">
        <h2 class="col-12">Les suggestions du chef</h2>
        <div class="col-12" id="ctnGallery">
            <?= $sRow ?>
        </div>
    </div>
    <div class="row">
        <div class="col-12 offset-md-4 col-md-4 g-2 text-center">
            <a href="<?= get_site_url() . '/' . PageWordpress::BOOK_TABLE_NAME ?>" class="btn btnSaillance large" id="btnBookHome">Réserver votre table</a>
            <div class="sectionSepHome text-center">****</div>
        </div>
    </div>

    <div class="row">
        <div class="col-12"><h2>Le Quai Antique vour propose ses menus</h2></div>
    </div>
    <div class="row">
        <div class="col-12"><?= $sMenus ?></div>
    </div>

<?php get_footer() ?>