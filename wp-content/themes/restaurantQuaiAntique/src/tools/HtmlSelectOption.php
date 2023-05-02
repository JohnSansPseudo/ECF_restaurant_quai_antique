<?php


class HtmlSelectOption
{
    /**
     * @var array
     */
    private array $aData;
    /**
     * @var string
     */
    private string $sMethodVal;
    /**
     * @var int
     */
    private int $idDefault;
    /**
     * @var bool
     */
    private bool $bOption0;
    /**
     * @var array
     */
    private array $aIdExclude;

    /**
     * @var array
     */
    private array $aErr = array();

    /**
     * @return array
     */
    public function getData(): array
    {
        return $this->aData;
    }


    /**
     * @return array
     */
    public function getErrArray(): array
    {
        return $this->aErr;
    }

    /**
     * @param array $aData
     * @return HtmlSelectOption
     */
    public function setArrData(array $aData): HtmlSelectOption
    {
        $oParam = new ParamArray($aData, self::class . ' $aData', 1);
        if($oParam->getStringError() !== '') $this->aErr[] = $oParam->getStringError();
        else $this->aData = $aData;
        $this->aData = $aData;
        return $this;
    }

    /**
     * @return string
     */
    public function getMethodVal(): string
    {
        return $this->sMethodVal;
    }

    /**
     * @param string $sMethodVal
     * @return HtmlSelectOption
     */
    public function setStrMethodVal(string $sMethodVal): HtmlSelectOption
    {
        $oParam = new ParamString($sMethodVal, self::class . ' $sMethodVal', 3, 30);
        if($oParam->getStringError() !== '')  $this->aErr[] = $oParam->getStringError();
        else $this->sMethodVal = $sMethodVal;
        return $this;
    }

    /**
     * @return int
     */
    public function getIdDefault(): int
    {
        return $this->idDefault;
    }

    /**
     * @param int $idDefault
     * @return HtmlSelectOption
     */
    public function setIdDefault(int $idDefault): HtmlSelectOption
    {
        $oParam = new ParamInt($idDefault, self::class . ' $idDefault');
        if($oParam->getStringError() !== '')  $this->aErr[] = $oParam->getStringError();
        else $this->idDefault = $idDefault;
        return $this;
    }

    /**
     * @return bool
     */
    public function isOption0(): bool
    {
        return $this->bOption0;
    }

    /**
     * @param bool $bOption0
     * @return HtmlSelectOption
     */
    public function setBoolOption0(bool $bOption0): HtmlSelectOption
    {
        $oParam = new ParamBool($bOption0, self::class . '$bOption0');
        if($oParam->getStringError() !== '')  $this->aErr[] = $oParam->getStringError();
        else $this->bOption0 = $bOption0;
        return $this;
    }

    /**
     * @return array
     */
    public function getArrIdExclude(): array
    {
        return $this->aIdExclude;
    }

    /**
     * @param array $aIdExclude
     * @return HtmlSelectOption
     */
    public function setArrIdExclude(array $aIdExclude): HtmlSelectOption
    {
        $this->aIdExclude = $aIdExclude;
        return $this;
    }



    /**
     * @param array $aData
     * @param string $sMethodVal
     * @param int $idDefault
     * @param bool $bOption0
     * @param array $aIdExclude
     */
    public function __construct($aData, $sMethodVal, $idDefault=-1, $bOption0=false, $aIdExclude=array())
    {
        $this->setArrData($aData)
            ->setStrMethodVal($sMethodVal)
            ->setIdDefault($idDefault)
            ->setBoolOption0($bOption0)
            ->setArrIdExclude($aIdExclude);
    }

    /**
     * @return string
     */
    public function getOptionHtml()
    {
        $sMethodVal = $this->getMethodVal();
        $sOption = '';
        if($this->isOption0()) $sOption = '<option value="0">--</option>';
        foreach($this->getData() as $id => $oObj) {
            if(count($this->getArrIdExclude()) && in_array($id, $this->getArrIdExclude())) continue;
            $sSelected = '';
            if($this->getIdDefault() > 0 && $this->getIdDefault() === $id) $sSelected = ' selected="selected"';
            $sOption .= '<option value="' . $id . '" ' . $sSelected . '>' . $oObj->$sMethodVal() . '</option>';
        }
        return $sOption;
    }
}