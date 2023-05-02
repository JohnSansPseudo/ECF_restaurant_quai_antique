<?php


final class ParamFloat extends ParamCheck
{
    CONST VAR_TYPE = 'float';

    /**
     * @var int | double | null
     */
    private $fMax;
    /**
     * @var int | double | null
     */
    private $fMin;

    /**
     * @return int | double | null
     */
    public function getMax() { return $this->fMax; }

    /**
     * @param int | double | null $fMax
     * @return ParamFloat
     */
    private function setMax($fMax): ParamFloat
    {
        if(parent::checkIsTypeOf('numeric', $fMax, '$fMax')) $this->fMax = $fMax;
        return $this;
    }

    /**
     * @return int | double | null
     */
    public function getMin() { return $this->fMin; }

    /**
     * @param int | double | null $fMin
     * @param int | double | null $fMax
     * @return ParamFloat
     */
    private function setMin($fMin, $fMax): ParamFloat
    {
        if(is_float($fMax) && is_float($fMin) && $fMin >= $fMax)
        {
            $this->aErr[] = 'Error ' . get_class($this) . ', $fMin >= $fMax : ' . $fMin . ' >= ' . $fMax;
        }

        if(parent::checkIsTypeOf('numeric', $fMin, '$fMin')) $this->fMin = $fMin;
        return $this;
    }

    /**
     * @param $mVal mixed
     * @param $sVarName string
     * @param $fMin int | double | null
     * @param $fMax int | double | null
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