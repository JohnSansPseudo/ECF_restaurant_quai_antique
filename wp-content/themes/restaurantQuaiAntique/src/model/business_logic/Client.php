<?php


class Client
{

    private int $id;
    private string $email;
    private string $password;
    private string $firstName;
    private string $lastName;
    private string $tel;
    private string $allergy;
    private int $nbGuest;
    private array $aErr = array();

    /**
     * @return string
     */
    public function getTel(): string
    {
        return $this->tel;
    }
    /**
     * @param string $tel
     * @return Client
     */
    public function setTel(string $tel): Client
    {
        $oParam = new ParamString($tel, ' telephone ', 10, 10);
        if($oParam->getStringError() !== ''){
            $this->aErr['tel'] = $oParam->getStringError();
        } else if(!preg_match('/[0-9]{10}/', $tel)){
            $this->aErr['tel'] = 'Field telephone must be composed by 10 numbers';
        } else $this->tel = $tel;
        return $this;
    }

    /**
     * @return int
     */
    public function getNbGuest(): int
    {
        return $this->nbGuest;
    }

    /**
     * @param int $nbGuest
     * @return Client
     */
    public function setNbGuest(int $nbGuest): Client
    {
        $iMax = 1000;
        if(Bookings::getNbGuestsMax()) $iMax = Bookings::getNbGuestsMax();
        $oParam = new ParamInt($nbGuest, self::Class . ' nbGuestDef ', 1, $iMax);
        if($oParam->getStringError() !== ''){
            $this->aErr['nbGuest'] = $oParam->getStringError();
        }
        else $this->nbGuest = $nbGuest;
        return $this;
    }



    /**
     * @return array
     */
    public function getErrArray(): array
    {
        return $this->aErr;
    }


    /**
     * Client constructor.
     * @param int $iId
     * @param string $sEmail
     * @param string $sPassword
     * @param string $sFirstName
     * @param string $sLastName
     * @param string $sTelephone
     * @param string $sAllergy
     * @param int $nbGuest
     */
    public function __construct(string $sFirstName, string $sLastName, string $sTelephone, string $sEmail, string $sAllergy, string $sPassword, int $nbGuest, int $iId=0)
    {
        if($iId) $this->setId($iId);
        $this->setEmail($sEmail);
        $this->setPassword($sPassword);
        $this->setFirstName($sFirstName);
        $this->setLastName($sLastName);
        $this->setTel($sTelephone);
        $this->setAllergy($sAllergy);
        $this->setNbGuest($nbGuest);
    }

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param int $iId
     * @return Client
     */
    public function setId(int $iId): Client
    {
        $oParam = new ParamInt($iId, self::Class . ' id ', 1);
        if($oParam->getStringError() !== ''){
            $this->aErr['id'] = $oParam->getStringError();
        }
        else  $this->id = $iId;
        return $this;
    }

    /**
     * @return string
     */
    public function getEmail(): string
    {
        return $this->email;
    }

    /**
     * @param string $sEmail
     * @return Client
     */
    public function setEmail(string $sEmail): Client
    {
        $oParam = new ParamString($sEmail, ' email ', 3);
        if($oParam->getStringError() !== ''){
            $this->aErr['email'] = $oParam->getStringError();
        }else if(!filter_var($sEmail, FILTER_VALIDATE_EMAIL)){
            $this->aErr['email'] = 'email do not match with PHP FILTER_VALIDATE_EMAIL,  something@stuff.wok';
        }
        else $this->email = $sEmail;
        return $this;
    }

    /**
     * @return string
     */
    public function getPassword(): string
    {
        return $this->password;
    }

    /**
     * @param string $sPassword
     * @return Client
     */
    public function setPassword(string $sPassword): Client
    {
        $oParam = new ParamString($sPassword, ' email ', 7, 50);
        if($oParam->getStringError() !== ''){
            $this->aErr['password'] = $oParam->getStringError();
        }
        else $this->password = $sPassword;
        return $this;
    }

    /**
     * @return string
     */
    public function getFirstName(): string
    {
        return $this->firstName;
    }

    /**
     * @param string $sFirstName
     * @return Client
     */
    public function setFirstName(string $sFirstName): Client
    {
        $oParam = new ParamString($sFirstName, ' firstName ', 3, 50);
        if($oParam->getStringError() !== ''){
            $this->aErr['firstName'] = $oParam->getStringError();
        }
        else $this->firstName = $sFirstName;
        return $this;
    }

    /**
     * @return string
     */
    public function getLastName(): string
    {
        return $this->lastName;
    }

    /**
     * @param string $sLastName
     * @return Client
     */
    public function setLastName(string $sLastName): Client
    {
        $oParam = new ParamString($sLastName,  ' lastName ', 3, 50);
        if($oParam->getStringError() !== ''){
            $this->aErr['lastName'] = $oParam->getStringError();
        }
        else $this->lastName = $sLastName;
        return $this;
    }

    /**
     * @return string
     */
    public function getAllergy(): string
    {
        return $this->allergy;
    }

    /**
     * @param string $sAllergy
     * @return Client
     */
    public function setAllergy(string $sAllergy): Client
    {
        $oParam = new ParamString($sAllergy,  ' allergy ', 0, 1000);
        if($oParam->getStringError() !== ''){
            $this->aErr['allergy'] = $oParam->getStringError();
        }
        else $this->allergy = $sAllergy;
        return $this;
    }
}