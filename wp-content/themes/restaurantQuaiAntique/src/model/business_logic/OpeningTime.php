<?php


class OpeningTime
{
    private int $id;
    private string $day;
    private string $timeDay;
    private ?string $startTimeDay;
    private ?string $endTimeDay;
    private array $aErr = array();

    /**
     * @return array
     */
    public function getErrArray(): array
    {
        return $this->aErr;
    }

    /**
     * OpeningTime constructor
     * @param int $iId
     * @param string $sDay
     * @param string $sTimeDay
     * @param string|null $sStartTimeDay
     * @param string|null $sEndTimeDay
     */
    public function __construct(string $sDay, string $sTimeDay, string $sStartTimeDay=null, string $sEndTimeDay=null, int $iId=0)
    {
        if($iId) $this->setId($iId);
        $this->setDay($sDay);
        $this->setTimeDay($sTimeDay);
        $this->setStartTimeDay($sStartTimeDay);
        $this->setEndTimeDay($sEndTimeDay);
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
     * @return OpeningTime
     */
    public function setId(int $iId): OpeningTime
    {
        //Il ne peut pas y avoir plus de 14 entrées 7 jours fois deux moments dans la journée
        $oParam = new ParamInt($iId, self::Class . ' id ', 1, 14);
        if($oParam->getStringError() !== ''){
            $this->aErr[] = $oParam->getStringError();
        }
        else  $this->id = $iId;
        return $this;
    }

    /**
     * @return string
     */
    public function getDay(): string
    {
        return $this->day;
    }

    /**
     * @param string $sDay
     * @return OpeningTime
     */
    public function setDay(string $sDay): OpeningTime
    {
        $oParam = new ParamString($sDay, self::Class . ' day ', 5, 8);
        if($oParam->getStringError() !== ''){
            $this->aErr[] = $oParam->getStringError();
        }
        else $this->day = $sDay;
        return $this;
    }

    /**
     * @return string
     */
    public function getTimeDay(): string
    {
        return $this->timeDay;
    }

    /**
     * @param string $sTimeDay
     * @return OpeningTime
     */
    public function setTimeDay(string $sTimeDay): OpeningTime
    {
        $oParam = new ParamString($sTimeDay, self::Class . ' timeDay ', 4, 7);
        if($oParam->getStringError() !== ''){
            $this->aErr[] = $oParam->getStringError();
        }
        else $this->timeDay = $sTimeDay;
        return $this;
    }

    /**
     * @return string |null
     */
    public function getStartTimeDay()
    {
        return $this->startTimeDay;
    }

    /**
     * @param string | null $sStartTimeDay
     * @return OpeningTime
     */
    public function setStartTimeDay($sStartTimeDay): OpeningTime
    {
        if($sStartTimeDay !== null){
            $oParam = new ParamString($sStartTimeDay, self::Class . ' startTimeDay ', 5, 8);
            if($oParam->getStringError() !== ''){
                $this->aErr[] = $oParam->getStringError();
            }
            else $this->startTimeDay = $sStartTimeDay;
        }
        else $this->startTimeDay = $sStartTimeDay;
        return $this;
    }

    /**
     * @return string |null
     */
    public function getEndTimeDay()
    {
        return $this->endTimeDay;
    }

    /**
     * @param string | null $sEndTimeDay
     * @return OpeningTime
     */
    public function setEndTimeDay($sEndTimeDay): OpeningTime
    {
        if($sEndTimeDay !== null){
            $oParam = new ParamString($sEndTimeDay, self::Class . ' endTimeDay ', 5, 8);
            if($oParam->getStringError() !== ''){
                $this->aErr[] = $oParam->getStringError();
            }
            else $this->endTimeDay = $sEndTimeDay;
        }
        else $this->endTimeDay = $sEndTimeDay;
        return $this;
    }
}