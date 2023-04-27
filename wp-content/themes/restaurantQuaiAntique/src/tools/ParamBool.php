<?php


final class ParamBool extends ParamCheck
{
    CONST VAR_TYPE = 'boolean';

    /**
     * @param $mVal mixed
     * @param $sVarName string
     */
    public function __construct($mVal, $sVarName)
    {
        parent::__construct($mVal, $sVarName);
    }

    /**
     * @return ParamBool
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