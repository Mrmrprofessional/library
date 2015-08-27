<?php
    /**
    * @backupGlobals disabled
    * @backupStaticAttributes disabled
    */
    require_once "src/Checkout.php";
    require_once "src/Patron.php";

    $server = 'mysql:host=localhost;dbname=library_test';
    $username = 'root';
    $password = 'root';
    $DB = new PDO($server, $username, $password);

    class CheckoutTest extends PHPUnit_Framework_TestCase
    {
        protected function tearDown()
        {
            Patron::deleteAll();
            Book::deleteAll();
            Checkout::deleteAll();
        }

        Function test_save()
        {
            //Arrange
            $due_date = "0001-01-01";
            $copy_id = 1;
            $patron_id = 2;
            $id = 3;
            $test_checkout = new Checkout($due_date, $copy_id, $patron_id, $id);
            $test_checkout->save();

            //Act
            $result = Checkout::getAll();

            //Assert
            $this->assertEquals($test_checkout, $result[0]);
        }

        Function test_getAll()
        {
            //Arrange
            $due_date = "0001-01-01";
            $copy_id = 1;
            $patron_id = 2;
            $id = 3;
            $test_checkout = new Checkout($due_date, $copy_id, $patron_id, $id);
            $test_checkout->save();

            //Act
            $result = Checkout::getAll();

            //Assert
            $this->assertEquals($test_checkout, $result[0]);

        }

        function test_deleteAll()
        {
            //Arrange
            $due_date = "0001-01-01";
            $copy_id = 1;
            $patron_id = 2;
            $test_checkout = new Checkout($due_date, $copy_id, $patron_id);
            $test_checkout->save();

            $due_date2 = "2020-01-01";
            $copy_id2 = 3;
            $patron_id2 = 4;
            $test_checkout2 = new Checkout($due_date2, $copy_id2, $patron_id2);
            $test_checkout2->save();

            //Act
            Checkout::deleteAll();
            $result = Checkout::getAll();

            //Assert
            $this->assertEquals([], $result);
        }

    }
 ?>
