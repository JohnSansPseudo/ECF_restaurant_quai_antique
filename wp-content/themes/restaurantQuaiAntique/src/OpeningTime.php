<?php


class OpeningTime
{
    private int $id;
    private string $day;
    private string $timeDay;
    private ?string $startTimeDay;
    private ?string $endTimeDay;

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
        $this->setId($iId);
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
        $this->id = $iId;
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
        $this->day = $sDay;
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
        $this->timeDay = $sTimeDay;
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
        $this->startTimeDay = $sStartTimeDay;
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
        $this->endTimeDay = $sEndTimeDay;
        return $this;
    }
}