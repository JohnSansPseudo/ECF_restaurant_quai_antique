<?php


final class ParamInt extends ParamCheck
{

    CONST VAR_TYPE = 'int';

    /**
     * @var int
     */
    private $iMax;
    /**
     * @var int
     */
    private $iMin;

    /**
     * @return int | null
     */
    public function getMax() { return $this->iMax; }

    /**
     * @param int $iMax
     * @return ParamInt
     */
    private function setMax($iMax): ParamInt
    {
        if(parent::checkIsTypeOf('int', $iMax, '$iMax')) $this->iMax = $iMax;
        return $this;
    }

    /**
     * @return int |null
     */
    public function getMin() { return $this->iMin; }

    /**
     * @param int |null $iMin
     * @return ParamInt
     */
    private function setMin($iMin, $iMax): ParamInt
    {
        if(is_int($iMax) && is_int($iMin) && $iMin >= $iMax)
        {
            $this->aErr[] = 'Error ' . get_class($this) . ', $iMin >= $iMax : ' . $iMin . ' >= ' . $iMax;
        }

        if(parent::checkIsTypeOf('int', $iMin, '$iMin')) $this->iMin = $iMin;
        return $this;
    }


    /**
     * @param $mVal mixed
     * @param $sVarName string
     * @param $iMin int | null
     * @param $iMax int | null
     */
    public function __construct($mVal, $sVarName, $iMin=null, $iMax=null)
    {
        parent::__construct($mVal, $sVarName);

        if(count($this->getArrErr()) < 1)
        {
            if($iMin !== null) $this->setMin($iMin, $iMax)->checkMin();
            if($iMax !== null) $this->setMax($iMax)->checkMax();
        }
    }

    /**
     * @return ParamInt
     */
    public function checkMax(): ParamInt
    {
        if($this->getMax() && $this->getValue() > $this->getMax())
        {
            $this->aErr[] = 'Error ' . get_class($this) . ' : ' . $this->getVarName() . ' is > at $iMax, your value ' . $this->getValue() . ' must be <= at' . $this->getMax();
        }
        return $this;
    }

    /**
     * @return ParamInt
     */
    public function checkMin(): ParamInt
    {
        if($this->getMin() && $this->getValue() < $this->getMin()){
            $this->aErr[] = 'Error ' . get_class($this) . ' : ' . $this->getVarName() . ' is < at $iMin, you value ' . $this->getValue() . ' must be >= at ' . $this->getMin();
        }
        return $this;
    }

    /**
     * @return ParamInt
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