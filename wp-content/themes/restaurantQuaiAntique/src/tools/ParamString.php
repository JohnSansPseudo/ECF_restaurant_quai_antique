<?php


final class ParamString extends ParamCheck
{
    CONST VAR_TYPE = 'string';

    /**
     * @var int
     */
    private $iMaxLength;
    /**
     * @var int
     */
    private $iMinLength;

    /**
     * @return int
     */
    public function getIntMaxLength()
    {
        return $this->iMaxLength;
    }

    /**
     * @param int $iMaxLength
     * @return ParamString
     */
    private function setIntMaxLength($iMaxLength): ParamString
    {
        if(!is_int($iMaxLength))
        {
            $this->aErr[] = 'Error ' . get_class($this) . ', var $iMaxLength : ' . $iMaxLength . ' is not type of int';
        }
        else $this->iMaxLength = $iMaxLength;
        return $this;
    }

    /**
     * @return int
     */
    public function getIntMinLength()
    {
        return $this->iMinLength;
    }

    /**
     * @param int $iMinLength
     * @param int $iMaxLength
     * @return ParamString
     */
    private function setIntMinLength($iMinLength, $iMaxLength): ParamString
    {
        if(is_int($iMaxLength) && is_int($iMinLength) && $iMinLength > $iMaxLength)
        {
            $this->aErr[] = 'Error ' . get_class($this) . ', $iMinLength >= $iMaxLength : ' . $iMinLength . ' > ' . $iMaxLength;
        }

        if(!is_int($iMinLength))
        {
            $this->aErr[] = 'Error ' . get_class($this) . ', $iMinLength : ' . $iMinLength . ' is not type of int';
        }
        else $this->iMinLength = $iMinLength;
        return $this;
    }

    /**
     * @param $mVal mixed
     * @param $sVarName string
     * @param $iMinLength int | null
     * @param $iMaxLength int | null
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
     * @return ParamString
     */
    private function checkMinLength(): ParamString
    {
        if($this->getIntMinLength() && strlen($this->getValue()) < $this->getIntMinLength())
        {
            $this->aErr[] = 'Error ' . $this->getVarName() . ' => "' . $this->getValue() . '" (' . strlen($this->getValue()). ' char) must be  >= at ' . $this->getIntMinLength() . ' characters';
        }
        return $this;
    }

    /**
     * @return ParamString
     */
    private function checkMaxLength(): ParamString
    {
        if($this->getIntMaxLength() && strlen($this->getValue()) > $this->getIntMaxLength())
        {
            $this->aErr[] = 'Error ' . $this->getVarName() . ' => "' . $this->getValue() . '" (' . strlen($this->getValue()). ' char) must be  <= at ' . $this->getIntMaxLength() . ' characters';
        }
        return $this;
    }

    /**
     * @return ParamString
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