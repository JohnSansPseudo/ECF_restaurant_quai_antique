<?php


final class OpeningTimes extends ManagerObjTable
{

    CONST CLASS_MANAGER = 'OpeningTime';

    CONST MONDAY = 'lundi';
    CONST TUESDAY = 'mardi';
    CONST WEDNESDAY = 'mercredi';
    CONST THURSDAY = 'jeudi';
    CONST FRIDAY = 'vendredi';
    CONST SATURDAY = 'samedi';
    CONST SUNDAY = 'dimanche';
    CONST NOON = 'midi';
    CONST EVENING = 'soir';

    /*CONST MONDAY = 'monday';
    CONST TUESDAY = 'tuesday';
    CONST WEDNESDAY = 'wednesday';
    CONST THURSDAY = 'thursday';
    CONST FRIDAY = 'friday';
    CONST SATURDAY = 'saturday';
    CONST SUNDAY = 'sunday';
    CONST NOON = 'noon';
    CONST EVENING = 'evening';*/

    static public function getInstance() { return new OpeningTimes(); }


    static public function getTableName():string
    {
        global $wpdb;
        return $wpdb->prefix . 'opening_time';
    }

    function createTable():bool
    {
        $oPDO = PDOSingleton::getInstance();
        $sql = "CREATE TABLE IF NOT EXISTS " . self::getTableName() . "(
            id INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
            day ENUM('" . self::MONDAY. "', '" . self::TUESDAY. "', '" . self::WEDNESDAY. "', '" . self::THURSDAY. "', '" . self::FRIDAY. "', '" . self::SATURDAY. "', '" . self::SUNDAY. "') NOT NULL,
            timeDay ENUM('" . self::NOON. "', '" . self::EVENING . "') NOT NULL,
            startTimeDay TIME NULL,
            endTimeDay TIME  NULL,
            UNIQUE KEY(day, timeDay) )";

        $oStatement = $oPDO->prepare($sql);
        if(!$oStatement) return false;
        $b = $oStatement->execute();

        //On vérifie si la table est bien initalisée sinon on l'initialise
        $sql = "SELECT * FROM " . self::getTableName();
        $oStatement = $oPDO->prepare($sql);
        if(!$oStatement) return false;
        $b = $oStatement->execute();
        $aResult = $oStatement->fetchAll(PDO::FETCH_ASSOC);
        if(is_array($aResult) && count($aResult) == 0)
        {
            $this->initTable();
        }
        return $b;
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


    public function deleteById($id)
    {
        return false;
    }

    /**
     * @var $OpeningTime OpeningTime
     */
    public function add($oOpeningTime)
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

}