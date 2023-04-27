<?php

function getContentSectionGuest($oTab)
{
    $sBody = '<div>' . $oTab->id . '</div>';
    return getContentSection($oTab, $sBody);
}