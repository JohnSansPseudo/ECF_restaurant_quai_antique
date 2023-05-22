<?php

Class TestCreateAccount
{
    function mainTestCreateAccount()
    {
        echo 'Start ' . __FUNCTION__ . '<br/>';
        try {

            /**
             * @var Client $oClient
             */
            $oClient = $this->testCreateClientAccountByUserForm();
            if($oClient){
                Clients::getInstance()->deleteById($oClient->getId());
                echo htmlMessageTest('Clients::getInstance()->deleteById');
            }  else htmlMessageTest('Clients::getInstance()->deleteById', false, 'Error delete client');
            echo 'End ' . __FUNCTION__ . '<br/>';

        } catch(Exception $e) {
            echo $e->getMessage();
            die();
        }
    }

    /**
     * @return bool
     */
    public function testCreateClientAccountByUserForm()
    {
        //Faire varier les data pour tester les erreurs
        $_POST['add-client'] = '';
        $_POST['inpFirstName'] = 'Test';
        $_POST['inpLastName'] = 'TestTest';
        $_POST['inpTel'] = '0102030405';
        $_POST['inpMail'] = 'test@test.com';
        $_POST['txtAllergie'] = 'allergy';
        $_POST['inpNbGuestDef'] = '5';
        $_POST['inpPassword'] = 'test';
        $_REQUEST['add_client_nonce'] = wp_create_nonce('addClient');
        $oClient = addClient(true);
        if($oClient && is_object($oClient) && get_class($oClient) === Client::class) {
            htmlMessageTest( __FUNCTION__);
            return $oClient;
        }else{
            htmlMessageTest( __FUNCTION__, false, 'Error');
            var_dump($oClient);
            die();
        }
    }


}