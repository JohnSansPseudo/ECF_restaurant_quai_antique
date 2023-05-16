<?php

Class TestCreateAccount
{
    function mainTestCreateAccount()
    {
        echo 'Start mainTestCreateAccount<br/>';
        if(!$this->testCreatClientAccountByUserForm()) die();

        $oClient = $this->getLastClientInsert();
        if($oClient){
            Clients::getInstance()->deleteById($oClient->getId());
            echo 'deleteById => ok<br/>';
        }  else echo 'Error delete client<br/>';
        echo 'End mainTestCreateAccount<br/>';
        die();
    }

    /**
     * @return bool
     */
    public function testCreatClientAccountByUserForm()
    {
        //Il faut désactiver le header_location dans le fichier

        $_POST['add-client'] = '';
        $_POST['inpFirstName'] = 'Test';
        $_POST['inpLastName'] = 'TestTest';
        $_POST['inpTel'] = '0102030405';
        $_POST['inpMail'] = 'test@test.com';
        $_POST['txtAllergie'] = 'allergy';
        $_POST['inpNbGuestDef'] = '5';
        $_POST['inpPassword'] = 'test';
        //wp_verify_nonce($_REQUEST['add_client_nonce'], 'addClient' )
        $_REQUEST['add_client_nonce'] = wp_create_nonce('addClient');
        addClient();

        if(isset($_POST['success_add_client']) && $_POST['success_add_client'] == 1){
            echo 'testCreatClientAccountByUserForm => ok<br/>';
            return true;
        }
        else if(isset($_POST['err_add_client'])){
            echo $_POST['err_add_client'] . '<br/>';
            return false;
        }
    }

    /**
     * @return bool|Client
     */
    public function getLastClientInsert()
    {
        $aClient = Clients::getInstance()->getAllData();
        if(is_array($aClient)) return $aClient[max(array_keys($aClient))];
        else return false;
    }
}