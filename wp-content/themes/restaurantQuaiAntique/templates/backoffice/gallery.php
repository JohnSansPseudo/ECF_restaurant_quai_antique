<?php

function getContentSectionGallery($oTab)
{
    $sBody = '<div>' . $oTab->id . '</div>';
    return getContentSection($oTab, $sBody);
}

