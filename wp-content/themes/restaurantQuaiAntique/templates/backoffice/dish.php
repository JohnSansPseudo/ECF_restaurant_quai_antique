<?php


function getContentSectionDish($oTab)
{
    $sBody = '<div>' . $oTab->id . '</div>';
    return getContentSection($oTab, $sBody);
}
