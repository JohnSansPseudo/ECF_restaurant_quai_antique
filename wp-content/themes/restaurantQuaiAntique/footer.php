<?php
$a = get_posts(array('post_type' => 'attachment'));
$sPathLogoWhite = '';
$oLogoWhite = null;
/**
 * @var WP_Post $o
 */
foreach($a as $o){
    if($o->post_name === 'logo_white'){
        $oLogoWhite = $o;
        $sPathLogoWhite = $o->guid;
    }
}

//footer-menu
$aMenuArgs = array(
    'theme_location' => 'footer-menu',
    'container' => false);

//OPENING TIMES
$sTr = '';
$aOpeningTime = OpeningTimes::getInstance()->getAllData();
/**
 * @var OpeningTime $oOpening
 */
$aDataDay = array();
foreach($aOpeningTime as $oOpening) {
    $aDataDay[$oOpening->getDay()][$oOpening->getTimeDay()] = $oOpening;
}
foreach($aDataDay as $sDay => $aData) {

    /**
     *@var $oNoon OpeningTime
     */
    $oNoon = $aData[OpeningTimes::NOON];
    $sStartTimeDay = 'Fermé';
    if($oNoon->getStartTimeDay() !== null) $sStartTimeDay = substr($oNoon->getStartTimeDay(), 0, 5);
    $sEndTimeDay = 'Fermé';
    if($oNoon->getEndTimeDay() !== null) $sEndTimeDay = substr($oNoon->getEndTimeDay(), 0, 5);
    $sNoon = $sStartTimeDay . '-' . $sEndTimeDay;
    if($sStartTimeDay === 'Fermé' && $sEndTimeDay === 'Fermé') $sNoon = 'Fermé';
    /**
     *@var $oEvening OpeningTime
     */
    $oEvening = $aData[OpeningTimes::EVENING];
    $sStartTimeDayEv = 'Fermé';
    if($oEvening->getStartTimeDay() !== null) $sStartTimeDayEv = substr($oEvening->getStartTimeDay(), 0, 5);
    $sEndTimeDayEv = 'Fermé';
    if($oEvening->getEndTimeDay() !== null) $sEndTimeDayEv = substr($oEvening->getEndTimeDay(), 0, 5);
    $sEvening = $sStartTimeDayEv . '-' . $sEndTimeDayEv;
    if($sStartTimeDayEv === 'Fermé' && $sEndTimeDayEv === 'Fermé') $sEvening = 'Fermé';

    $sTr .= '<tr>
                <td>' . ucfirst($sDay) . '</td>
                <td>' . $sNoon . '</td>
                <td>' . $sEvening .'</td>
            </tr>';
}
?>
        </div>
        <footer class="container-fluid">
            <div class="container">
                <div class="row">
                    <div class="col-12 col-md-4 ctnSectionFooter" data-section="logo">
                        <img src="<?= $sPathLogoWhite ?>" alt="logo" class="logoFooter"></div>
                    <div class="col-2 ctnSectionFooter" data-section="menu">
                        <div class="head fw-bold">Menu</div>
                        <div class="body"><?= wp_nav_menu($aMenuArgs); ?></div>
                    </div>
                    <div class="col ctnSectionFooter" >
                        <div class="head fw-bold">Informations</div>
                        <div class="body">
                            <p>Le Quai Antique<br/>15, avenue de beau regard<br/>73065 Chambéry</p>
                            <p>04 75 77 89 66<br/>contact@quai-antique.fr</p>
                            <p></p>
                        </div>
                    </div>
                    <div class="col ctnSectionFooter">
                        <div class="head fw-bold">Horaires d'ouverture</div>
                        <div class="body">
                            <table class="tblOpenningFooter">
                                <thead>
                                    <tr>
                                        <th class="">Jour</th>
                                        <th class=""><?= OpeningTimes::NOON ?></th>
                                        <th class=""><?= OpeningTimes::EVENING ?></th>
                                    </tr>
                                </thead>
                                <tbody><?= $sTr ?></tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </footer>
        <?php wp_footer() ?><!-- navbar admin keep it -->
    </body>
</html>

