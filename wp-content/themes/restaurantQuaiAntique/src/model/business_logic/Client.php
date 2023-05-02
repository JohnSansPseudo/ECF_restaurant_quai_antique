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
    private array $aErr = array();

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
     */
    public function __construct(string $sEmail, string $sPassword, string $sFirstName, string $sLastName, string $sTelephone, string $sAllergy, int $iId=0)
    {
        $this->setId($iId);
        $this->setEmail($sEmail);
        $this->setPassword($sPassword);
        $this->setFirstName($sFirstName);
        $this->setLastName($sLastName);
        $this->setTelephone($sTelephone);
        $this->setAllergy($sAllergy);
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
            $this->aErr[] = $oParam->getStringError();
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
        $oParam = new ParamString($sEmail, self::Class . ' email ', 3);
        if($oParam->getStringError() !== ''){
            $this->aErr[] = $oParam->getStringError();
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
        $oParam = new ParamString($sPassword, self::Class . ' email ', 3, 50);
        if($oParam->getStringError() !== ''){
            $this->aErr[] = $oParam->getStringError();
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
        $oParam = new ParamString($sFirstName, self::Class . ' firstName ', 3, 50);
        if($oParam->getStringError() !== ''){
            $this->aErr[] = $oParam->getStringError();
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
        $oParam = new ParamString($sLastName, self::Class . ' lastName ', 3, 50);
        if($oParam->getStringError() !== ''){
            $this->aErr[] = $oParam->getStringError();
        }
        else $this->lastName = $sLastName;
        return $this;
    }

    /**
     * @return string
     */
    public function getTelephone(): string
    {
        return $this->tel;
    }

    /**
     * @param string $sTelephone
     * @return Client
     */
    public function setTelephone(string $sTelephone): Client
    {
        $oParam = new ParamString($sTelephone, self::Class . ' telephone ', 10, 10);
        if($oParam->getStringError() !== ''){
            $this->aErr[] = $oParam->getStringError();
        }
        else $this->tel = $sTelephone;
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
        $oParam = new ParamString($sAllergy, self::Class . ' allergy ', 0, 1000);
        if($oParam->getStringError() !== ''){
            $this->aErr[] = $oParam->getStringError();
        }
        else $this->allergy = $sAllergy;
        return $this;
    }
}