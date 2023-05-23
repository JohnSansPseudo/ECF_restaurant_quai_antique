<?php


class TestGallery
{

    function mainTestGallery()
    {
        $sFunction = __FUNCTION__;
        try {

            $aGallery = Gallery::getInstance()->getByWhere(array('id' => 1));
            if($aGallery && is_array($aGallery) && count($aGallery) === 1)
            {
                /**
                 * @var $oGallery ImageGallery
                 *
                 */
                $oGallery = array_pop($aGallery);
                $this->testGalleryUpdate($oGallery);
                $this->testEraseGallery($oGallery);
            }
            echo 'End ' . $sFunction  .'<br/>';

        } catch(Exception $e) {
            echo $e->getMessage();
            die();
        }
    }

    /**
     * @var $oGallery ImageGallery
     */
    function testEraseGallery($oGallery)
    {
        $_POST['idGallery'] = $oGallery->getId();
        $b= ajaxDeleteImgGallery();
        if($b === true) htmlMessageTest( __FUNCTION__);
        else{
            var_dump($b);
            dbr($b);
            htmlMessageTest( __FUNCTION__, false, ' Error');
        }
    }


    function testGalleryUpdate($oGallery)
    {
        $this->testGalleryTitleUpdate($oGallery);
        $this->testGalleryImgUpdate($oGallery);
    }

    /**
     * @var $oGallery ImageGallery
     */
    function testGalleryTitleUpdate($oGallery)
    {
        $_POST['idGallery'] = $oGallery->getId();
        $_POST['value'] = 'new title test';
        $_POST['field'] = 'title';
        $b = ajaxUpdateImgGallery();
        if($b === true) htmlMessageTest( __FUNCTION__);
        else{
            var_dump($b);
            dbr($b);
            htmlMessageTest( __FUNCTION__, false, ' Error');
        }
    }

    /**
     * @var $oGallery ImageGallery
     */
    function testGalleryImgUpdate($oGallery)
    {
        $_POST['idGallery'] = $oGallery->getId();
        $_POST['value'] = 154;
        $_POST['field'] = 'idAttachment';
        $b = ajaxUpdateImgGallery();
        if($b === true) htmlMessageTest( __FUNCTION__);
        else{
            var_dump($b);
            dbr($b);
            htmlMessageTest( __FUNCTION__, false, ' Error');
        }
    }
}