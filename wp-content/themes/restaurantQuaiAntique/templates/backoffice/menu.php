<?php

//ADD MENU
$sErrAddMenu = '';
if(isset($_POST['err_add_menu'])) $sErrAddMenu = 'Ce menu existe déjà, merci d\'essayer avec un autre nom';
$sNameMenu = '';
if(isset($_POST['inpTitleMenu']))$sNameMenu = $_POST['inpTitleMenu'];

//DELETE MENU
$aErrDeleteMenu = array();
if(isset($_POST['err_del_menu'])){
    $aErrDeleteMenu[$_POST['idMenu']] =  $_POST['err_del_menu'];
}

//ADD MENU OPTION
$sErrAddMenuOption = '';
if(isset($_POST['err_add_menu_option'])) $sErrAddMenuOption = $_POST['err_add_menu_option'];



//DELETE MENU OPTION
$aErrDeleteMenuOption = array();
if(isset($_POST['err_del_menu_option'])){
    $aErrDeleteMenuOption[$_POST['idMenuOption']] =  $_POST['err_del_menu_option'];
}

ob_start();

//ADD MENU
$sBody = '<form method="post" action="#">
                <div id="cntAddMenu">
                    ' . wp_nonce_field('addMenu', "add_menu_nonce") . '
                    <div class="elf">
                        <div>
                            <label for="inpTitleMenu">Titre du menu</label>
                            <input type="text" id="inpTitleMenu" name="inpTitleMenu" min="3" max="50" value="' . $sNameMenu . '"/>
                        </div>
                        <p class="errorField">' . $sErrAddMenu . '</p>
                    </div>
                    <button type="submit" id="btnAddMenu" name="add-menu">Ajouter le menu</button>
                </div>
            </form>';
$sTitle = 'Ajouter un menu';
include('layout_subsection.php');

//UPDATE AND DELETE MENU
$sBody = '<table id="tblEditMenu">
                    <thead>
                        <tr>
                            <th>Titre du menu</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody> ' . getTableRowAddMenu($aMenu, $aErrDeleteMenu) . ' </tbody>
                </table>';
$sTitle = 'Gérer les menus';
include('layout_subsection.php');

//ADD OPTION MENU
$oOption = new HtmlSelectOption($aMenu, 'getTitle');
if(count($oOption->getErrArray()) > 0) $sOption = implode('<br/>', $oOption->getErrArray());
else $sOption = $oOption->getOptionHtml();
$sBody = '<form method="post" action="#">
            ' . wp_nonce_field('addMenuOption', "add_menu_option_nonce") . '
             <div class="elf">
                <label for="selOptionMenu">Menu de l\'option</label>
                <select id="selOptionMenu" name="selOptionMenu">' . $sOption . '</select>
            </div>
            <div class="elf">
                <label for="inpTitleOption">Titre de l\'option</label>
                <input type="text" id="inpTitleOption" name="inpTitleOption" />
            </div>
            <div class="elf">
                <label for="inpDescOption">Description</label>
                <textarea id="txtDescOption" name="txtDescOption"></textarea>
            </div>
            <div class="elf">
                <label for="inpPriceOption">Prix</label>
                <input type="text" id="inpPriceOption" name="inpPriceOption" />
            </div>
            <button type="submit" class="btn" name="addMenuOption">Ajouter l\'option au menu</button>
            <p class="errorField">' . $sErrAddMenuOption . '</p>
        </form>';
$sTitle = 'Ajouter une option de menu';
include('layout_subsection.php');

//UPDATE OPTION MENU
$sBody = '<table id="tblEditOptionMenu">
                    <thead>
                        <tr>
                            <th>Menu</th>
                            <th>Titre de l\'option</th>
                            <th>Description</th>
                            <th>Prix</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody> ' . getTableRowOptionMenu($aOptionMenu, $aMenu, $aErrDeleteMenuOption) . ' </tbody>
                </table>';
$sTitle = 'Gérer les options de menu';
include('layout_subsection.php');

$sContent = ob_get_clean();

//$oTab = $aTab['menu'];
ob_start();
include('layout_section.php');
$sContent = ob_get_clean();


//GERER LES OPTIONS DE MENUS
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
                        <td><textarea class="txtDescUpMenuOption" name="txtDescUpMenuOption">' . $oOption->getDescription() . '</textarea></td>
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


//GERER LES MENUS
/**
 * @param array $aMenu
 * @param array $aErrDeleteMenu
 * @var RestaurantMenu $oMenu
 * @return string
 */
function getTableRowAddMenu($aMenu, $aErrDeleteMenu)
{
    //Met en ligne de tableau tous les menus passés en param
    $sTrMenu = '';
    foreach($aMenu as $oMenu)
    {
        $sErrDeleteMenu = '';
        if(count($aErrDeleteMenu) > 0 && $oMenu->getId() === intval(array_key_first($aErrDeleteMenu)))
        {
            $sErrDeleteMenu = $aErrDeleteMenu[array_key_first($aErrDeleteMenu)];
        }
        $sTrMenu .= '<tr data-id="' . $oMenu->getId() . '">
                        <td><input class="inpTitleMenuUpdate" type="text" value="' . $oMenu->getTitle(). '"></td>
                        <td>
                            <form method="post" action="#">
                                ' . wp_nonce_field('deleteMenu', "delete_menu_nonce") . '
                                <input type="hidden" name="idMenu" value="' . $oMenu->getId() . '" />
                                <button type="submit" name="delete_menu" id="btnDeleteMenu">
                                    <span class="dashicons dashicons-trash dashicons-action mHover"></span>
                                </button>
                                <span class="errorField">' . $sErrDeleteMenu . '</span>
                            </form>
                        </td>
                    </tr>';
    }
    return $sTrMenu;
}




