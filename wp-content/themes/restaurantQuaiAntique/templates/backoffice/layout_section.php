<?php
$sClassHide = 'hide';
if($oTab->active){ $sClassHide = ''; }

?>

<div class="backOfficeSection <?= $sClassHide ?>" data-id_tab="<?= $oTab->id ?>"><?= $sContent ?></div>
