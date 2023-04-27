<?php


final class Bookings extends ManagerObjTable
{
    static public function getTableName()
    {
        global $wpdb;
        return $wpdb->prefix . 'booking';
    }

    static public function getInstance() { return new Bookings(); }

    /**
     * @return bool
     */
    public function createTable():bool
    {
        $oPDO = PDOSingleton::getInstance();
        $sql = "CREATE TABLE IF NOT EXISTS " . self::getTableName() . " (
                    id INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
                    idOpening INT NOT NULL,
                    firstName VARCHAR(50) NOT NULL,
                    lastName VARCHAR(50) NOT NULL,
                    tel VARCHAR(10) NOT NULL,
                    email VARCHAR(50) NOT NULL,
                    allergy TEXT(500),
                    nbGuest TINYINT NOT NULL,
                    startTime TIME NOT NULL,
                    bookingDate DATE NOT NULL,
                    FOREIGN KEY (idOpening) REFERENCES " . OpeningTimes::getTableName() . " (id))";

        $oStatement = $oPDO->prepare($sql);
        if(!$oStatement) return false;
        return $oStatement->execute();
    }

    /**
     * @var Booking $oBooking
     */
    public function add(object $oBooking):object
    {

        $oPDO = PDOSingleton::getInstance();
        $oStatement = $oPDO->prepare("insert INTO " . self::getTableName() . "(idOpening, firstName, lastName, tel, allergy, nbGuest, startTime, bookingDate)  
        VALUES(:idOpening, :firstName, :lastName, :tel, :allergy, :nbGuest, :startTime, :bookingDate)");
        if(!$oStatement) return false;

        $oStatement->bindValue(':idOpening', $oBooking->getIdOpening(), PDO::PARAM_INT);
        $oStatement->bindValue(':firstName', $oBooking->getFirstName(), PDO::PARAM_STR);
        $oStatement->bindValue(':lastName', $oBooking->getLastName(), PDO::PARAM_STR);
        $oStatement->bindValue(':tel', $oBooking->getTel(), PDO::PARAM_STR);
        $oStatement->bindValue(':allergy', $oBooking->getAllergy());
        $oStatement->bindValue(':nbGuest', $oBooking->getNbGuest(), PDO::PARAM_INT);
        $oStatement->bindValue(':startTime', $oBooking->getStartTime(), PDO::PARAM_STR);
        $oStatement->bindValue(':bookingDate', $oBooking->getBookingDate(), PDO::PARAM_STR);


        //Debug PDO
        /*ob_start();
        $oStatement->debugDumpParams();
        $r = ob_get_contents();
        ob_end_clean();
        dbrDie($r);*/

        $bExec = $oStatement->execute();
        if(!$bExec) return $bExec;
        $oBooking->setId($oPDO->lastInsertId());
        return $oBooking;

    }

    public function getAllData()
    {
        $oPDO = PDOSingleton::getInstance();
        $oStatement = $oPDO->prepare("SELECT * FROM " . self::getTableName());
        $aData = array();
        if($oStatement->execute()){
            $oStatement->setFetchMode(PDO::FETCH_CLASS | PDO::FETCH_PROPS_LATE, 'Booking', array('1', '2', '3', '4', '5', '6', '7', '8', '9', '10'));
            while ($o = $oStatement->fetch()) { $aData[$o->getId()] = $o; }
        }
        return $aData;
    }

}