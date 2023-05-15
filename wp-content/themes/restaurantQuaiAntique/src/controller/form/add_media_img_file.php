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
    $uploaded_file = $_FILES['inpFileGallery'];
    if(!isset($uploaded_file)){
        $_POST['error_file'] = 'There is no file to upload';
        header('Location:' . $sBackPath);
    }

    if($uploaded_file['size'] > 8000000){
        $_POST['error_file'] = 'File is over 8 Mo';
        wp_die( __( 'File is over 8 Mo' ));
    }

    $overrides = array( 'test_form' => false );

    $wp_filetype   = wp_check_filetype_and_ext( $uploaded_file['tmp_name'], $uploaded_file['name'] );
    if(!wp_match_mime_types( 'image', $wp_filetype['type'])) {
        wp_die( __( 'The uploaded file is not a valid image. Please try again.' ));
    }
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

/**
 * Handles an Image upload for the background image.
 *
 * @since 3.0.0
 */
function handle_upload() {

    //from class-custom-background.php

    if ( empty( $_FILES ) ) {
        return;
    }

    check_admin_referer( 'custom-background-upload', '_wpnonce-custom-background-upload' );

    $overrides = array( 'test_form' => false );

    $uploaded_file = $_FILES['import'];
    $wp_filetype   = wp_check_filetype_and_ext( $uploaded_file['tmp_name'], $uploaded_file['name'] );
    if ( ! wp_match_mime_types( 'image', $wp_filetype['type'] ) ) {
        wp_die( __( 'The uploaded file is not a valid image. Please try again.' ) );
    }

    $file = wp_handle_upload( $uploaded_file, $overrides );

    if ( isset( $file['error'] ) ) {
        wp_die( $file['error'] );
    }

    $url      = $file['url'];
    $type     = $file['type'];
    $file     = $file['file'];
    $filename = wp_basename( $file );

    // Construct the attachment array.
    $attachment = array(
        'post_title'     => $filename,
        'post_content'   => $url,
        'post_mime_type' => $type,
        'guid'           => $url,
        'context'        => 'custom-background',
    );

    // Save the data.
    $id = wp_insert_attachment( $attachment, $file );

    // Add the metadata.
    wp_update_attachment_metadata( $id, wp_generate_attachment_metadata( $id, $file ) );
    //update_post_meta( $id, '_wp_attachment_is_custom_background', get_option( 'stylesheet' ) );

    //set_theme_mod( 'background_image', sanitize_url( $url ) );

    $thumbnail = wp_get_attachment_image_src( $id, 'thumbnail' );
    set_theme_mod( 'background_image_thumb', sanitize_url( $thumbnail[0] ) );

    /** This action is documented in wp-admin/includes/class-custom-image-header.php */
    do_action( 'wp_create_file_in_uploads', $file, $id ); // For replication.
    //$this->updated = true;
}

function maFunctionUploadFile()
{
    /*
     dbr(wp_upload_dir());
     Array
        (
            [path] => C:\xampp\app\ecf_studi/wp-content/uploads/2023/05
            [url] => http://ecf_studi.localhost/wp-content/uploads/2023/05
            [subdir] => /2023/05
            [basedir] => C:\xampp\app\ecf_studi/wp-content/uploads
            [baseurl] => http://ecf_studi.localhost/wp-content/uploads
            [error] =>
        )
     */

    //$aDirInfos = wp_upload_dir();
    /*    $sDirYear = $aDirInfos['basedir'] . '/' . date('Y', time());
        $sDirMonth = $sDirYear . '/' . date('m', time());

        if(!is_dir($sDirYear)) mkdir($sDirYear);
        if(!is_dir($sDirMonth)) mkdir($sDirMonth);*/

    /* $sPath = $aDirInfos['path'] . '/'. $_FILES['inpFileGallery']['name'];
     $sGuid = $aDirInfos['baseurl'] . $aDirInfos['subdir'] . '/' . $_FILES['inpFileGallery']['name'];
     $sAttachedFileMetaValue = substr($aDirInfos['subdir'] . '/' . $_FILES['inpFileGallery']['name'], 1);
     $bUp = move_uploaded_file($_FILES['inpFileGallery']['tmp_name'], $sPath);
     if($bUp){
         $aArgs = array(
             'post_name' => 'test_name',
             'post_title' => 'test_titre',
             'post_mime_type' => $_FILES['inpFileGallery']['type'],
             'post_content' => '',
             'post_status' => '',
             'guid' => $sGuid);
         $idAttachment = wp_insert_attachment($aArgs, $sAttachedFileMetaValue);

         $aData = array();*/

    //wp_update_attachment_metadata( $idAttachment, $data ); //post.php
    //transient
    //_wp_attachment_metadata
    /*add_post_meta();
    wp_meta();*/

    /* }
     dbrDie($bUp);*/

    /*$aFormFields = array('inpFileGallery');
    $url = '';
    $creds = request_filesystem_credentials($url, '', false, false, $aFormFields);
    if($creds){

        $upload_dir = wp_upload_dir();
        $sFilename = trailingslashit($upload_dir['path']). $_FILES['inpFileGallery']['name'];
        global $wp_filesystem;
        $oFileSystemBase = new WP_Filesystem_Base();
        $oFileSystemBase->is_dir();
        $oFileSystemBase->size();
        $oFileSystemBase->

        //$wp_filesystem->
        //$b = $wp_filesystem->put_contents( $sFilename, 'Test file contents', FS_CHMOD_FILE);

        */
}