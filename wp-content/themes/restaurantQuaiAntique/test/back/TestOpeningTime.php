<?php


class TestOpeningTime
{
    public function mainTestOpeningTime()
    {
        $sFunction = __FUNCTION__;
        echo 'Start ' . $sFunction  .'<br/>';
        try {

            $this->testUpdateOpeningTimeByForm();
            echo 'End ' . $sFunction  .'<br/>';

        } catch(Exception $e) {
            echo $e->getMessage();
            die();
        }
    }

    public function testUpdateOpeningTimeByForm()
    {
        $_POST['id'] = 1;
        $_POST['timeStart'] = '12:35';
        $_POST['timeEnd'] = '15h08';
        $b = ajaxUpdateOpeningTime();
        if($b === true) htmlMessageTest( __FUNCTION__);
        else{
            var_dump($b);
            dbr($b);
            htmlMessageTest( __FUNCTION__, false );
        }
    }
}