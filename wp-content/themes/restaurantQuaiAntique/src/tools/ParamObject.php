<?php


final class ParamObject extends ParamCheck
{
    CONST VAR_TYPE = 'object';

    /**
     * @var string
     */
    private $sClassObject;

    /**
     * @var boolean
     */
    private $bClassObject;

    /**
     * @return bool
     */
    public function getBoolIsClassObject(): bool
    {
        return $this->bClassObject;
    }

    /**
     * @param bool $bClassObject
     * @return ParamObject
     */
    public function setBoolIsClassObject(bool $bClassObject): ParamObject
    {
        $this->bClassObject = $bClassObject;
        return $this;
    }

    /**
     * @return string
     */
    public function getStrClassObject() { return $this->sClassObject; }

    /**
     * @param string $sClassObject
     * @return ParamObject
     */
    public function setStrClassObject($sClassObject): ParamObject
    {
        if(parent::checkIsTypeOf('string', $sClassObject, '$sClassObject')) $this->sClassObject = $sClassObject;
        return $this;
    }

    /**
     * @param $mVal mixed
     * @param $sVarName string
     */
    public function __construct($mVal, $sVarName, $sClassObject=null)
    {
        parent::__construct($mVal, $sVarName);
        if(count($this->getArrErr()) < 1)
        {
            if($sClassObject !== null)
            {
                $this->setStrClassObject($sClassObject)->checkClassObject();
            }
        }
    }

    /**
     * @return ParamObject
     */
    private function checkClassObject()
    {
        if($this->getStrClassObject() && ($this->getStrClassObject() !== get_class($this->getValue())) )
        {
            $this->aErr[] = 'Error ' . get_class($this) . ' : class of ' . $this->getVarName() . ' is : ' . get_class($this->getValue()) . ', ' . $this->getStrClassObject() . ' expected';
            $this->setBoolIsClassObject(false);
        }
        else $this->setBoolIsClassObject(true);
        return $this;
    }

    /**
     * @return ParamObject
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