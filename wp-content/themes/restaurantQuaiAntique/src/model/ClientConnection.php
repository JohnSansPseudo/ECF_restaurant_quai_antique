<?php


class ClientConnection
{
    private const SALT_PASSWORD = 'quai*';

    function __construct($sMail, $sPassword)
    {
        $aClient = Clients::getInstance()->getByWhere(array('email' => $sMail, 'password' => $sPassword));
        if(is_array($aClient) && count($aClient) === 1) {
            /**
             * @var $oClient Client
             */
            $oClient = array_pop($aClient);
            $this->setSession($oClient->getEmail());
        }
    }

    private function getSession(){
        if(isset($_SESSION['quai_client']['email']) && $_SESSION['quai_client']['email'] !== ''){
            return $_SESSION['quai_client']['email'];
        }
        return false;
    }

    private function setSession($sMail){
        $_SESSION['quai_client']['email'] = $sMail;
    }

    static public function isConnected()
    {
        if(isset($_SESSION['quai_client']['email']) && $_SESSION['quai_client']['email'] !== ''){

            $aClient = Clients::getInstance()->getByWhere(array('email' => $_SESSION['quai_client']['email']));
            $oClient = null;
            if (is_array($aClient) && count($aClient) === 1) {
                /**
                 * @var Client $oClient
                 */
                $oClient = array_pop($aClient);
                return $oClient;
            }
        }else return false;
    }

    static public function deconnection()
    {
        unset($_SESSION['quai_client']['email']);
        session_destroy();
    }

    public static function generatePassword($sPassword)
    {
        return md5(ClientConnection::SALT_PASSWORD . $sPassword);
    }
}