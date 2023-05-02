<?php


abstract class ManagerObjTable
{

    abstract function createTable(): bool;
    static abstract function getTableName(): string;
    const CLASS_MANAGER = self::CLASS;


    public function deleteById($id)
    {
        $oPDO = PDOSingleton::getInstance();
        $oStatement = $oPDO->prepare("DELETE FROM " . static::getTableName() . " WHERE id=:id");
        $oStatement->bindParam(':id', $id, PDO::PARAM_INT);
        return $oStatement->execute();
    }

    public function updateById($id, $aData)
    {
        $oPDO = PDOSingleton::getInstance();
        $aDataRem = array();
        foreach($aData as $key => $val) { $aDataRem[] = $key . '=:' . $key; }
        $sData = join(', ', $aDataRem);
        $oStatement = $oPDO->prepare("UPDATE " . static::getTableName() . " SET " . $sData . " WHERE id=:id");
        $oStatement->bindValue(':id', $id, PDO::PARAM_INT);
        foreach($aData as $k => $v)
        {
            $oStatement->bindValue(':' . $k, $v);
        }
        //dbrDie($oStatement->queryString);
        return $oStatement->execute();
    }


    public function add($oObj)
    {
        $oPDO = PDOSingleton::getInstance();
        $aData = $this->objectToArray($oObj, array('aErr'));
        $aDataRem = array();
        foreach($aData as $key => $val) { $aDataRem[] = ':' . $key; }
        $sKey = '(' . join(', ', array_keys($aData)) . ')';
        $sValues = join(', ', $aDataRem);
        $oStatement = $oPDO->prepare("insert INTO " . static::getTableName() . $sKey . " VALUES(" . $sValues . ")");
        if(!$oStatement) return false;
        foreach($aData as $k => $v)
        {
            $oStatement->bindValue(':' . $k, $v);
        }
        $bExec = $oStatement->execute();
        if(!$bExec) return $bExec;
        $oObj->setId($oPDO->lastInsertId());
        return $oObj;
    }


    /*
     * @param string $sOrderBy
     * @return array | bool
     */
    public function getAllData($sOrderBy='')
    {
        $oPDO = PDOSingleton::getInstance();
        $oStatement = $oPDO->prepare("SELECT * FROM " . static::getTableName() . " " .$sOrderBy);
        return $this->statementGetExecute($oStatement);
    }


    /**
     * @param array $aParam
     * @param string $sOrDerBy
     * @return array | bool
     */
    public function getByWhere($aParam, $sOrDerBy='')
    {
        $oPDO = PDOSingleton::getInstance();
        $aDataRem = array();
        foreach($aParam as $key => $val) { $aDataRem[] = $key . '=:' . $key; }
        $sData = join(' AND ', $aDataRem);
        $oStatement = $oPDO->prepare("SELECT * FROM " . static::getTableName() . " WHERE " . $sData . " " . $sOrDerBy);
        foreach($aParam as $k => $v)
        {
            $oStatement->bindValue(':' . $k, $v);
        }
        return $this->statementGetExecute($oStatement);
    }


    /**
     * @param $oState PDOStatement
     * @return array | bool
     */
    public function statementGetExecute($oState)
    {
        //dbrDie($oState->queryString);
        $aArgs = array('12345678', '1234567', '12345678', '12345678', '12345678', '12345678', '12345678', '12345678', '12345678', '12345678', '12345678', '12345678', '12345678', '12345678', '12345678');
        $bExec = $oState->execute();
        if(!$bExec) return $bExec;
        $aData = array();
        $oState->setFetchMode(PDO::FETCH_CLASS | PDO::FETCH_PROPS_LATE, static::CLASS_MANAGER,  $aArgs);
        while ($o = $oState->fetch()) { $aData[$o->getId()] = $o; }
        return $aData;
    }

    /**
     * @param $oObj
     * @param array $aExcludeProp
     * @return array
     */
    public function objectToArray($oObj, $aExcludeProp)
    {
        $aDataRem = array();
        $aData = (array)$oObj;
        foreach ($aData as $k => $v){
            $sKey = trim(str_replace(static::CLASS_MANAGER, '', $k));
            if(in_array($sKey, $aExcludeProp)) continue;
            $aDataRem[$sKey] = $v;
        }
        return $aDataRem;
    }

}