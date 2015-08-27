<?php
    /**
    * @backupGlobals disabled
    * @backupStaticAttributes disabled
    */
    require_once "src/Author.php";
    require_once "src/Book.php";
    require_once "src/Patron.php";

    $server = 'mysql:host=localhost;dbname=library_test';
    $username = 'root';
    $password = 'root';
    $DB = new PDO($server, $username, $password);

    class PatronTest extends PHPUnit_Framework_TestCase
    {
        protected function tearDown()
        {
            Author::deleteAll();
            Book::deleteAll();
            Patron::deleteAll();
        }

        function test_getPatronName()
        {
            //Arrange
            $patron_name = "Stephen King";
            $id = null;
            $test_patron = new Patron($patron_name, $id);
            //Act
            $result = $test_patron->getpatronName();
            //Assert
            $this->assertEquals($patron_name, $result);
        }

        function test_setPatronName()
        {
            //Arrange
            $patron_name = "Stephen King";
            $id = null;
            $test_patron = new Patron($patron_name, $id);
            //Act
            $test_patron->setPatronName("James Patterson");
            $result = $test_patron->getPatronName();
            //Assert
            $this->assertEquals("James Patterson", $result);
        }

        function test_getId()
        {
           //Arrange
           $patron_name = "Biology";
           $id = 1;
           $test_patron = new Patron($patron_name, $id);
           //Act
           $result = $test_patron->getId();
           //Assert
           $this->assertEquals(1, $result);
        }

        function test_save()
        {
            //Arrange
            $patron_name = "Stephen King";
            $id = 1;
            $test_patron = new Patron($patron_name, $id);
            $test_patron->save();
            //Act
            $result = Patron::getAll();
            //Assert
            $this->assertEquals($test_patron, $result[0]);
        }

        function test_getAll()
        {
            //Arrange
            $patron_name = "Stephen King";
            $id = 1;
            $patron_name2 = "James Patterson";
            $id2 = 2;
            $test_patron = new Patron($patron_name, $id);
            $test_patron->save();
            $test_course2 = new Patron($patron_name2, $id2);
            $test_course2->save();
            //Act
            $result = Patron::getAll();
            //Assert
            $this->assertEquals([$test_patron, $test_course2], $result);
        }

        function test_deleteAll()
        {
            //Arrange
            $patron_name = "James Patterson";
            $id = 1;
            $patron_name2 = "Stephen King";
            $id2 = 2;
            $test_patron = new Patron($patron_name, $id);
            $test_patron->save();
            $test_course2 = new Patron($patron_name2, 2, $id2);
            $test_course2->save();
            //Act
            Patron::deleteAll();
            $result = Patron::getAll();
            //Assert
            $this->assertEquals([], $result);
        }

        function test_find()
        {
            //Arrange
            $patron_name = "James Patterson";
            $id = 1;
            $test_patron = new Patron($patron_name, $id);
            $test_patron->save();
            $patron_name2 = "Albebra";
            $id = 2;
            $test_patron2 = new Patron($patron_name2, $id);
            $test_patron2->save();
            //Act
            $result = Patron::find($test_patron->getId());
            //Assert
            $this->assertEquals($test_patron, $result);
        }

        function testUpdatePatronName()
        {
            //Arrange
            $patron_name = "Joe Patron";
            $id = 1;
            $test_patron = new Patron($patron_name, $id);
            $test_patron->save();
            $new_name = "James Patron";
            //Act
            $test_patron->updatePatronName($new_name);
            //Assert
            $this->assertEquals("James Patron", $test_patron->getPatronName());
       }
    }
 ?>
