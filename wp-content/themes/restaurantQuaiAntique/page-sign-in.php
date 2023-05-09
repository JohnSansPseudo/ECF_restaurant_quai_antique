<?php
if(get_current_user_id() > 0){
    //header('Location:' . get_admin_url());
}
$sErrConnClient = '';
if(isset($_POST['err_conn_client'])) $sErrConnClient = $_POST['err_conn_client'];

$sMail = '';
if(isset($_POST['err_conn_client'])) $sMail = $_POST['log'];

$sForm = '<form id="formUserConn" action="#" method="post">
            <p class="error">' . $sErrConnClient . '</p>
            ' . wp_nonce_field('connClient', 'conn_client_nonce') . '
            <div class="elf">
                ' . wp_nonce_field('root_ajax', 'nc_ajax') . '
                <label for="user_login">Mail</label>
                <input type="text" id="user_login" name="log" value="' . $sMail . '" data-action="' . admin_url('admin-ajax.php' ) . '">
            </div>
            <div class="elf">
                <label for="user_pass">Mot de passe</label>
                <input type="password" id="user_pass" name="pwd">
            </div>
            <button type="submit" class="btn " name="conn-client" id="btnConn">Connexion</button>
        </form>';


if(ClientConnection::isConnected()){
    $sForm = '<div><p class="success">Vous êtes connecté, bienvenue</p></div>
                <form method="post" action="#" name="deco_client">
                    ' . wp_nonce_field('decoClient', 'deco_client_nonce') . '
                    <button type="submit" name="deco-client" class="btn ">Me déconnecter</button>
                </form>';
}
get_header();
?>
    <div class="row">
        <div class="col-3"></div>
        <div class="col-6"></div>
        <div class="col-3"></div>
    </div>
    <div class="row">
        <div class="col-3"></div>
        <div class="col-6">
            <?= $sForm ?>
        </div>
        <div class="col-3"></div>
    </div>
<?php get_footer() ?>