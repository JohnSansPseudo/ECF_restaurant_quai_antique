<?php

$sTitle = 'Créez votre compte';
$sTitleBtn = 'Créer mon compte';
$sPassword = '<div class="elf">
                    <label for="inpPassword">Mot de passe (Les "< > %" sont exclus) </label>
                    <input type="password" id="inpPassword" name="inpPassword" value="" required>
                </div>';

$sConnectezVous = '<a href="' . get_site_url() . '/' . PageWordpress::SING_IN_NAME . '">Ou connectez-vous</a>';
$sRecaptcha = '<div class="g-recaptcha" data-sitekey="' . PUBLIC_KEY_RECAPTCHA . '"></div>';
$sScriptRecaptcha = '<script src="https://www.google.com/recaptcha/api.js" async defer></script>';
if($oClient){
    $sTitle = 'Modifiez votre compte';
    $sPassword = '';
    $sTitleBtn = 'Modifiez votre compte';

    $sFirstName = $oClient->getFirstName();
    $sLastName = $oClient->getLastName();
    $sTel = $oClient->getTel();
    $sAllergie = $oClient->getAllergy();
    $sMail = $oClient->getEmail();
    $iNbGuest = $oClient->getNbGuest();
    $sConnectezVous = '';
    $sRecaptcha = '';
    $sScriptRecaptcha = '';
}
if(LOCAL_SITE_USE === true){
    $sRecaptcha = '';
    $sScriptRecaptcha = '';
}
get_header();
?>
    <?= $sScriptRecaptcha ?>
    <div class="row firstRow">
        <div class="col-12">
            <h2><?= $sTitle ?></h2>
        </div>
    </div>
    <div class="row">
        <div class="col-12 offset-lg-4 col-lg-4  text-center" id="ctnFormAccount">
            <div class="body">
                <form method="post" action="#" id="formAccount">
                    <?= wp_nonce_field('addClient', 'add_client_nonce') ?>
                    <p class="error"><?= $sGlobalError ?></p>
                    <p class="success"><?= $sSuccess ?></p>
                    <div class="elf">
                        <label for="inpFirstName">Prénom</label>
                        <input type="text" id="inpFirstName" name="inpFirstName" value="<?= $sFirstName ?>" required="required">
                        <p class="error"><?= $sErrFirstName ?></p>
                    </div>
                    <div class="elf">
                        <label for="inpLastName">Nom</label>
                        <input type="text" id="inpLastName" name="inpLastName" value="<?= $sLastName ?>" required="required">
                        <p class="error"><?= $sErrLastName ?></p>
                    </div>
                    <div class="elf">
                        <label for="inpTel">Téléphone</label>
                        <input type="tel" id="inpTel" name="inpTel" pattern="[0-9]{10}" placeholder="0102030405" value="<?= $sTel ?>" required="required">
                        <p class="error"><?= $sErrTel ?></p>
                    </div>
                    <div class="elf">
                        <label for="txtAllergie">Allergie(s)</label>
                        <textarea name="txtAllergie" id="txtAllergie" cols="18" rows="3" placeholder="Détaillez ici vos allergies"><?= $sAllergie ?></textarea>
                        <p class="error"><?= $sErrAllergy ?></p>
                    </div>
                    <div class="elf">
                        <label for="inpMail">Mail</label>
                        <input type="email" id="inpMail" name="inpMail" value="<?= $sMail ?>" required="required">
                        <p class="error"><?= $sErrEmail ?></p>
                    </div>
                    <?= $sPassword ?>
                    <div class="elf">
                        <label for="inpNbGuestDef">Nb de convives par défaut</label>
                        <input type="number" id="inpNbGuestDef" name="inpNbGuestDef" value="<?= $iNbGuest ?>" min="1" max="<?= Bookings::getNbGuestsMax(); ?>">
                        <p class="error"><?= $sErrNbGuest ?></p>
                    </div>
                    <?= $sRecaptcha ?>
                    <button type="submit" class="btn" id="btnCreateAccount" name="add-client"><?= $sTitleBtn ?></button>
                </form>
                <div>
                    <?= $sConnectezVous ?>
                </div>
            </div>
        </div>
    </div>

<?php get_footer() ?>