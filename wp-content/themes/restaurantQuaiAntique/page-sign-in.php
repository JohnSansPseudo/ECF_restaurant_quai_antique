<?php
if(get_current_user_id() > 0){
    header('Location:' . get_admin_url());
}
$sErrConnClient = '';
if(isset($_POST['err_conn_client'])) $sErrConnClient = $_POST['err_conn_client'];

$sMail = '';
if(isset($_POST['err_conn_client'])) $sMail = $_POST['log'];

$sForm = '<div id="ctnConnexion">
            <div class="body">
                <p class="info text-center">Connectez-vous et réservez plus facilement</p>
                <form 
                    id="formUserConn" 
                    action="#" 
                    method="post"
                    data-page_ajax="' . admin_url('admin-ajax.php' ) . '"
                    data-page_reload="' . get_site_url() . '/' . PageWordpress::SING_IN_NAME . '"
                    data-page_admin_conn="' . get_site_url() . '/wp-login.php"
                    data-conn_admin="0">
                    <p class="error">' . $sErrConnClient . '</p>
                    ' . wp_nonce_field('connClient', 'conn_client_nonce') . '
                    <div class="elf ">
                        ' . wp_nonce_field('root_ajax', 'nc_ajax') . '
                        <label for="user_login">Mail</label>
                        <input type="text" id="user_login" name="log" value="' . $sMail . '">
                        <p class="error"></p>
                    </div>
                    <div class="elf">
                        <label for="user_pass">Mot de passe</label>
                        <input type="password" id="user_pass" name="pwd">
                        <p class="error"></p>
                    </div>
                    <button type="submit" class="btn " name="conn-client" id="btnConn">Connexion</button>
                    <p class="error errorForm"></p>
                </form>
            </div>
            <div class="footer">
                <a href="' . get_site_url() . '/' . PageWordpress::ACCOUNT_NAME . '">Créer mon compte</a>
            </div>
        </div>';


if(ClientConnection::isConnected()){
    $sForm = '<div id="ctnConnected">
                    <div class="body">
                        <p class="success">Vous êtes connecté, bienvenue</p>
                        <a class="btn btnSaillance" href="' . get_site_url() . '/' . PageWordpress::BOOK_TABLE_NAME . '">Réserver une table</a>
                        <a class="btn" href="' . get_site_url() . '/' . PageWordpress::ACCOUNT_NAME . '">Modifiez votre compte client</a>
                    </div>
                    <div class="footer">
                        <form method="post" action="#" name="deco_client">
                            ' . wp_nonce_field('decoClient', 'deco_client_nonce') . '
                            <button type="submit" name="deco-client" class="btn ">Me déconnecter</button>
                        </form>
                    </div>
                </div>';
}
get_header();
?>
    <div class="row">
        <div class="col-12">
            <h2>Connexion à votre compte</h2>
        </div>
    </div>
    <div class="row ">
        <div class="col-12 offset-lg-4 col-lg-4">
            <?= $sForm ?>
        </div>
    </div>
<?php get_footer() ?>