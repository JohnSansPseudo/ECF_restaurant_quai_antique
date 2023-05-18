<?php


function addMediaImgFile()
{
    $sBackPath = get_admin_url() .'admin.php?page=QuaiAntiqueParam?admin_action=gallery';
    if(!isset($_POST['btnAddMediaImgFile'])) return false;

    if(!isset($_REQUEST['add_media_img_file']) || !wp_verify_nonce($_REQUEST['add_media_img_file'], 'addMediaImgFile' )){
        die('Vous n\'avez pas l\'autorisation d\'effectuer cette action. <br/><br/><a href="' . $sBackPath . '">Retour</a>');
    }

    unset($_POST['success_file']);
    unset($_POST['error_file']);
    unset($_POST['btnAddMediaImgFile']);
    unset($_REQUEST['add_media_img_file']);

    $uploaded_file = $_FILES['inpFileGallery'];

    if (isset($uploaded_file['error']) && $uploaded_file['error'] !== UPLOAD_ERR_OK) throw new RuntimeException($uploaded_file['error']);

    if($uploaded_file['size'] > 8200000){
        $_POST['error_file'] = 'File is over 8 Mo';
        wp_die( __( 'File is over 8 Mo' ));
    }else{
        $overrides = array( 'test_form' => false );

        $wp_filetype   = wp_check_filetype_and_ext( $uploaded_file['tmp_name'], $uploaded_file['name'] );
        if(!wp_match_mime_types( 'image', $wp_filetype['type'])) {
            wp_die( __( 'The uploaded file is not a valid image. Please try again.' ));
        } else {
            $aFile = wp_handle_upload( $uploaded_file, $overrides );
            if(isset($aFile['error'])) wp_die( $aFile['error'] );
            $sUrl = $aFile['url'];
            $sType = $aFile['type'];
            $aFile = $aFile['file'];
            $sFilename = wp_basename( $aFile );

            $aAttachment = array(
                'post_title' => $sFilename,
                'post_content' => $sUrl,
                'post_mime_type' => $sType,
                'guid' => $sUrl
            );

            // Save the data.
            $idAttachment = wp_insert_attachment( $aAttachment, $aFile );
            if(!$idAttachment) header('Location:' . $sBackPath . '?error_file=4');
            // Add the metadata.
            wp_update_attachment_metadata( $idAttachment, wp_generate_attachment_metadata( $idAttachment, $aFile ) );
            do_action( 'wp_create_file_in_uploads', $aFile, $idAttachment );
            $_POST['success_file'] = 'File uploaded';
        }
    }
}