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
    CONST MIN_BEFORE_STOP_BOOK = 60;
    CONST BOOK_EVERY = 15;

    static public function getInstance() { return new OpeningTimes(); }

    /**
     * @param $sLongDayEn string
     * @return bool|string
     */
    static public function getLongDayEnToFr($sLongDayEn)
    {
        $sValue = '';
        $sLongDayEn = strtoupper($sLongDayEn);
        switch($sLongDayEn)
        {
            case 'MONDAY': $sValue = OpeningTimes::MONDAY; break;
            case 'TUESDAY': $sValue = OpeningTimes::TUESDAY;break;
            case 'WEDNESDAY': $sValue = OpeningTimes::WEDNESDAY;break;
            case 'THURSDAY': $sValue = OpeningTimes::THURSDAY;break;
            case 'FRIDAY': $sValue = OpeningTimes::FRIDAY;break;
            case 'SATURDAY': $sValue = OpeningTimes::SATURDAY;break;
            case 'SUNDAY': $sValue = OpeningTimes::SUNDAY;break;
            default: $sValue = false;
        }
        return $sValue;
    }


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
        if(!$b) {
            throw new Exception('Error creating table ' . self::getTableName());
        }

        //On vérifie si la table est bien initalisée sinon on l'initialise

        $sql = "SELECT * FROM " . self::getTableName();
        $oStatement = $oPDO->prepare($sql);
        if(!$oStatement) return false;
        $b = $oStatement->execute();
        if(!$b) {
            throw new Exception('Error get table from creating table ' . self::getTableName());
        }else{
            $aResult = $oStatement->fetchAll(PDO::FETCH_ASSOC);
            if(is_array($aResult) && count($aResult) == 0) $this->initTable();
            return $b;
        }

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
     * @param int $id
     * @return bool
     */
    public function deleteById($id)
    {
        return false;
    }

    /**
     * @var $OpeningTime OpeningTime
     * @return OpeningTime | bool
     */
    public function add($oOpeningTime)
    {
        $aData = $this->getAllData();
        if(is_array($aData) && count($aData) === 14) return false;

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


    /**
     * @param $sSqlDate string | null
     * @return array|bool
     * @throws
     */
    public function getHtmlHourBooking($sSqlDate=null)
    {
        date_default_timezone_set("Europe/Paris");
        //Savoir quel jour de la semaine (en lettre) au format français est sélectionné, par défaut aujourd'hui
        $sEnDay = strtoupper(date('l', time()));
        if($sSqlDate){
            $oDate = new DateTime($sSqlDate);
            $sEnDay = strtoupper($oDate->format('l'));
        }else{
            $sSqlDate = date('Y-m-d', time());
        }
        $sDayFr = self::getLongDayEnToFr($sEnDay);
        if($sDayFr === false) return false;

        //Récupérer le opening time
        $aData = self::getInstance()->getByWhere(array('day' => $sDayFr));
        if(!$aData) return $aData;

        //BOUCLER SUR CHAQUE OPENING TIME
        /**
         * @var OpeningTime $oOpening
         */
        $aStrHtml = array();
        $iNbGuestMax = Bookings::getNbGuestsMax();//Capacité maximum du restaurant
        $bSelected = false;
        $k = 0;
        /**
         * @var $oOpening OpeningTime
         */
        foreach ($aData as $oOpening)
        {
            $aStrHtml[$oOpening->getTimeDay()] = '';

            //Récupérer le nombre de convive (réservation) sur cette date pour ce moment de la journée
            $iBookedGuest = Bookings::getInstance()->getNbGuestsBySqlDateAndIdOpening($sSqlDate, $oOpening->getId());
            $iPlace = $iNbGuestMax;
            if($iBookedGuest !== false){
                $iBookedGuest = intval($iBookedGuest);
                $iPlace = $iNbGuestMax - $iBookedGuest;
                if($iPlace < 1){
                    $aStrHtml[$oOpening->getTimeDay()] = '<p class="info">Le restaurant est complet sur ces horaires</p>';
                    continue;
                }
            }

            //Si la valeur est à null c'est que le restaurant est fermé sur ce crénaux
            if($oOpening->getStartTimeDay() !== null && $oOpening->getEndTimeDay() !== null)
            {
                //On convertit l'heure de départ en time stamp
                $iStartTimeDay = strtotime($sSqlDate . ' ' . $oOpening->getStartTimeDay());
                $iEndTimeDay = strtotime($sSqlDate . ' ' .  $oOpening->getEndTimeDay());

                //On enlève le temps nécessaire avant la fermeture
                $iEndTimeDay = $iEndTimeDay - (60 * self::MIN_BEFORE_STOP_BOOK);

                //Boucler avec un step de 15 minutes
                for($i = $iStartTimeDay; $i <= $iEndTimeDay; $i += (60 * self::BOOK_EVERY))
                {
                    if(strtotime(date('Y-m-d H:i:s', time())) > $i) $bDisabled = true;
                    else $bDisabled = false;

                    if($bDisabled === false && $k == 0){
                        $bSelected = true;
                        $k++;
                    }
                    else $bSelected = false;
                    //Créer un input radio à chaque tour de boucle
                    $aStrHtml[$oOpening->getTimeDay()] .= $this->getHtmlHourBookingItem($i, $oOpening->getId(), $bDisabled, $bSelected);
                }
                if(strtotime(date('Y-m-d H:i:s', time())) < $iEndTimeDay){
                    $aStrHtml[$oOpening->getTimeDay()] .= '<p class="info">Il ne reste plus que ' . $iPlace . ' places sur les horaires du ' . $oOpening->getTimeDay() . '</p>';
                }
            }
            else $aStrHtml[$oOpening->getTimeDay()] = '<p class="info">Le restaurant est fermé sur ces horaires.</p>';
        }
        return $aStrHtml;
    }

    private function getHtmlHourBookingItem($iTimestamp, $idOpening, $bDisabled, $bSelected=false)
    {
        $sChecked = '';
        $sSelected = '';
        if($bSelected === true){
            $sChecked = ' checked=checked';
            $sSelected = ' selected';
        }
        $sClassDisabled =  '';
        $sAttrDisabled = '';
        if($bDisabled === true){
            $sClassDisabled = 'disabled';
            $sAttrDisabled = ' disabled=disabled';
        }
        return '<div class="ctnBookingHourItem mHover">
                    <div class="btnHour ' . $sSelected . ' ' . $sClassDisabled . '">' . date('H:i', $iTimestamp) . '</div>
                    <input
                        class="inpBookingHour hide"
                        type="radio"
                        name="startAppointement"
                        ' . $sChecked . $sAttrDisabled . '
                        value="' . date('H:i', $iTimestamp) . '">
                </div>';
    }

    /**
     * @param $oOpening OpeningTime
     * @return array
     */
    public function checkBookingBeforeUpdate($oOpening)
    {
        //Vérifier si il y a une réservation à venir en dehors de ces nouvelles horaires
        $aErr = array();
        date_default_timezone_set("Europe/Paris");
        $aBooking = Bookings::getInstance()->getByWhere(array('idOpening' => $oOpening->getId()));
        if(is_array($aBooking) && count($aBooking) > 0){

            if($oOpening->getStartTimeDay() === null && $oOpening->getEndTimeDay() === null){
                /**
                 * @var $oBooking Booking
                 */
                foreach($aBooking as $oBooking) {
                    $sMess = 'Il y a une réservation en date du ' . date('d/m/Y', strtotime($oBooking->getBookingDate())) .  ' à ' . $oBooking->getStartTime() . ' par ' . $oBooking->getFirstName() . ' ' . $oBooking->getLastName();
                    $aErr[] = utf8_decode($sMess);
                }
            } else {
                /**
                 * @var $oBooking Booking
                 */
                foreach($aBooking as $oBooking) {
                    //On convertit l'heure de départ en timestamp
                    $iStartOpening = strtotime($oBooking->getBookingDate() . ' ' . $oOpening->getStartTimeDay());
                    $iEndOpening = strtotime($oBooking->getBookingDate() . ' ' .  $oOpening->getEndTimeDay());
                    $iEndOpening = $iEndOpening - (OpeningTimes::MIN_BEFORE_STOP_BOOK * 60);
                    $iStartBooking = strtotime($oBooking->getBookingDate() . ' ' . $oBooking->getStartTime());

                    if($iStartBooking >= $iEndOpening){
                        $sMess = 'L\'heure de fin moins délais de fermeture est supérieure ou égale à la réservation du ' . date('d/m/Y', strtotime($oBooking->getBookingDate())) . ' à ' . $oBooking->getStartTime() . ' par ' . $oBooking->getFirstName() . ' ' . $oBooking->getLastName();
                        $aErr[] = utf8_decode($sMess);
                    }
                    if($iStartBooking < $iStartOpening){
                        $sMess = 'L\'heure de début est inférieure à la réservation du ' . date('d/m/Y', strtotime($oBooking->getBookingDate())) . ' à ' . $oBooking->getStartTime() . ' par ' . $oBooking->getFirstName() . ' ' . $oBooking->getLastName();
                        $aErr[] = utf8_decode($sMess);
                    }
                }
            }
        }
        return $aErr;
    }

    /**
     * @param $oState PDOStatement
     * @return array | bool
     */
    protected function statementGetExecute(PDOStatement $oState)
    {
        //dbrDie($oState->queryString);
        $aArgs = array('lundi', 'midi', '12:00:00', '15:00:00', '1');
        $bExec = $oState->execute();
        if(!$bExec) return $bExec;
        $aData = array();
        $oState->setFetchMode(PDO::FETCH_CLASS | PDO::FETCH_PROPS_LATE, static::CLASS_MANAGER,  $aArgs);
        while ($o = $oState->fetch()) { $aData[$o->getId()] = $o; }
        return $aData;
    }

    /**
     * @param $sSqlDate string
     * @param $sHourMinSec string
     * @return bool|OpeningTime
     * @throws Exception
     */
    public function getIdOpeningByDateAndHour($sSqlDate, $sHourMinSec)
    {
        date_default_timezone_set("Europe/Paris");
        $oDate = new DateTime($sSqlDate . ' ' . $sHourMinSec);

        //On récupère les horaires qui correspondent à ce jour ($sSqlDate) de la semaine
        $sEnDay = strtoupper($oDate->format('l'));
        $sFrDay = self::getLongDayEnToFr($sEnDay);
        $aData = $this->getByWhere(array('day' => $sFrDay));
        $iStartBooking = $oDate->getTimestamp();

        if($aData && is_array($aData))
        {
            /**
             * @var OpeningTime $oOpening
             */
            foreach($aData as $oOpening){
                $iStartTimeDay = strtotime($sSqlDate . ' ' . $oOpening->getStartTimeDay());
                $iEndTimeDay = strtotime($sSqlDate . ' ' .  $oOpening->getEndTimeDay());


                if($iStartBooking >= $iStartTimeDay && $iStartBooking <= $iEndTimeDay){
                    return $oOpening;
                }
            }
            return false;
        }
        else throw new Exception('Erreur ' . __FUNCTION__);
    }
}