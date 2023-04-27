<?php


function getContentSectionOpening($oTab)
{
    $sBody = '<div>' . $oTab->id . '</div>';
    return getContentSection($oTab, $sBody);
}