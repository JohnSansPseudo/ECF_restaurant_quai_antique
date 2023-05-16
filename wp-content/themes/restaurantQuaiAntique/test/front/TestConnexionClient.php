<?php


Class TestConnexionClient
{

    function testMainConnexionClient()
    {
        echo 'Start testMainConnexionClient<br/>';

        $oTestCreateAccount = new TestCreateAccount();
        $oTestCreateAccount->testCreatClientAccountByUserForm();
        $oClient = $oTestCreateAccount->getLastClientInsert();

        //Le client est automatiquement connecté à la création de son compte on commence donc par le déconnecté

        $bDeco = $this->testDeconnexionClient();
        if(!$bDeco) dbrDie($bDeco);
        else echo 'testDeconnexionClient => ok<br/>';

        $bFail = $this->testConnexionClientFail();
        if($bFail !== true) dbrDie($bFail);
        echo 'testConnexionClientFail => ok<br/>';

        $bConn = $this->testConnexionClientConn($oClient->getEmail(), $oClient->getPassword());
        if($bConn !== true) echo 'testConnexionClient => ok<br/>';

        $bDeco = $this->testDeconnexionClient();
        if(!$bDeco) dbrDie($bDeco);
        else echo 'testDeconnexionClient => ok<br/>';
        Clients::getInstance()->deleteById($oClient->getId());

        dbrDie('End ' . self::class);
    }

    /**
     * @return bool|string
     */
    function testConnexionClientFail()
    {
        $sMail = 'toto@error.com';
        $sPass = 'sdfdf';
        new ClientConnection($sMail, $sPass);
        if(ClientConnection::isConnected()) return 'testConnexionClientFail => Client should not be connected';
        else return true;
    }

    function testConnexionClientConn($sMail, $sPass)
    {
        $_POST['log'] = $sMail;
        $_POST['pwd'] = $sPass;
        $_REQUEST['conn_client_nonce'] = wp_create_nonce('connClient');
        connexionClient();
        if(ClientConnection::isConnected()) return 'testConnexionClient => Client should be connected';
        else return 'Client should not be connected';
    }

    function testDeconnexionClient()
    {
        $_REQUEST['deco_client_nonce'] = wp_create_nonce('decoClient');
        $_POST['deco-client'] = '';
        decoClient();
        if(ClientConnection::isConnected()) return 'testDeconnexionClient => Client should not be connected';
        else return true;
    }


}