<?php
$sFirstName = '';
$sLastName = '';
$sTel = '';
$sAllergie = '';
$sMail = '';
$iNbGuest = 2;

if(isset( $_POST['inpFirstName']))$sFirstName = $_POST['inpFirstName'];
if(isset( $_POST['inpLastName']))$sLastName = $_POST['inpLastName'];
if(isset( $_POST['inpTel']))$sTel = $_POST['inpTel'];
if(isset( $_POST['txtAllergie']))$sAllergie = $_POST['txtAllergie'];
if(isset( $_POST['inpMail']))$sMail = $_POST['inpMail'];
if(isset( $_POST['inpNbGuestDef']))$iNbGuest = $_POST['inpNbGuestDef'];

$sGlobalError = '';
$sSuccess = '';
if(isset($_POST['err_add_client'])) $sGlobalError = $_POST['err_add_client'];
if(isset($_GET['success_add_client'])) $sSuccess = 'Votre compte est créé';
if(isset($_GET['update_client'])) $sSuccess = 'Votre compte est modifié';

$sTitle = 'Créez votre compte';
$sTitleBtn = 'Créer mon compte';
$sPassword = '<div class="elf">
                    <label for="inpPassword">Mot de passe (Les "< > %" sont exclus) </label>
                    <input type="password" id="inpPassword" name="inpPassword" value="" required>
                </div>';

$sConnectezVous = '<a href="' . get_site_url() . '/' . PageWordpress::SING_IN_NAME . '">Ou connectez-vous</a>';

//Si le client est connecté
$oClient = ClientConnection::isConnected();

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
}
get_header();
?>

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
                        <input type="text" id="inpFirstName" name="inpFirstName" value="<?= $sFirstName ?>" required>
                    </div>
                    <div class="elf">
                        <label for="inpLastName">Nom</label>
                        <input type="text" id="inpLastName" name="inpLastName" value="<?= $sLastName ?>" required>
                    </div>
                    <div class="elf">
                        <label for="inpTel">Téléphone</label>
                        <input type="tel" id="inpTel" name="inpTel" pattern="[0-9]{10}" placeholder="0102030405" value="<?= $sTel ?>" required>
                    </div>
                    <div class="elf">
                        <label for="txtAllergie">Allergie(s)</label>
                        <textarea name="txtAllergie" id="txtAllergie" cols="18" rows="3" placeholder="Détaillez ici vos allergies"><?= $sAllergie ?></textarea>
                    </div>
                    <div class="elf">
                        <label for="inpMail">Mail</label>
                        <input type="email" id="inpMail" name="inpMail" value="<?= $sMail ?>" required>
                    </div>
                    <?= $sPassword ?>
                    <div class="elf">
                        <label for="inpNbGuestDef">Nb de convives par défaut</label>
                        <input type="number" id="inpNbGuestDef" name="inpNbGuestDef" value="<?= $iNbGuest ?>" min="1" max="<?= Bookings::getNbGuestsMax(); ?>">
                    </div>
                    <button type="submit" class="btn" id="btnCreateAccount" name="add-client"><?= $sTitleBtn ?></button>
                </form>
                <div>
                    <?= $sConnectezVous ?>
                </div>
            </div>
        </div>
    </div>

<?php get_footer() ?>