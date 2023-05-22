<?php

$sTr = '';
/**
 * @var OpeningTime $oOpening
 */

foreach($aOpeningTime as $oOpening)
{
    $sStartTimeDay = null;
    if($oOpening->getStartTimeDay() !== null) $sStartTimeDay = substr($oOpening->getStartTimeDay(), 0, 5);
    $sEndTimeDay = null;
    if($oOpening->getEndTimeDay() !== null) $sEndTimeDay = substr($oOpening->getEndTimeDay(), 0, 5);

    $sPlaceDeb = '12:00';
    $sPlaceFin = '15:00';
    if($oOpening->getTimeDay() === OpeningTimes::EVENING){
        $sPlaceDeb = '19:00';
        $sPlaceFin = '21:00';
    }

    $sTr .= '<tr data-id="' . $oOpening->getId() . '">
                <td>' . ucfirst($oOpening->getDay()) . '</td>
                <td>' . ucfirst($oOpening->getTimeDay()) . '</td>
                <td><input type="time" class="inpTimeDay" data-moment="start" value="' . $sStartTimeDay . '" placeholder="' . $sPlaceDeb . '"/></td>
                <td><input type="time" class="inpTimeDay" data-moment="end" value="' . $sEndTimeDay . '" placeholder="' . $sPlaceFin . '"></td>
                <td><button class="btnSaveTimeDay">Enregistrer</button></td>
                <td><button class="btnEraseTimeDay"><span class="dashicons dashicons-trash dashicons-action mHover"></span>Effacer</button></td>
            </tr>';
}

ob_start();
//ADD DISH TYPE
$sBody = '<table id="tblOpeningTime">
                <tbody>
                    <tr>
                        <th>Jour</th>
                        <th>Moment</th>
                        <th>Début (HH:MM)</th>
                        <th>Fin (HH:MM)</th>
                        <th></th>
                        <th></th>
                    </tr>
                </tbody>
                <tbody>' . $sTr . '</tbody>
            </table>';



$sTitle = 'Gérer les jours d\'ouverture';
include('layout_subsection.php');
$sContent = ob_get_clean();
