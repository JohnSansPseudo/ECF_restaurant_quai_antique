<?php


final class Bookings extends ManagerObjTable
{
    CONST CLASS_MANAGER = 'Booking';

    static public function getNbGuestsMax()
    {
        return intval(get_option('guest_max'));
    }

    static public function getTableName():string
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
     * @param $oBooking Booking
     * @return bool | array | Booking
     */
    public function add($oBooking)
    {
        //Vérification du nombre de place restante
        $iNbGuestBooked = $this->getNbGuestsBySqlDateAndIdOpening($oBooking->getBookingDate(), $oBooking->getIdOpening());
        $iPlaceAvailable = self::getNbGuestsMax() - $iNbGuestBooked;
        $aData = OpeningTimes::getInstance()->getByWhere(array('id' => $oBooking->getIdOpening()));
        if(is_array($aData) && count($aData) === 1) {
            /**
             * @var $o OpeningTime
             */
            $o = array_pop($aData);
        }
        if($oBooking->getNbGuest() > $iPlaceAvailable){
            $sMess = 'Il ne reste que ' . $iPlaceAvailable . ' place(s) à cette date pour ce créneaux';
            if($o) $sMess = 'Il ne reste que ' . $iPlaceAvailable . ' place(s) à cette date pour le ' . $o->getTimeDay();
            throw new Exception($sMess);
        }

        //Vérification que le client ne fasse qu'une réservation par moment de journée (par son mail et ou tél)
        $aBooked = $this->getByWhere(array('email' => $oBooking->getEmail(), 'bookingDate' => $oBooking->getBookingDate(), 'idOpening' => $oBooking->getIdOpening()));
        if(is_array($aBooked) && count($aBooked) > 0){
            /**
             * @var $oBooked Booking
             */
            $oBooked = array_pop($aBooked);
            $sMess = 'Vous avez déjà une réservation le ' . date('d/m/Y', strtotime($oBooked->getBookingDate())) . ' à ' . $oBooked->getStartTime();
            throw new Exception($sMess);
        }
        
        $oPDO = PDOSingleton::getInstance();
        $oStatement = $oPDO->prepare("insert INTO " . self::getTableName() . "(idOpening, firstName, lastName, tel, email, allergy, nbGuest, startTime, bookingDate)  
        VALUES(:idOpening, :firstName, :lastName, :tel, :email, :allergy, :nbGuest, :startTime, :bookingDate)");
        if(!$oStatement) return false;

        $oStatement->bindValue(':idOpening', $oBooking->getIdOpening(), PDO::PARAM_INT);
        $oStatement->bindValue(':firstName', $oBooking->getFirstName(), PDO::PARAM_STR);
        $oStatement->bindValue(':lastName', $oBooking->getLastName(), PDO::PARAM_STR);
        $oStatement->bindValue(':tel', $oBooking->getTel(), PDO::PARAM_STR);
        $oStatement->bindValue(':email', $oBooking->getEmail(), PDO::PARAM_STR);
        $oStatement->bindValue(':allergy', $oBooking->getAllergy(), PDO::PARAM_STR);
        $oStatement->bindValue(':nbGuest', $oBooking->getNbGuest(), PDO::PARAM_INT);
        $oStatement->bindValue(':startTime', $oBooking->getStartTime(), PDO::PARAM_STR);
        $oStatement->bindValue(':bookingDate', $oBooking->getBookingDate(), PDO::PARAM_STR);

        $bExec = $oStatement->execute();
        if(!$bExec) return $bExec;
        $oBooking->setId($oPDO->lastInsertId());
        return $oBooking;
    }

    public function getNbGuestsBySqlDateAndIdOpening($sSqlDate, $idOpening)
    {
        $idOpening = intval($idOpening);
        $sSqlDate = htmlspecialchars($sSqlDate);
        $oPDO = PDOSingleton::getInstance();
        $oStatement = $oPDO->prepare('SELECT SUM(nbGuest) FROM ' . self::getTableName() . ' WHERE idOpening=:idOpening AND bookingDate=:bookingDate GROUP BY(nbGuest)');
        //dbrDie($oStatement->queryString);
        $oStatement->bindValue(':idOpening', $idOpening, PDO::PARAM_INT);
        $oStatement->bindValue(':bookingDate', $sSqlDate, PDO::PARAM_STR);
        $bExec = $oStatement->execute();
        if(!$bExec) return $bExec;
        return $oStatement->fetch(PDO::FETCH_COLUMN);
    }

}