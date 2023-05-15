<?php

$sError = '';
$sSuccess = '';
if(isset($_GET['error_file'])){
    switch($_GET['error_file']){
        case '1': $sError = 'There is no file to upload.'; break;
        case '3': $sError = 'File is over 8 Mo'; break;
        case '4': $sError = 'Error saving the image, try again or contact an admin'; break;
        case '5': $sError = 'Error saving the image metadata, try again or contact an admin'; break;
    }
}
if(isset($_POST['success_file'])) $sSuccess = 'File uploaded';

//WP_Widget_Media::form();

//media_upload_gallery_form();

//media_upload_gallery_form();

//media_buttons();
//media_upload_gallery_form(array());

//get_media_item(array());

//media_upload_gallery();

//media_upload_form();

//media_upload_gallery();


//define('UPLOADS', 'images' )" dans wp-config.php

//Dossier de sauvegarde des fichiers
//wp-content/uploads/2023/05/ => prendre le dossier du mois / année courante !
//Il faut aussi créer un attachment post
//

// get the upload directory and make a test.txt file
/*$upload_dir = wp_upload_dir();
$filename = trailingslashit($upload_dir['path']).'test.txt';

// by this point, the $wp_filesystem global should be working, so let's use it to create a file
global $wp_filesystem;
if ( ! $wp_filesystem->put_contents( $filename, 'Test file contents', FS_CHMOD_FILE) ) {
    echo 'error saving file!';
}*/

//wp_media_upload_handler();



//TABLE wp_postmeta

//meta_key => _wp_attached_file
//meta_key => _wp_attachment_image_alt
//meta_key => _wp_attachment_metadata

ob_start();
?>
<div>
    <p class="error"><?= $sError ?></p>
    <p class="success"><?= $sSuccess ?></p>
</div>
<form method="post" action="#" enctype="multipart/form-data">
    <div class="elf">
        <?= wp_nonce_field('addMediaImgFile', 'add_media_img_file') ?>
        <label for="inpFileGallery">Insérer un fichier</label>
        <input type="file" id="inpFileGallery" name="inpFileGallery">
    </div>
    <button type="submit" name="btnAddMediaImgFile">Envoyer</button>
</form>
<?php $sContent = ob_get_clean(); ?>
    <!--<div class="wrap">
        <h1>Ajouter une image</h1>

        <form enctype="multipart/form-data" method="post" action="http://ecf_studi.localhost/wp-admin/media-new.php" class="media-upload-form type-form validate html-uploader" id="file-form">

            <div id="media-upload-notice">
            </div>
            <div id="media-upload-error">
            </div>
            <script type="text/javascript">
                var resize_height = 1024, resize_width = 1024,
                    wpUploaderInit = {"browse_button":"plupload-browse-button","container":"plupload-upload-ui","drop_element":"drag-drop-area","file_data_name":"async-upload","url":"http:\/\/ecf_studi.localhost\/wp-admin\/async-upload.php","filters":{"max_file_size":"41943040b"},"multipart_params":{"post_id":0,"_wpnonce":"9d7f363660","type":"","tab":"","short":"1"},"webp_upload_error":true,"heic_upload_error":true};
            </script>

            <div id="plupload-upload-ui" class="hide-if-no-js drag-drop">
                <div id="drag-drop-area" style="position: relative;">
                    <div class="drag-drop-inside">
                        <p class="drag-drop-info">Déposez vos fichiers pour les téléverser</p>
                        <p>ou</p>
                        <p class="drag-drop-buttons"><input id="plupload-browse-button" type="button" value="Sélectionnez des fichiers" class="button" style="position: relative; z-index: 1;"></p>
                    </div>
                </div>
                <p class="upload-flash-bypass">
                    Vous utilisez l’outil de téléversement multi-fichiers. Si vous rencontrez des problèmes, essayez la <a href="http://ecf_studi.localhost/wp-admin/media-new.php?browser-uploader" target="_blank">méthode du navigateur</a> à la place.	</p>
                <div id="html5_1h07n1eem4mnbs14ig1osr7ld3_container" class="moxie-shim moxie-shim-html5" style="position: absolute; top: 0px; left: 0px; width: 0px; height: 0px; overflow: hidden; z-index: 0;"><input id="html5_1h07n1eem4mnbs14ig1osr7ld3" type="file" style="font-size: 999px; opacity: 0; position: absolute; top: 0px; left: 0px; width: 100%; height: 100%;" multiple="" accept=""></div></div>

            <div id="html-upload-ui" class="hide-if-js">
                <p id="async-upload-wrap">
                    <label class="screen-reader-text" for="async-upload">
                        Téléverser		</label>
                    <input type="file" name="async-upload" id="async-upload">
                    <input type="submit" name="html-upload" id="html-upload" class="button button-primary" value="Téléverser">		<a href="#" onclick="try{top.tb_remove();}catch(e){}; return false;">Annuler</a>
                </p>
                <div class="clear"></div>
                <p class="upload-html-bypass hide-if-no-js">

            </div>

            <p class="max-upload-size">
                Taille de fichier maximale : 40 Mo.</p>

            <script type="text/javascript">
                var post_id = 0, shortform = 3;
            </script>
            <input type="hidden" name="post_id" id="post_id" value="0">
            <input type="hidden" id="_wpnonce" name="_wpnonce" value="9d7f363660"><input type="hidden" name="_wp_http_referer" value="/wp-admin/media-new.php?browser-uploader">	<div id="media-items" class="hide-if-no-js"></div>
        </form>
    </div>-->

<?php
include('layout.php');