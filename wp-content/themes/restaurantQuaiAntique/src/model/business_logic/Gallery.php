<?php


class Gallery extends ManagerObjTable
{

    CONST CLASS_MANAGER = 'ImageGallery';

    /**
     * @return string
     */
    static public function getTableName():string
    {
        global $wpdb;
        return $wpdb->prefix . 'gallery';
    }


    static public function getInstance() { return new Gallery(); }

    /**
     * @return bool
     */
    public function createTable():bool
    {
        $oPDO = PDOSingleton::getInstance();
        $sql = "CREATE TABLE IF NOT EXISTS " . self::getTableName() . " (
                    id INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
                    idAttachment BIGINT unsigned NOT NULL,
                    title TEXT(500) NULL)";
        $oStatement = $oPDO->prepare($sql);
        if(!$oStatement) return false;
        $b = $oStatement->execute();
        if(!$b) return $b;
        $aData = $this->getAllData();
        if(is_array($aData) && count($aData) === 0){
            $b = true;
            for($i=0; $i<6; $i++){
                $o = new ImageGallery(0, '');
                $c = $this->add($o);
                if(!$c) $b = $c;
            }
            return $b;
        } else return $b;
    }



    /**
     * @param $oState PDOStatement
     * @return array | bool
     */
    protected function statementGetExecute(PDOStatement $oState)
    {
        //dbrDie($oState->queryString);
        $aArgs = array('1', '1234567', '1');
        $bExec = $oState->execute();
        if(!$bExec) return $bExec;
        $aData = array();
        $oState->setFetchMode(PDO::FETCH_CLASS | PDO::FETCH_PROPS_LATE, self::CLASS_MANAGER,  $aArgs);
        while ($o = $oState->fetch()) { $aData[$o->getId()] = $o; }
        return $aData;
    }


    /**
     * @return array
     */
    public function getAllImgAttachmentWp()
    {
        $aJpg = get_posts(array(
            'post_type' => 'attachment',
            'relation' => 'AND',
            'numberposts' => 100,
            'type_mime' => 'image/jpg'));
        $aData = array();
        if(is_array($aJpg) && count($aJpg) > 0){
            foreach ($aJpg as $oItem){
                $aData[$oItem->ID] = $oItem;
            }
        }

        $aPng = get_posts(array(
            'post_type' => 'attachment',
            'relation' => 'AND',
            'numberposts' => 100,
            'type_mime' => 'image/png'));

        if(is_array($aPng) && count($aPng) > 0){
            foreach ($aPng as $oItem){
                $aData[$oItem->ID] = $oItem;
            }
        }
        ksort($aData);
        return $aData;
    }

    /**
     * @return array|bool
     */
    public function getAttchementGallery()
    {
        $oPDO = PDOSingleton::getInstance();
        $oState = $oPDO->prepare('SELECT g.*, p.guid as guid FROM ' . self::getTableName() . ' as g LEFT JOIN wp_posts as p ON p.ID = g.idAttachment');
        $bExec = $oState->execute();
        if(!$bExec) return $bExec;
        $aData = array();
        $aArgs = array('1', '1234567', '1');
        $oState->setFetchMode(PDO::FETCH_CLASS | PDO::FETCH_PROPS_LATE, static::CLASS_MANAGER,  $aArgs);
        while ($o = $oState->fetch()) { $aData[$o->getId()] = $o; }
        return $aData;
    }
}