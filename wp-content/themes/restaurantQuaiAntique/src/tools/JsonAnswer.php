<?php



class JsonAnswer
{
    private int $_code = 0;
    private string $_mess = '';
    private $_comp = '';


    /**
     * @return int
     */
    public function getCode()
    {
        return $this->_code;
    }


    /**
     * @param int $iCode
     * @return JsonAnswer
     */
    public function setCode($iCode)
    {
        $iCode = intval($iCode);
        $this->_code = $iCode;
        return $this;
    }

    /**
     * @return string
     */
    public function getMess()
    {
        return $this->_mess;
    }


    /**
     * @param string $sMess
     * @return JsonAnswer
     */
    public function setMess($sMess)
    {
        $this->_mess = utf8_encode($sMess);
        return $this;
    }

    /**
     * @return string
     */
    public function getComp()
    {
        return $this->_comp;
    }


    /**
     * @param mixed $mComp
     * @return JsonAnswer
     */
    public function setComp($mComp)
    {
        $this->_comp = $mComp;
        return $this;
    }

    static public function retour($iCode, $sMess, $mComp)
    {
        $oClass = new JsonAnswer();
        return $oClass->setCode($iCode)->setMess($sMess)->setComp($mComp);
    }

    public function toArray()
    {
        return array('code' => $this->getCode(), 'mess' => $this->getMess(), 'comp' => $this->getComp());
    }

}