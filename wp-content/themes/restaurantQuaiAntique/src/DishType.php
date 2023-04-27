<?php


class DishType
{
    private int $id;
    private string $title;
    private array $aErr = array();

    /**
     * @return array
     */
    public function getErrArray(): array
    {
        return $this->aErr;
    }

    /**
     * DishType constructor.
     * @param int $iId
     * @param string $sTitle
     */
    public function __construct( string $sTitle, int $iId=0)
    {
        $this->setId($iId)->setTitle($sTitle);
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
     * @return DishType
     */
    public function setId(int $iId): DishType
    {
        $oParam = new ParamInt($iId, self::Class . ' id', 1);
        if($oParam->getStringError() !== ''){
            $this->aErr[] = $oParam->getStringError();
        }
        else  $this->id = $iId;
        return $this;
    }

    /**
     * @return string
     */
    public function getTitle(): string
    {
        return $this->title;
    }

    /**
     * @param string $sTitle
     * @return DishType
     */
    public function setTitle(string $sTitle): DishType
    {
        $oParam = new ParamString($sTitle, self::Class . ' title', 3, 50);
        if($oParam->getStringError() !== ''){
            $this->aErr[] = $oParam->getStringError();
        }
        else  $this->title = $sTitle;
        return $this;
    }
}
