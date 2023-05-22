<?php

ob_start();
//ADD DISH TYPE
$sBody = '<form method="post" action="#" id="formAddDishType">
                <div id="cntDishType">
                    ' . wp_nonce_field('addDishType', "add_dish_type_nonce") . '
                    <div class="elf">
                        <div>
                            <label for="inpTitleDishType">Titre du type de plat</label>
                            <input type="text" id="inpTitleDishType" name="inpTitleDishType" min="3" max="50" value="' . $sNameDishType . '"/>
                        </div>
                        <p class="errorField">' . $sErrAddDishType . '</p>
                    </div>
                    <button type="submit" id="btnAddDishType" name="add_dish_type" class="btn">Ajouter le type de plat</button>
                </div>
            </form>';
$sTitle = 'Ajouter un type de plat';
include('layout_subsection.php');


//UPDATE AND DELETE DISH TYPE
$sBody = '<table id="tblEditDishType">
                    <thead>
                        <tr>
                            <th>Titre du type de plat</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody> ' . getTableRowAddDishType($aDishType, $aErrDeleteDishType) . ' </tbody>
                </table>';
$sTitle = 'Gérer les types de plats';
include('layout_subsection.php');



//ADD FOOD DISH
$oOption = new HtmlSelectOption($aDishType, 'getTitle');
if(count($oOption->getErrArray()) > 0) $sOption = implode('<br/>', $oOption->getErrArray());
else $sOption = $oOption->getOptionHtml();
$sBody = '<form method="post" action="#" id="formAddDish">
            ' . wp_nonce_field('addFoodDish', "add_food_dish_nonce") . '
             <div class="elf">
                <label for="selOptionDishType">Type du plat</label>
                <select id="selOptionDishType" name="selOptionDishType">' . $sOption . '</select>
            </div>
            <div class="elf" id="tdInpTitleFoodDish">
                <label for="inpTitleFoodDish">Titre du plat</label>
                <input type="text" id="inpTitleFoodDish" name="inpTitleFoodDish" value="' . $sTitleFoodDish . '"/>
            </div>
            <div class="elf" id="elfTxtDescFoodDish">
                <label for="txtDescFoodDish">Description</label>
                <textarea id="txtDescFoodDish" name="txtDescFoodDish">' . $sDescFoodDish . '</textarea>
            </div>
            <div class="elf">
                <label for="inpPriceFoodDish">Prix</label>
                <input type="text" id="inpPriceFoodDish" name="inpPriceFoodDish" value="' . $sPriceFoodDish . '"/>
            </div>
            <button type="submit" class="btn" name="addFoodDish">Ajouter le plat</button>
            <p class="errorField">' . $sErrAddFoodDish . '</p>
        </form>';
$sTitle = 'Ajouter un plat';
include('layout_subsection.php');


//UPDATE FOOD DISH
$sBody = '<table id="tblEditFoodDish">
                    <thead>
                        <tr>
                            <th>Type de plat</th>
                            <th>Titre du plat</th>
                            <th>Description</th>
                            <th>Prix</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody> ' . getTableRowFoodDish($aFoodDish, $aDishType, $aErrDeleteFoodDish) . ' </tbody>
                </table>';
$sTitle = 'Gérer les types de plat';
include('layout_subsection.php');

$sContent = ob_get_clean();

ob_start();
include('layout_section.php');
$sContent = ob_get_clean();



//GERER LES TYPE DE PLAT
/**
 * @param array $aMenu
 * @param array $aErrDeleteMenu
 * @var RestaurantMenu $oMenu
 * @return string
 */
function getTableRowAddDishType($aDishType, $aErrDeleteDishType)
{
    //Met en ligne de tableau tous les menus passés en param
    $sTrMenu = '';
    /**
     * @var DishType $oDish
     */
    foreach($aDishType as $oDish)
    {
        $sErrDeleteDishType = '';
        if(count($aErrDeleteDishType) > 0 && $oDish->getId() === intval(array_key_first($aErrDeleteDishType)))
        {
            $sErrDeleteDishType = $aErrDeleteDishType[array_key_first($aErrDeleteDishType)];
        }
        $sTrMenu .= '<tr data-id="' . $oDish->getId() . '">
                        <td><input class="inpTitleDishTypeUpdate" type="text" value="' . $oDish->getTitle(). '"></td>
                        <td class="tdFlex">
                            <button class="btnBig mHover btnUpdateTitleDishType">
                                <span class="">Modifier le titre</span>
                            </button>
                            <form method="post" action="#">
                                ' . wp_nonce_field('deleteDishType', "delete_dish_type_nonce") . '
                                <input type="hidden" name="idDishType" value="' . $oDish->getId() . '" />
                                <button type="submit" name="delete_dish_type" id="btnDeleteDishType">
                                    <span class="dashicons dashicons-trash dashicons-action mHover"></span>
                                </button>
                                <span class="errorField">' . $sErrDeleteDishType . '</span>
                            </form>
                        </td>
                    </tr>';
    }
    return $sTrMenu;
}




//GERER LES PLATS
/**
 * @param array $aFoodDish
 * @param array $aDishType
 * @param array $aErrDeleteFoodDish
 * @return string
 */
function getTableRowFoodDish($aFoodDish, $aDishType, $aErrDeleteFoodDish)
{
    $sTrOption = '';

    /**
     * @var FoodDish $oFoodDish
     */
    foreach($aFoodDish as $oFoodDish)
    {
        //Option du select pour chaque ligne
        $oOptionDishType = new HtmlSelectOption($aDishType, 'getTitle', $oFoodDish->getIdDishType());

        if(count($oOptionDishType->getErrArray()) > 0) $sSelect = implode(', ', $oOptionDishType->getErrArray());
        else $sSelect = '<select class="selIdDishTypeUpFoodDish">' . $oOptionDishType->getOptionHtml() . '</select>';

        //Gestion des erreurs
        $sErrDeleteFoodDish = '';
        if(count($aErrDeleteFoodDish) > 0 && $oFoodDish->getId() === intval(array_key_first($aErrDeleteFoodDish)))
        {
            $sErrDeleteFoodDish = $aErrDeleteFoodDish[array_key_first($aErrDeleteFoodDish)];
        }

        $sTrOption .= '<tr data-id="' . $oFoodDish->getId() . '">
                        <td>' . $sSelect . '</td>
                        <td class="tdInpTitleUpFoodDish"><input type="text" class="inpTitleUpFoodDish" name="" value="' . $oFoodDish->getTitle() . '"></td>
                        <td class="tdTxtDescUpFoodDish"><textarea class="txtDescUpFoodDish" name="txtDescUpFoodDish">' . $oFoodDish->getDescription() . '</textarea></td>
                        <td><input type="number" class="inpPriceUpFoodDish" name ="inpPriceUpFoodDish" value="' . $oFoodDish->getPrice() . '"></td>
                        <td class="tdFlex">
                            <button class="btnBig mHover btnUpdateDishFood">
                                <span class="">Modifier le plat</span>
                            </button>
                             <form method="post" action="#">
                                ' . wp_nonce_field('deleteFoodDish', "delete_food_dish_nonce") . '
                                <input type="hidden" name="idFoodDish" value="' . $oFoodDish->getId() . '" />
                                <button type="submit" name="delete_food_dish" id="btnDeleteFoodDish">
                                    <span class="dashicons dashicons-trash dashicons-action mHover"></span>
                                </button>
                                <span class="errorField">' . $sErrDeleteFoodDish . '</span>
                            </form>
                        </td>
                    </tr>';
    }
    return $sTrOption;
}





//GERER LES PLATS
/**
 * @param array $aOption
 * @param array $aMenu
 * @param array $aErrDeleteMenuOption
 * @return string
 */
function getTableRowOptionMenu(array $aOption, array $aMenu, array $aErrDeleteMenuOption)
{
    $sTrOption = '';

    /**
     * @var RestaurantMenuOption $oOption
     */
    foreach($aOption as $oOption)
    {
        //Option du select pour chaque ligne
        $oOptionMenu = new HtmlSelectOption($aMenu, 'getTitle', $oOption->getIdMenu());

        if(count($oOptionMenu->getErrArray()) > 0) $sSelect = implode(', ', $oOptionMenu->getErrArray());
        else $sSelect = '<select class="selIdMenuUpMenuOption">' . $oOptionMenu->getOptionHtml() . '</select>';

        //Gestion des erreurs
        $sErrDeleteMenuOption = '';
        if(count($aErrDeleteMenuOption) > 0 && $oOption->getId() === intval(array_key_first($aErrDeleteMenuOption)))
        {
            $sErrDeleteMenuOption = $aErrDeleteMenuOption[array_key_first($aErrDeleteMenuOption)];
        }

        $sTrOption .= '<tr data-id="' . $oOption->getId() . '">
                        <td>' . $sSelect . '</td>
                        <td><input type="text" class="inpTitleUpMenuOption" name="" value="' . $oOption->getTitle() . '"></td>
                        <td><textarea class="txtDescUpMenuOption" name="txtDescUpMenuOption" cols="100" rows="1">' . $oOption->getDescription() . '</textarea></td>
                        <td><input type="number" class="inpPriceUpMenuOption" name ="inpPriceUpMenuOption" value="' . $oOption->getPrice() . '"></td>
                        <td>
                             <form method="post" action="#">
                                ' . wp_nonce_field('deleteMenuOption', "delete_menu_option_nonce") . '
                                <input type="hidden" name="idMenuOption" value="' . $oOption->getId() . '" />
                                <button type="submit" name="delete_menu_option" id="btnDeleteMenuOption">
                                    <span class="dashicons dashicons-trash dashicons-action mHover"></span>
                                </button>
                                <span class="errorField">' . $sErrDeleteMenuOption . '</span>
                            </form>
                        </td>
                    </tr>';
    }
    return $sTrOption;
}


