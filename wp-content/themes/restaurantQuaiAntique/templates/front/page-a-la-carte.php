<?php

$s = '';
/**
 * @var DishType $oDish
 */
foreach ($aDish as $oDish)
{
    $sTr =  '';
    /**
     * @var FoodDish $oFoodDish
     */
    foreach($aFoodDish as $oFoodDish)
    {
        if($oFoodDish->getIdDishType() === $oDish->getId())
        {
            $sTr .= '<div class="row ">
                            <div class="col-3 ">' . $oFoodDish->getTitle() . '</div>
                            <div class="col-7 ">' . $oFoodDish->getDescription() . '</div>
                            <div class="col-2  text-end">' . $oFoodDish->getPrice() . ' €</div>
                        </div>';
        }
    }
    if($sTr === '') continue; // si le type de plat n'a pas de plat on l'ignore
    $s .= '<div class="ctnDishType">
                    <div class="head">
                        <div class="titleDishType">' . $oDish->getTitle() . '</div>
                    </div>
                    <div class="body">
                        ' . $sTr . '
                    </div>
                </div>';
}

get_header();
?>
    <div class="row firstRow">
        <div class="col-12">
            <h2>La carte du chef</h2>
        </div>
    </div>
    <div class="row">
        <div class="col-12 offset-lg-1 col-lg-10 mb-5" id="ctnDish">
            <?= $s ?>
        </div>
    </div>

<?php get_footer() ?>