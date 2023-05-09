<?php

function getContentSectionGallery($oTab)
{
    $sBody = '<div>' . $oTab->id . '</div>';
    return getContentSection($oTab, $sBody);
}

$sContent = '<div>Galleryjjj</div>';

include('layout.php');