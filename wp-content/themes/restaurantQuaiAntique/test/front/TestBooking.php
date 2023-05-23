<?php


class TestBooking
{

    public function mainTestBookTable()
    {
        echo 'Start ' . __FUNCTION__ . '<br/>';
        try{
            /**
             * @var $oBooking Booking
             */
            $oBooking = $this->testBookTableByForm();
            if($oBooking)
            {
                $b = Bookings::getInstance()->deleteById($oBooking->getId());
                if($b) htmlMessageTest('Bookings::getInstance()->deleteById');
                else htmlMessageTest('Bookings::getInstance()->deleteById', false, 'Error');
            }
            echo 'END ' . __FUNCTION__ . '<br/>';

        }catch(Exception $e){
            echo $e->getMessage();
            die();
        }
    }

    public function testBookTableByForm()
    {
        $_POST['inpDateBook'] = '30/05/2023';
        $_POST['idOpening'] = '2';
        $_POST['startAppointement'] = '12:00';
        $_POST['inpNbGuest'] = '3';
        $_POST['inpLastName'] = 'Test';
        $_POST['inpFirstName'] = 'Test';
        $_POST['inpMail'] = 'test@test.com';
        $_POST['inpTel'] = '1324567890';
        $_POST['txtAllergie'] = 'Oui il y en a';
        $_POST['book-table'] = '';
        $_REQUEST['book_table_nonce'] = wp_create_nonce('bookTable');
        $oBooking = bookTable();
        if($oBooking && is_object($oBooking) && get_class($oBooking) === Booking::class) {
            htmlMessageTest( __FUNCTION__);
            return $oBooking;
        }else{
            var_dump($oBooking);
            dbr($oBooking);
            htmlMessageTest( __FUNCTION__, false, ' Error');
        }
    }

}