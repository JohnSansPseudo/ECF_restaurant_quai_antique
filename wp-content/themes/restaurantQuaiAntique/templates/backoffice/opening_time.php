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

    $sTr .= '<tr data-id="' . $oOpening->getId() . '">
                <td>' . ucfirst($oOpening->getDay()) . '</td>
                <td>' . ucfirst($oOpening->getTimeDay()) . '</td>
                <td><input type="time" class="inpTimeDay" data-moment="start" value="' . $sStartTimeDay . '"/></td>
                <td><input type="time" class="inpTimeDay" data-moment="end" value="' . $sEndTimeDay . '"/></td>
                <td><button class="btnSaveTimeDay">Enregistrer</button></td>
                <td><button class="btnEraseTimeDay"><span class="dashicons dashicons-trash dashicons-action mHover"></span>Effacer</button></td>
            </tr>';
}

ob_start();
//ADD DISH TYPE
$sBody = '<table>
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
