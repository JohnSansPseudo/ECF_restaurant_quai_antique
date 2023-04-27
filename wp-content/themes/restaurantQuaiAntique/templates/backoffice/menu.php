<?php

//Option du select pour ajouter un option à un menu
$sOptionAddOption = '';
foreach($aMenu as $oMenu)
{
    $sOptionAddOption .= '<option value="' . $oMenu->getId() . '">' . $oMenu->getTitle() . '</option>';
}

//Liste de tous les menus
$sTrMenu = '';
foreach($aMenu as $oMenu)
{
    $sTrMenu .= '<tr data-id="' . $oMenu->getId() . '">
                    <td data-title=""><input class="inpTitleMenuUpdate" type="text" value="' . $oMenu->getTitle(). '"></td>
                    <td><span class="btnDeleteMenu dashicons dashicons-trash dashicons-action mHover"></span></td>
                </tr>';
}
ob_start();

$sAddMenu = '<form method="post" action="#">
                <div id="cntAddMenu">
                    <input type="hidden" name="add-menu-key" value="addMenuRestaurantBackOffice">
                    <div class="elf">
                        <label for="inpTitleMenu">Titre du menu</label>
                        <input type="text" id="inpTitleMenu" name="inpTitleMenu" min="3" max="50"/>
                    </div>
                    <button type="submit" id="btnAddMenu" name="add-menu">Ajouter le menu</button>
                </div>
            </form>';
$sTitle = 'Ajouter un menu';
$sBody = $sAddMenu;
include('layout_subsection.php');

$sUpdateMenu = '<table id="tblEditMenu">
                    <thead>
                        <tr>
                            <th>Titre du menu</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody> ' . $sTrMenu . ' </tbody>
                </table>';
$sTitle = 'Gérer les menus';
$sBody = $sUpdateMenu;
include('layout_subsection.php');

$sOptionMenu = '<div id="ctnAddOptionMenu">
                         <div class="elf">
                            <label for="selOptionMenu">Menu de l\'option</label>
                            <select id="selOptionMenu" name="selOptionMenu">' . $sOptionAddOption . '</select>
                        </div>
                        
                        <div class="elf">
                            <label for="inpTitleOption">Titre de l\'option</label>
                            <input type="text" id="inpTitleOption" name="inpTitleOption" />
                        </div>
                        
                        <div class="elf">
                            <label for="inpDescOption">Description</label>
                            <input type="text" id="inpDescOption" name="inpDescOption" />
                        </div>
                        
                        <div class="elf">
                            <label for="inpPriceOption">Prix</label>
                            <input type="text" id="inpPriceOption" name="inpPriceOption" />
                        </div>
                        
                        <button type="submit" class="btn" >Ajouter l\'option au menu</button>
                    </div>';
$sTitle = 'Ajouter une option de menu';
$sBody = $sOptionMenu;
include('layout_subsection.php');
$sContent = ob_get_clean();

$oTab = $aTab['menu'];
ob_start();
include('layout_section.php');
$sContent = ob_get_clean();



