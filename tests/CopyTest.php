<?php
    /**
    * @backupGlobals disabled
    * @backupStaticAttributes disabled
    */
    require_once "src/Copy.php";
    require_once "src/Book.php";
    require_once "src/Patron.php";

    $server = 'mysql:host=localhost;dbname=library_test';
    $username = 'root';
    $password = 'root';
    $DB = new PDO($server, $username, $password);

    class CopyTest extends PHPUnit_Framework_TestCase
    {
        protected function tearDown()
        {
            Copy::deleteAll();
            Book::deleteAll();
            Patron::deleteAll();
        }

        function test_getAll()
        {
            //Arrange
            $copy_id = 1;
            $id = 11;
            $copy_id2= 2;
            $id2 = 22;
            $test_copy = new Copy($copy_id, $id);
            $test_copy->save();
            $test_copy2 = new Copy($copy_id2, $id2);
            $test_copy2->save();
            //Act
            $result = Copy::getAll();
            //Assert
            $this->assertEquals([$test_copy, $test_copy2], $result);
        }
    }
?>
