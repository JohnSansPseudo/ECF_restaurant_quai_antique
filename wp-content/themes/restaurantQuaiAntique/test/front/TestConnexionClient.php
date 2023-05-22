<?php


Class TestConnexionClient
{

    function testMainConnexionClient()
    {
        echo 'Start ' . __FUNCTION__ . '<br/>';
        try{
            $oTestCreateAccount = new TestCreateAccount();
            /**
             * @var Client $oClient
             */
            $oClient = $oTestCreateAccount->testCreateClientAccountByUserForm();
            if($oClient){
                //Le client est automatiquement connecté à la création de son compte on commence donc par le déconnecté
                $this->testDeconnexionClient();
                $this->testConnexionClientFail();
                $this->testConnexionClientConn($oClient->getEmail(), $oClient->getPassword());
                $this->testDeconnexionClient();
                Clients::getInstance()->deleteById($oClient->getId());
                htmlMessageTest('Clients::getInstance()->deleteById');
                echo 'End ' . __FUNCTION__ . '<br/>';
            } else htmlMessageTest('Clients::getInstance()->deleteById', false, 'Error delete client');

        }catch(Exception $e){
            echo $e->getMessage();
            die();
        }

    }


    function testConnexionClientFail()
    {
        $sMail = 'toto@error.com';
        $sPass = 'sdfdf';
        new ClientConnection($sMail, $sPass);
        $b = ClientConnection::isConnected();
        if($b) htmlMessageTest(__FUNCTION__, false,'Client should be connected');
        else htmlMessageTest(__FUNCTION__);
    }

    /**
     * @param $sMail string
     * @param $sPass string
     * @throws Exception
     */
    function testConnexionClientConn($sMail, $sPass)
    {
        $_POST['log'] = $sMail;
        $_POST['pwd'] = $sPass;
        $_POST['conn-client'] = '';
        $_REQUEST['conn_client_nonce'] = wp_create_nonce('connClient');
        connexionClient();
        $b = ClientConnection::isConnected();

        if($b === false) htmlMessageTest(__FUNCTION__, false, 'Client should be connected');
        else htmlMessageTest(__FUNCTION__);
    }

    /**
     * @throws Exception
     */
    function testDeconnexionClient()
    {
        $_REQUEST['deco_client_nonce'] = wp_create_nonce('decoClient');
        $_POST['deco-client'] = '';
        decoClient();
        $b = ClientConnection::isConnected();
        if($b) htmlMessageTest(__FUNCTION__, false, 'Client should not be connected');
        else htmlMessageTest( __FUNCTION__);
    }
}