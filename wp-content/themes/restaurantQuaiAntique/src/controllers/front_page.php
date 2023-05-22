<?php


function getCartePage()
{
    $aDish = DishTypes::getInstance()->getAllData();
    $aFoodDish = FoodDishes::getInstance()->getAllData();
    require_once(get_template_directory() . '/templates/front/page-' . PageWordpress::CARTE_NAME . '.php');
}

function getBookTablePage()
{
    $oClient = ClientConnection::isConnected();

    $sDateToday = date('d/m/Y', time());
    $sDateValue = $sDateToday;
    if(isset($_POST['inpDateBook'])){
        $sDateValue = htmlspecialchars($_POST['inpDateBook']);
        $aDate = explode('/', $sDateValue);
        $sDateSql = $aDate[2] . '-' . $aDate[1] . '-' . $aDate[0];
    }else $sDateSql = date('Y-m-d', time());

    $aStrHtml = OpeningTimes::getInstance()->getHtmlHourBooking($sDateSql);

    $sError = '';
    $sSuccess = '';

    $iNbGuest = 2;
    $sFirstName = '';
    $sLastName = '';
    $sTel = '';
    $sMail = '';
    $sAllergie = '';


    if(isset($_POST['nbGuest'])) $iNbGuest = htmlspecialchars($_POST['nbGuest']);
    if(isset($_POST['inpMail'])) $sMail = htmlspecialchars($_POST['inpMail']);
    if(isset($_POST['inpTel'])) $sTel = htmlspecialchars($_POST['inpTel']);
    if(isset($_POST['txtAllergie'])) $sAllergie = htmlspecialchars($_POST['txtAllergie']);
    if(isset($_POST['inpLastName'])) $sLastName = htmlspecialchars($_POST['inpLastName']);
    if(isset($_POST['inpFirstName'])) $sFirstName = htmlspecialchars($_POST['inpFirstName']);

    $sErrFirstName = '';
    $sErrTel = '';
    $sErrLastName = '';
    $sErrAllergy = '';
    $sErrEmail = '';
    $sErrNbGuest = '';
    $bError = false;
    if(isset($_POST['err_book_table'])){
        $sError = htmlspecialchars($_POST['err_book_table']);
        $bError = true;
    }
    if(isset($_POST['err_firstName'])){
        $sErrFirstName = htmlspecialchars($_POST['err_firstName']);
        $bError = true;
    }
    if(isset($_POST['err_tel'])){
        $sErrTel = htmlspecialchars($_POST['err_tel']);
        $bError = true;
    }
    if(isset($_POST['err_lastName'])){
        $sErrLastName = htmlspecialchars($_POST['err_lastName']);
        $bError = true;
    }
    if(isset($_POST['err_allergy'])){
        $sErrAllergy = htmlspecialchars($_POST['err_allergy']);
        $bError = true;
    }
    if(isset($_POST['err_email'])){
        $sErrEmail = htmlspecialchars($_POST['err_email']);
        $bError = true;
    }
    if(isset($_POST['err_nbGuest'])){
        $sErrNbGuest = htmlspecialchars($_POST['err_nbGuest']);
        $bError = true;
    }

    if(isset($_GET['book']) && intval($_GET['book']) === 1 && $bError===false)
    {
        $aSuccess = array('Votre table est réservée');

        if(isset($_GET['date']) && isset($_GET['date']) !== ''){
            $sDateFr = date('d/m/Y', strtotime(htmlspecialchars($_GET['date'])));
            $aSuccess[] = 'pour le ' . $sDateFr;
        }
        if(isset($_GET['time']) && isset($_GET['time']) !== ''){
            $aSuccess[] = ' à ' . htmlspecialchars($_GET['time']);
        }
        $sSuccess =  implode(' ', $aSuccess);
    }

    require_once(get_template_directory() . '/templates/front/page-' . PageWordpress::BOOK_TABLE_NAME . '.php');
}

function getCreateAccountPage()
{
    $oClient = ClientConnection::isConnected();

    $sFirstName = '';
    $sLastName = '';
    $sTel = '';
    $sAllergie = '';
    $sMail = '';
    $iNbGuest = 2;

    if(isset( $_POST['inpFirstName']))$sFirstName = htmlspecialchars($_POST['inpFirstName']);
    if(isset( $_POST['inpLastName']))$sLastName = htmlspecialchars($_POST['inpLastName']);
    if(isset( $_POST['inpTel']))$sTel = htmlspecialchars($_POST['inpTel']);
    if(isset( $_POST['txtAllergie']))$sAllergie = htmlspecialchars($_POST['txtAllergie']);
    if(isset( $_POST['inpMail']))$sMail = htmlspecialchars($_POST['inpMail']);
    if(isset( $_POST['inpNbGuestDef']))$iNbGuest = htmlspecialchars($_POST['inpNbGuestDef']);

    $sGlobalError = '';
    $sSuccess = '';

    $sErrFirstName = '';
    $sErrTel = '';
    $sErrLastName = '';
    $sErrAllergy = '';
    $sErrEmail = '';
    $sErrNbGuest = '';
    if(isset($_POST['err_add_client'])) $sGlobalError = htmlspecialchars($_POST['err_add_client']);

    if(isset($_POST['err_firstName'])){
        $sErrFirstName = htmlspecialchars($_POST['err_firstName']);
        $bError = true;
    }
    if(isset($_POST['err_tel'])){
        $sErrTel = htmlspecialchars($_POST['err_tel']);
        $bError = true;
    }
    if(isset($_POST['err_lastName'])){
        $sErrLastName = htmlspecialchars($_POST['err_lastName']);
        $bError = true;
    }
    if(isset($_POST['err_allergy'])){
        $sErrAllergy = htmlspecialchars($_POST['err_allergy']);
        $bError = true;
    }
    if(isset($_POST['err_email'])){
        $sErrEmail = htmlspecialchars($_POST['err_email']);
        $bError = true;
    }
    if(isset($_POST['err_nbGuest'])){
        $sErrNbGuest = htmlspecialchars($_POST['err_nbGuest']);
        $bError = true;
    }

    if(isset($_GET['success_add_client']) && $bError === false) $sSuccess = 'Votre compte est créé';
    if(isset($_GET['update_client']) && $bError === false) $sSuccess = 'Votre compte est modifié';

    require_once(get_template_directory() . '/templates/front/page-' . PageWordpress::ACCOUNT_NAME . '.php');
}

function getHomePage()
{
    $aMenus = RestaurantMenus::getInstance()->getAllData();
    $aOptionMenus = RestaurantMenuOptions::getInstance()->getAllData();
    $aImgGallery = Gallery::getInstance()->getAttchementGallery();
    require_once(get_template_directory() . '/templates/front/page-' . PageWordpress::HOME_NAME . '.php');
}

function getSignInPage()
{

    if(get_current_user_id() > 0){
        header('Location:' . get_admin_url());
    }
    $sErrConnClient = '';
    if(isset($_POST['err_conn_client'])) $sErrConnClient = htmlspecialchars($_POST['err_conn_client']);

    $sMail = '';
    if(isset($_POST['err_conn_client'])) $sMail = htmlspecialchars($_POST['log']);


    require_once(get_template_directory() . '/templates/front/page-' . PageWordpress::SING_IN_NAME . '.php');
}