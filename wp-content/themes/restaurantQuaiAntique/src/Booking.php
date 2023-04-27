<?php


class Booking
{

    private int $id;
    private int $idOpening;
    private string $email;
    private string $firstName;
    private string $lastName;
    private string $tel;
    private ?string $allergy;
    private int $nbGuest;
    private string $startTime;
    private string $bookingDate;
    private array $aErr = array();

    /**
     * @return array
     */
    public function getErrArray(): array
    {
        return $this->aErr;
    }


    /**
     * Booking constructor.
     * @param int $iId
     * @param int $iIdOpening
     * @param string $sEmail
     * @param string $sFirstName
     * @param string $sLastName
     * @param string $sTelephone
     * @param int $iNbGuest
     * @param string $sStartTime
     * @param string $sDate
     * @param string |null $sAllergy
     */
    public function __construct(int $iIdOpening, string $sEmail, string $sFirstName, string $sLastName, string $sTelephone, string $sAllergy=null, int $iNbGuest, string $sStartTime, string $sDate, int $iId=0)
    {
        $this->setId($iId);
        $this->setIdOpening($iIdOpening);
        $this->setEmail($sEmail);
        $this->setFirstName($sFirstName);
        $this->setLastName($sLastName);
        $this->setTel($sTelephone);
        $this->setAllergy($sAllergy);
        $this->setNbGuest($iNbGuest);
        $this->setStartTime($sStartTime);
        $this->setBookingDate($sDate);
    }

    /**
     * @return int
     */
    public function getIdOpening(): int
    {
        return $this->idOpening;
    }

    /**
     * @param int $idOpening
     * @return Booking
     */
    public function setIdOpening(int $idOpening): Booking
    {
        $oParam = new ParamInt($idOpening, self::Class . 'id opening', 1);
        if($oParam->getStringError() !== ''){
            $this->aErr[] = $oParam->getStringError();
        }
        else  $this->idOpening = $idOpening;
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
     * @param int $iNbGuest
     * @return Booking
     */
    public function setNbGuest(int $iNbGuest): Booking
    {
        $oParam = new ParamInt($iNbGuest, self::Class . 'nb guest', 1);
        if($oParam->getStringError() !== ''){
            $this->aErr[] = $oParam->getStringError();
        }
        else  $this->nbGuest = $iNbGuest;
        return $this;
    }

    /**
     * @return string
     */
    public function getStartTime(): string
    {
        return $this->startTime;
    }

    /**
     * @param string $sStartTime
     * @return Booking
     */
    public function setStartTime(string $sStartTime): Booking
    {
        $oParam = new ParamString($sStartTime, self::Class . ' start time', 8, 8);
        if($oParam->getStringError() !== ''){
            $this->aErr[] = $oParam->getStringError();
        }
        else $this->startTime = $sStartTime;
        return $this;
    }

    /**
     * @return string
     */
    public function getBookingDate(): string
    {
        return $this->bookingDate;
    }

    /**
     * @param string $sDate
     * @return Booking
     */
    public function setBookingDate(string $sDate): Booking
    {
        $oParam = new ParamString($sDate, self::Class . ' date ', 10, 10);
        if($oParam->getStringError() !== ''){
            $this->aErr[] = $oParam->getStringError();
        }
        else $this->bookingDate = $sDate;
        return $this;
    }



    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @param int $iId
     * @return Booking
     */
    public function setId(int $iId): Booking
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
     * @return Booking
     */
    public function setEmail(string $sEmail): Booking
    {
        $oParam = new ParamString($sEmail, self::Class . ' email ', 3, 50);
        if($oParam->getStringError() !== ''){
            $this->aErr[] = $oParam->getStringError();
        }
        else $this->email = $sEmail;
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
     * @return Booking
     */
    public function setFirstName(string $sFirstName): Booking
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
     * @return Booking
     */
    public function setLastName(string $sLastName): Booking
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
    public function getTel(): string
    {
        return $this->tel;
    }

    /**
     * @param string $sTelephone
     * @return Booking
     */
    public function setTel(string $sTelephone): Booking
    {
        $oParam = new ParamString($sTelephone, self::Class . ' telephone ', 10, 10);
        if($oParam->getStringError() !== ''){
            $this->aErr[] = $oParam->getStringError();
        }
        else $this->tel = $sTelephone;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getAllergy()
    {
        return $this->allergy;
    }

    /**
     * @param string|null $sAllergy
     * @return Booking
     */
    public function setAllergy($sAllergy): Booking
    {
        $oParam = new ParamString($sAllergy, self::Class . ' allergy ', 0, 1000);
        if($oParam->getStringError() !== ''){
            $this->aErr[] = $oParam->getStringError();
        }
        else $this->allergy = $sAllergy;
        return $this;
    }


}