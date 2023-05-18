<?php

//Infos client si connecté
if($oClient){
    $sFirstName = $oClient->getFirstName();
    $sLastName = $oClient->getLastName();
    $sTel = $oClient->getTel();
    $sAllergie = $oClient->getAllergy();
    $sMail = $oClient->getEmail();
    $iNbGuest = $oClient->getNbGuest();
}


$sNoonHourBooking = '';
$sEveningHourBooking = '';
if($aStrHtml){
    $sNoonHourBooking = $aStrHtml[OpeningTimes::NOON];
    $sEveningHourBooking = $aStrHtml[OpeningTimes::EVENING];
}else{
    $sError = 'An error occured in function getHtmlHourBooking(), please contact an admin, ' . $aStrHtml;
}
get_header();
?>
    <div class="row firstRow">
        <div class="col-12"><h2>Réservez votre table au Quai Antique</h2></div>
    </div>
    <div class="row">
        <div class="col-12 offset-lg-4 col-lg-4" id="ctnFormBookTable">
            <div class="body">
                <p class="error"><?= $sError ?></p>
                <p class="success"><?= $sSuccess ?></p>
                <form method="post" action="#" id="formBookTable">
                    <?= wp_nonce_field('bookTable', "book_table_nonce") ?>
                    <div class="elf">
                        <?= wp_nonce_field('root_ajax', "nc_ajax") ?>
                        <label for="inpDateBook">Date</label>
                        <input
                            type="text"
                            id="inpDateBook"
                            name="inpDateBook"
                            value="<?= $sDateValue ?>"
                            autocomplete="off"
                            class="datepicker"
                            data-action="<?php echo admin_url( 'admin-ajax.php' ); ?>"
                            data-date-start-date="<?= $sDateToday ?>">
                    </div>
                    <div class="elf" id="ctnHourBooking">
                        <div class="sectionHourBooking" data-time="<?= OpeningTimes::NOON ?>">
                            <div class="head ">Midi</div>
                            <div class="body">
                                <?= $sNoonHourBooking ?>
                            </div>
                        </div>
                        <div class="sectionHourBooking" data-time="<?= OpeningTimes::EVENING ?>">
                            <div class="head ">Soir</div>
                            <div class="body">
                                <?= $sEveningHourBooking ?>
                            </div>
                        </div>
                    </div>
                    <div class="elf">
                        <label for="inpNbGuest">Nb de convives</label>
                        <input type="number" id="inpNbGuest" name="inpNbGuest" min="1" max="<?= Bookings::getNbGuestsMax(); ?>" value="<?= $iNbGuest ?>" required="required">
                        <p class="error"><?= $sErrNbGuest ?></p>
                    </div>
                    <div class="elf">
                        <label for="inpPrenom">Prénom</label>
                        <input type="text" id="inpFirstName" name="inpFirstName" value="<?= $sFirstName?>" required="required">
                        <p class="error"><?= $sErrFirstName ?></p>
                    </div>
                    <div class="elf">
                        <label for="inpNom">Nom</label>
                        <input type="text" id="inpLastName" name="inpLastName" value="<?= $sLastName ?>" required="required">
                        <p class="error"><?= $sErrLastName ?></p>
                    </div>
                    <div class="elf">
                        <label for="inpMail">Mail</label>
                        <input type="email" id="inpMail" name="inpMail" value="<?= $sMail ?>" required="required">
                        <p class="error"><?= $sErrEmail ?></p>
                    </div>
                    <div class="elf">
                        <label for="inpTel">Téléphone</label>
                        <input type="tel" id="inpTel" name="inpTel" pattern="[0-9]{10}" placeholder="0102030405" value="<?= $sTel ?>" required="required">
                        <p class="error"><?= $sErrTel ?></p>
                    </div>
                    <div class="elf">
                        <label for="txtAllergie">Allergie(s)</label>
                        <textarea name="txtAllergie" id="" cols="18" rows="4"><?= $sAllergie ?></textarea>
                        <p class="error"><?= $sErrAllergy ?></p>
                    </div>
                    <button type="submit" class="btn btnSaillance big" name="book-table">Je réserve ma table</button>
                </form>
            </div>
        </div>
    </div>
</div>

<?php get_footer() ?>