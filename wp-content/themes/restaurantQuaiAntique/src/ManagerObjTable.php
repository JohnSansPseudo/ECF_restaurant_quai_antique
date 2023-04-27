<?php


abstract class ManagerObjTable
{

    abstract function createTable(): bool;
    abstract function add(object $oData);
    abstract function getAllData();
    //abstract function getByWhere($aParam);



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
        $sData = '';
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




}