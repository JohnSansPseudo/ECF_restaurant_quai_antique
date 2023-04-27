<?php


final class ParamFloat extends ParamCheck
{
    CONST VAR_TYPE = 'float';

    /**
     * @var float
     */
    private $fMax;
    /**
     * @var float
     */
    private $fMin;

    /**
     * @return float | null
     */
    public function getMax() { return $this->fMax; }

    /**
     * @param float $fMax
     * @return ParamFloat
     */
    private function setMax($fMax): ParamFloat
    {
        if(parent::checkIsTypeOf('int', $fMax, '$fMax')) $this->fMax = $fMax;
        return $this;
    }

    /**
     * @return float |null
     */
    public function getMin() { return $this->fMin; }

    /**
     * @param float |null $fMin
     * @return ParamFloat
     */
    private function setMin($fMin, $fMax): ParamFloat
    {
        if(is_float($fMax) && is_float($fMin) && $fMin >= $fMax)
        {
            $this->aErr[] = 'Error ' . get_class($this) . ', $fMin >= $fMax : ' . $fMin . ' >= ' . $fMax;
        }

        if(parent::checkIsTypeOf('float', $fMin, '$iMin')) $this->fMin = $fMin;
        return $this;
    }

    /**
     * @param $mVal mixed
     * @param $sVarName string
     * @param $iMin int | null
     * @param $iMax int | null
     */
    public function __construct($mVal, $sVarName, $fMin=null, $fMax=null)
    {
        parent::__construct($mVal, $sVarName);

        if(count($this->getArrErr()) < 1)
        {
            if($fMin !== null) $this->setMin($fMin, $fMax)->checkMin();
            if($fMax !== null) $this->setMax($fMax)->checkMax();
        }
    }

    /**
     * @return ParamFloat
     */
    public function checkMax(): ParamFloat
    {
        if($this->getMax() && $this->getValue() > $this->getMax())
        {
            $this->aErr[] = 'Error ' . get_class($this) . ' : ' . $this->getVarName() . ' > $fMax, ' . $this->getValue() . ' > ' . $this->getMax();
        }
        return $this;
    }

    /**
     * @return ParamFloat
     */
    public function checkMin(): ParamFloat
    {
        if($this->getMin() && $this->getValue() < $this->getMin()){
            $this->aErr[] = 'Error ' . get_class($this) . ' : ' . $this->getVarName() . ' < $fMin, ' . $this->getValue() . ' < ' . $this->getMin();
        }
        return $this;
    }

    /**
     * @return ParamFloat
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