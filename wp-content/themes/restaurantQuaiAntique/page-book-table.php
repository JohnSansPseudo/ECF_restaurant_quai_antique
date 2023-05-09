<?php

$sError = '';
$sSuccess = '';

if(isset($_POST['err_book_table'])) $sError = $_POST['err_book_table'];
if(isset($_GET['book']) && $_GET['book'] == 1)
{
    $sSuccess = 'Votre table est réservée ';
    if(isset($_GET['date']) && isset($_GET['date']) !== ''){
        $sDateFr = date('d/m/Y', strtotime($_GET['date']));
        $sSuccess .= 'pour le ' . $sDateFr;
    }
    if(isset($_GET['time']) && isset($_GET['time']) !== ''){
        $sSuccess .= 'à ' . $_GET['time'];
    }
}

//Infos client si connecté
$iNbGuest = 2;
$sFirstName = '';
$sLastName = '';
$sTel = '';
$sMail = '';
$sAllergie = '';

$oClient = ClientConnection::isConnected();
if($oClient){
    $sFirstName = $oClient->getFirstName();
    $sLastName = $oClient->getLastName();
    $sTel = $oClient->getTel();
    $sAllergie = $oClient->getAllergy();
    $sMail = $oClient->getEmail();
    $iNbGuest = $oClient->getNbGuest();
}
$sDateToday = date('d/m/Y', time());

$sNoonHourBooking = '';
$sEveningHourBooking = '';

$aStrHtml = OpeningTimes::getInstance()->getHtmlHourBooking();
if($aStrHtml){
    $sNoonHourBooking = $aStrHtml[OpeningTimes::NOON];
    $sEveningHourBooking = $aStrHtml[OpeningTimes::EVENING];
}else{
    $sError = 'An error occured in function getHtmlHourBooking(), please contact an admin, ' . $aStrHtml;
}

get_header();
?>

    <div class="row">
        <div class="col-3"></div>
        <div class="col-6"><h2>Réservez votre table au Quai Antique</h2></div>
        <div class="col-3"></div>
    </div>
    <div class="row">
        <div class="col-3"></div>
        <div class="col-6">
            <p class="error"><?= $sError ?></p>
            <p class="success"><?= $sSuccess ?></p>
            <form method="post" action="#">
                <?= wp_nonce_field('bookTable', "book_table_nonce") ?>
                <div class="elf">
                    <?= wp_nonce_field('root_ajax', "nc_ajax") ?>
                    <label for="inpDateBook">Date</label>
                    <input
                        type="text"
                        id="inpDateBook"
                        name="inpDateBook"
                        value="<?= $sDateToday ?>"
                        autocomplete="off"
                        class="datepicker"
                        data-action="<?php echo admin_url( 'admin-ajax.php' ); ?>"
                        data-date-start-date="<?= $sDateToday ?>">
                </div>
                <div class="elf" id="ctnHourBooking">
                    <div class="sectionHourBooking" data-time="<?= OpeningTimes::NOON ?>">
                        <div class="head">Midi</div>
                        <div class="body">
                            <?= $sNoonHourBooking ?>
                        </div>
                    </div>
                    <div class="sectionHourBooking" data-time="<?= OpeningTimes::EVENING ?>">
                        <div class="head">Soir</div>
                        <div class="body">
                            <?= $sEveningHourBooking ?>
                        </div>
                    </div>
                </div>
                <div class="elf">
                    <label for="inpNbGuest">Nb de convives</label>
                    <input type="number" id="inpNbGuest" name="inpNbGuest" min="1" max="<?= Bookings::getNbGuestsMax(); ?>" value="<?= $iNbGuest ?>">
                </div>
                <div class="elf">
                    <label for="inpPrenom">Prénom</label>
                    <input type="text" id="inpFirstName" name="inpFirstName" value="<?= $sFirstName?>">
                </div>
                <div class="elf">
                    <label for="inpNom">Nom</label>
                    <input type="text" id="inpLastName" name="inpLastName" value="<?= $sLastName ?>">
                </div>
                <div class="elf">
                    <label for="inpMail">Mail</label>
                    <input type="text" id="inpMail" name="inpMail" value="<?= $sMail ?>">
                </div>
                <div class="elf">
                    <label for="inpTel">Téléphone</label>
                    <input type="text" id="inpTel" name="inpTel" value="<?= $sTel ?>">
                </div>
                <div class="elf">
                    <label for="txtAllergie">Allergie(s)</label>
                    <textarea name="txtAllergie" id="" cols="30" rows="4"><?= $sAllergie ?></textarea>
                </div>
                <button type="submit" class="btn btnSaillance" name="book-table">Je réserve ma table</button>
            </form>
        </div>
        <div class="col-3"></div>
    </div>

<?php get_footer() ?>