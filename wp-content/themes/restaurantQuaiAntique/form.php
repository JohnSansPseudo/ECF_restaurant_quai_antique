<?php

$_POST['inpTitleMenu'] = '';
$sAction = null;
if(isset($_POST['action']) && $_POST['action'] !== '' && is_string($sAction) && strlen($sAction) > 3 && strlen($sAction) < 20) $sAction = $_POST['action'];
if($sAction !== null)
{
    try{

        switch($sAction)
        {
            case 'addMenu': addMenuForm();
                break;
        }


    } catch(Exception $e){
        echo $e->getMessage();
        die('Error action');
    }
}