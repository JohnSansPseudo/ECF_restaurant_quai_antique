<?php
function getHtmlPageAlaCarte2()
{
    //La carte du chef

    $aDish = DishTypes::getInstance()->getAllData();
    $aFoodDish = FoodDishes::getInstance()->getAllData();
    $s = '';
    /**
     * @var DishType $oDish
     */
    foreach ($aDish as $oDish)
    {
        $sTitle = '<div class=""></div>';

        $sTr =  '';
        /**
         * @var FoodDish $oFoodDish
         */
        foreach($aFoodDish as $oFoodDish)
        {
            if($oFoodDish->getIdDishType() === $oDish->getId())
            {
                $sTr .= '<tr>
                            <td>' . $oFoodDish->getTitle() . '</td>
                            <td>' . $oFoodDish->getDescription() . '</td>
                            <td>' . $oFoodDish->getPrice() . '</td>
                        </tr>';
            }
        }

        $s .= '<div class="ctnDishType">
                    <div class="head"><div class="titleDishType">' . $oDish->getTitle() . '</div>
                    <div class="body">
                        <table>
                            <tbody>' . $sTr . '</tbody>
                        </table>
                    </div>
                </div>';
    }

    return $s;
}

get_header();
?>

<div class="row">
    <div class="col sm-3"></div>
    <div class="col sm-9"></div>
</div>
<div class="row">
    <?php echo getHtmlPageAlaCarte2(); ?>
</div>

<?php get_footer() ?>
