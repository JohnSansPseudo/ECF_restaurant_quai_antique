<?php


class OpeningTimes
{

    CONST MONDAY = 'monday';
    CONST TUESDAY = 'tuesday';
    CONST WEDNESDAY = 'wednesday';
    CONST THURSDAY = 'thursday';
    CONST FRIDAY = 'friday';
    CONST SATURDAY = 'saturday';
    CONST SUNDAY = 'sunday';
    CONST NOON = 'noon';
    CONST EVENING = 'evening';

    static public function getInstance() { return new FoodDishes(); }


    static public function getTableName()
    {
        global $wpdb;
        return $wpdb->prefix . 'opening_time';
    }

    function createTable():bool
    {
        $oPDO = PDOSingleton::getInstance();
        $sql = "CREATE TABLE IF NOT EXISTS " . self::getTableName(). "(
            id INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
            day ENUM('" . self::MONDAY. "', '" . self::TUESDAY. "', '" . self::WEDNESDAY. "', '" . self::THURSDAY. "', '" . self::FRIDAY. "', '" . self::SATURDAY. "', '" . self::SUNDAY. "') NOT NULL,
            timeDay ENUM('" . self::NOON. "', '" . self::EVENING . "') NOT NULL,
            startTimeDay TIME NOT NULL,
            endTimeDay TIME  NOT NULL,
            UNIQUE KEY(day, timeDay) )";


        $oStatement = $oPDO->prepare($sql);
        if(!$oStatement) return false;
        return $oStatement->execute();
    }

    public function initTable()
    {
        $aData = array();
        $aData[] = new OpeningTime(OpeningTimes::MONDAY, OpeningTimes::NOON);
        $aData[] = new OpeningTime(OpeningTimes::TUESDAY, OpeningTimes::NOON, '12:00:00', '15:00:00');
        $aData[] = new OpeningTime(OpeningTimes::WEDNESDAY, OpeningTimes::NOON, '12:00:00', '15:00:00');
        $aData[] = new OpeningTime(OpeningTimes::THURSDAY, OpeningTimes::NOON, '12:00:00', '15:00:00');
        $aData[] = new OpeningTime(OpeningTimes::FRIDAY, OpeningTimes::NOON, '12:00:00', '15:00:00');
        $aData[] = new OpeningTime(OpeningTimes::SATURDAY, OpeningTimes::NOON, '12:00:00', '15:00:00');
        $aData[] = new OpeningTime(OpeningTimes::SUNDAY, OpeningTimes::NOON);

        $aData[] = new OpeningTime(OpeningTimes::MONDAY, OpeningTimes::EVENING);
        $aData[] = new OpeningTime(OpeningTimes::TUESDAY, OpeningTimes::EVENING, '19:00:00', '22:00:00');
        $aData[] = new OpeningTime(OpeningTimes::WEDNESDAY, OpeningTimes::EVENING, '19:00:00', '22:00:00');
        $aData[] = new OpeningTime(OpeningTimes::THURSDAY, OpeningTimes::EVENING, '19:00:00', '22:00:00');
        $aData[] = new OpeningTime(OpeningTimes::FRIDAY, OpeningTimes::EVENING, '19:00:00', '22:00:00');
        $aData[] = new OpeningTime(OpeningTimes::SATURDAY, OpeningTimes::EVENING, '19:00:00', '22:00:00');
        $aData[] = new OpeningTime(OpeningTimes::SUNDAY, OpeningTimes::EVENING);

        foreach($aData as $o) $this->add($o);
    }

    /**
     * @var $OpeningTime OpeningTime
     */
    public function add(OpeningTime $oOpeningTime):object
    {

        $oPDO = PDOSingleton::getInstance();
        $oStatement = $oPDO->prepare("insert INTO " . self::getTableName() . "(day, timeDay, startTimeDay, endTimeDay)  VALUES(:day, :timeDay, :startTimeDay, :endTimeDay)");
        if(!$oStatement) return false;

        $oStatement->bindValue(':day', $oOpeningTime->getDay(), PDO::PARAM_STR);
        $oStatement->bindValue(':timeDay', $oOpeningTime->getTimeDay(), PDO::PARAM_STR);
        $oStatement->bindValue(':startTimeDay', $oOpeningTime->getStartTimeDay(), PDO::PARAM_STR);
        $oStatement->bindValue(':endTimeDay', $oOpeningTime->getEndTimeDay(), PDO::PARAM_STR);

        $bExec = $oStatement->execute();
        if(!$bExec) return $bExec;
        $oOpeningTime->setId($oPDO->lastInsertId());
        return $oOpeningTime;
    }

    public function getAllData()
    {
        $oPDO = PDOSingleton::getInstance();
        $oStatement = $oPDO->prepare("SELECT * FROM " . self::getTableName());
        $aData = array();
        if($oStatement->execute()){
            $oStatement->setFetchMode(PDO::FETCH_CLASS | PDO::FETCH_PROPS_LATE, 'OpeningTime', array('1', '2', '3', '4'));
            while ($o = $oStatement->fetch()) { $aData[$o->getId()] = $o; }
        }
        return $aData;
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