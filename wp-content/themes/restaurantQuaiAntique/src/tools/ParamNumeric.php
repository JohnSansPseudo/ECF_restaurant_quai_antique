<?php


class ParamNumeric extends ParamCheck
{
    const VAR_TYPE = 'numeric';

    /**
     * @var int | double
     */
    private $nMax;
    /**
     * @var float
     */
    private $nMin;

    /**
     * @return int | double
     */
    public function getMax()
    {
        return $this->nMax;
    }

    /**
     * @param int | double  $nMax
     * @return ParamNumeric
     */
    private function setMax($nMax): ParamNumeric
    {
        if (parent::checkIsTypeOf(self::VAR_TYPE , $nMax, '$nMax')) $this->nMax = $nMax;
        return $this;
    }

    /**
     * @return int | double
     */
    public function getMin()
    {
        return $this->nMin;
    }

    /**
     * @param int | double $nMin
     * @param int | double $nMax
     * @return ParamNumeric
     */
    private function setMin($nMin, $nMax): ParamNumeric
    {
        if (is_float($nMax) && is_float($nMin) && $nMin >= $nMax) {
            $this->aErr[] = 'Error ' . get_class($this) . ', $nMin >= $nMax : ' . $nMin . ' >= ' . $nMax;
        }

        if (parent::checkIsTypeOf(self::VAR_TYPE , $nMin, '$nMin')) $this->nMin = $nMin;
        return $this;
    }

    /**
     * @param $mVal mixed
     * @param $sVarName string
     * @param $nMin int | double | null
     * @param $nMax int | double | null
     */
    public function __construct($mVal, $sVarName, $nMin = null, $nMax = null)
    {
        parent::__construct($mVal, $sVarName);

        if (count($this->getArrErr()) < 1) {
            if ($nMin !== null) $this->setMin($nMin, $nMax)->checkMin();
            if ($nMax !== null) $this->setMax($nMax)->checkMax();
        }
    }

    /**
     * @return ParamNumeric
     */
    public function checkMax(): ParamNumeric
    {
        if ($this->getMax() && $this->getValue() > $this->getMax()) {
            $this->aErr[] = 'Error ' . get_class($this) . ' : ' . $this->getVarName() . ' > $nMax, ' . $this->getValue() . ' > ' . $this->getMax();
        }
        return $this;
    }

    /**
     * @return ParamNumeric
     */
    public function checkMin(): ParamNumeric
    {
        if ($this->getMin() && $this->getValue() < $this->getMin()) {
            $this->aErr[] = 'Error ' . get_class($this) . ' : ' . $this->getVarName() . ' < $nMin, ' . $this->getValue() . ' < ' . $this->getMin();
        }
        return $this;
    }

    /**
     * @return ParamNumeric
     */
    protected function isTypeOf()
    {
        if (!parent::checkIsTypeOf(self::VAR_TYPE, $this->getValue(), $this->getVarName())) {
            $this->setBoolIsTypeOf(false);
        } else $this->setBoolIsTypeOf(true);
        return $this;
    }
}