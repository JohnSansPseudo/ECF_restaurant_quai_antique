<?php


abstract class ParamCheck
{
    //PROPERTIES ****************
    /**
     * @var mixed $mValue
     */
    private $mValue;

    /**
     * @var array $aErr
     */
    protected $aErr = [];

    /**
     * @var string $sVarName
     */
    private $sVarName;

    /**
     * @var bool
     */
    private $bIsNull = false;

    /**
     * @var bool
     */
    private $bIsTypeOf = false;



    //GETTERS && SETTERS

    /**
     * @return bool
     */
    public function getBoolIsNull(): bool
    {
        return $this->bIsNull;
    }

    /**
     * @param bool $bIsNull
     * @return ParamCheck
     */
    private function setBoolIsNull(bool $bIsNull): ParamCheck
    {
        $this->bIsNull = $bIsNull;
        return $this;
    }

    /**
     * @return bool
     */
    public function getBoolIsTypeOf(): bool
    {
        return $this->bIsTypeOf;
    }

    /**
     * @param bool $bIsTypeOf
     * @return ParamCheck
     */
    protected function setBoolIsTypeOf(bool $bIsTypeOf): ParamCheck
    {
        $this->bIsTypeOf = $bIsTypeOf;
        return $this;
    }

    /**
     * @return string
     */
    public function getVarName()
    {
        return $this->sVarName;
    }

    /**
     * @param string $sVarName
     * @return ParamCheck
     */
    private function setVarName($sVarName): ParamCheck
    {
        if(!is_string($sVarName))
        {
            $this->aErr[] = 'Error ' . get_class($this) . ', $sVarName : ' . $sVarName . ' is not type of string, type of $sVarName : ' . gettype($sVarName);
        }
        else $this->sVarName = $sVarName;
        return $this;
    }


    /**
     * @return array
     */
    public function getArrErr(): array
    {
        return $this->aErr;
    }

    /**
     * @return mixed
     */
    public function getValue()
    {
        return $this->mValue;
    }

    /**
     * @param mixed $mValue
     */
    private function setValue($mValue): ParamCheck
    {
        $this->mValue = $mValue;
        return $this;
    }

    public function __construct($mVal, $sVarName)
    {
        $this->setVarName($sVarName)
            ->setValue($mVal)
            ->isNull();
        if(!$this->getBoolIsNull()) $this->isTypeOf();
    }

    /**
     * @return string
     */
    public function getStringError():string
    {
        return implode('<br/>', $this->aErr);
    }

    /**
     * @return self
     */
    protected abstract function isTypeOf();

    /**
     * @return ParamCheck
     */
    protected function isNull(): ParamCheck
    {
        if($this->getValue() === null)
        {
            $this->aErr[] = 'Error ' . get_class($this) . ' : ' . $this->getVarName() . ' is null';
            $this->setBoolIsNull(true);
        }
        else $this->setBoolIsNull(false);
        return $this;
    }


    /**
     * @param $sType string
     * @param $mValue mixed
     * @param $sVarName string
     * @return bool
     */
    protected function checkIsTypeOf($sType, $mValue, $sVarName)
    {
        $sMethod = '';
        switch($sType)
        {
            case 'int': $sMethod = 'is_int'; break;
            case 'string': $sMethod = 'is_string'; break;
            case 'array': $sMethod = 'is_array'; break;
            case 'object': $sMethod = 'is_object'; break;
            case 'boolean': $sMethod = 'is_bool'; break;
            case 'float': $sMethod = 'is_float'; break;
            case 'numeric': $sMethod = 'is_numeric'; break;
        }

        if(!$sMethod($mValue))
        {
            $this->aErr[] = 'Error, ' . get_class($this) . ' : ' . $sVarName . ' is not type of ' . $sType . ', type of ' . $sVarName . ' : ' . gettype($mValue) . ' , value : ' . $mValue;
            return false;
        }
        else return true;
    }

}