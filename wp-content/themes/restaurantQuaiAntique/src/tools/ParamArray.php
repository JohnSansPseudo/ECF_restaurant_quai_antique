<?php


final class ParamArray extends ParamCheck
{
    CONST VAR_TYPE = 'array';

    /**
     * @var int
     */
    private $iMaxLength;
    /**
     * @var int
     */
    private $iMinLength;

    /**
     * @return int | null
     */
    public function getIntMaxLength() { return $this->iMaxLength; }

    /**
     * @param int $iMaxLength
     * @return ParamArray
     */
    private function setIntMaxLength($iMaxLength): ParamArray
    {
        if(parent::checkIsTypeOf('int', $iMaxLength, '$iMaxLength')) $this->iMaxLength = $iMaxLength;
        return $this;
    }

    /**
     * @return int | null
     */
    public function getIntMinLength() { return $this->iMinLength; }

    /**
     * @param int $iMinLength
     * @return ParamArray
     */
    private function setIntMinLength($iMinLength, $iMaxLength): ParamArray
    {
        if(is_int($iMaxLength) && is_int($iMinLength) && $iMinLength >= $iMaxLength)
        {
            $this->aErr[] = 'Error ' . get_class($this) . ', $iMinLength >= $iMaxLength : ' . $iMinLength . ' >= ' . $iMaxLength;
        }

        if(parent::checkIsTypeOf('int', $iMinLength, '$iMinLength')) $this->iMinLength = $iMinLength;
        return $this;
    }

    /**
     * @param $mVal mixed
     * @param $sVarName string
     */
    public function __construct($mVal, $sVarName, $iMinLength=null, $iMaxLength=null)
    {
        parent::__construct($mVal, $sVarName);
        if(count($this->getArrErr()) < 1)
        {
            if($iMinLength !== null) $this->setIntMinLength($iMinLength, $iMaxLength)->checkMinLength();
            if($iMaxLength !== null) $this->setIntMaxLength($iMaxLength)->checkMaxLength();
        }
    }

    /**
     * @return ParamArray
     */
    private function checkMinLength(): ParamArray
    {
        if($this->getIntMinLength() && count($this->getValue()) < $this->getIntMinLength())
        {
            $this->aErr[] = 'Error ' . get_class($this) . ' : count(' . $this->getVarName() . ') < $iMinlength  => ' . count($this->getValue()) . ' < ' . $this->getIntMinLength();
        }
        return $this;
    }

    /**
     * @return ParamArray
     */
    private function checkMaxLength(): ParamArray
    {
        if($this->getIntMaxLength() && count($this->getValue()) > $this->getIntMaxLength())
        {
            $this->aErr[] = 'Error ' . get_class($this) . ' : count(' . $this->getVarName() . ') > $iMaxlength  => ' . count($this->getValue()) . ' > ' . $this->getIntMaxLength();
        }
        return $this;
    }

    /**
     * @return ParamArray
     */
    protected function isTypeOf()
    {
        if(!parent::checkIsTypeOf(self::VAR_TYPE, $this->getValue(), $this->getVarName()))
        {
            $this->setBoolIsTypeOf(false);
        }
        else $this->setBoolIsTypeOf(true);
        return $this;
    }

}