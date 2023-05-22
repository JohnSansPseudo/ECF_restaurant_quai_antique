<?php

//MODAL choix des images
$sImgChoice = '';
foreach ($aAttachment as $oAttachment)
{
    $sImgChoice .= '<div class="ctnItemImgChoice mHover" data-id_attachment="' . $oAttachment->ID . '">
                        <img src="' . $oAttachment->guid.'" class="imgChoiceGallery">
                    </div>';
}
$sImgChoice = '<div id="imgChoiceWrapper" data-id_item_gallery="" class="hide">
                    <div id="ctnImgChoice" >
                        <div class="head">Choisissez une image</div>
                        <div class="body">' . $sImgChoice . '</div>
                    </div>
                </div>';
//Fin MODAL choix des images

//LIGNE DU TABLEAU POUR LE PARAMETRAGE
$sTr = '';
/**
 * @var $oItemGallery ImageGallery
 */

foreach($aItemGallery as $oItemGallery)
{
    $sSrc = '';
    if(isset( $aAttachment[$oItemGallery->getIdAttachment()])) $sSrc = $aAttachment[$oItemGallery->getIdAttachment()]->guid;
    $sTr .= '<tr data-id_img_gallery="' . $oItemGallery->getId() . '">
                <td>' . $oItemGallery->getId() . '</td>
                <td class="ctnImgChoice">
                    <div class="ctnImgChoosed"><img src="' . $sSrc . '" class="imgChoosed"/></div>
                    <button class="btnImgChoice">Choisir une image</button>
                </td>
                <td><textarea rows="1">' . $oItemGallery->getTitle() . '</textarea></td>
                <td>
                    <button type="submit" name="delete_menu" class="btnDeleteImgGal">
                        <span class="dashicons dashicons-trash dashicons-action mHover"></span>
                    </button>
                </td>
            </tr>';
}

$sTable = '<table id="tblGallery">
                <thead>
                    <tr>
                        <th>Photo numéro</th>
                        <th>Choix de la photo</th>
                        <th>Titre de la photo</th>
                    </tr>
                </thead>
                <tbody>' . $sTr . '</tbody>
            </table>';

ob_start();

/*Form ajouter une image*/
$sBody = '<div>
            <p class="error">' . $sError . '</p>
            <p class="success">' . $sSuccess . '</p>
        </div>
        <form method="post" action="#" enctype="multipart/form-data" id="formAddImgMedia">
            <div class="elf">
                ' . wp_nonce_field('addMediaImgFile', 'add_media_img_file') . '
                <label for="inpFileGallery">Insérer une image</label>
                <input type="file" id="inpFileGallery" name="inpFileGallery" >
            </div>
            <button type="submit" name="btnAddMediaImgFile" class="btn">Envoyer</button>
        </form>';

$sTitle = 'Ajouter une image';
include('layout_subsection.php');

/*Modifiez la gallerie*/
$sBody = $sTable;
$sTitle = 'Modifiez la gallerie';
include('layout_subsection.php');

/*Bas de page*/
echo $sImgChoice;
echo '<div id="overlayGallery" class="hide"></div>';
$sContent = ob_get_clean(); ?>

<?php
include('layout.php');