<?php
    class Patron
    {
        private $patron_name;
        private $id;

        function __construct($patron_name, $id = null)
        {
            $this->patron_name = $patron_name;
            $this->id = $id;
        }
        function setPatronName($new_patron)
        {
            $this->patron_name = $new_patron;
        }
        function getPatronName()
        {
            return $this->patron_name;
        }

        function getId()
        {
            return $this->id;
        }

        function save()
        {
            $GLOBALS['DB']->exec("INSERT INTO patrons (patron_name)
            VALUES ('{$this->getPatronName()}');");
            $this->id = $GLOBALS['DB']->lastInsertID();
        }

        static function getAll()
        {
            $returned_patrons = $GLOBALS['DB']->query("SELECT * FROM patrons;");
            $patrons = array();
            foreach($returned_patrons as $patron) {
                $patron_name = $patron['patron_name'];
                $id = $patron['id'];
                $new_patron = new Patron($patron_name, $id);
                array_push($patrons, $new_patron);
            }
            return $patrons;
        }

        static function deleteAll()
        {
            $GLOBALS ['DB']->exec("DELETE FROM patrons;");
        }

        static function find($search_id)
        {
            $found_patron = null;
            $patrons = Patron::getAll();
            foreach($patrons as $patron) {
                $patron_id = $patron->getId();
                if ($patron_id == $search_id) {
                    $found_patron = $patron;
                }
            }
            return $found_patron;
        }

        //Update patron_name
        function updatePatronName($new_patron)
        {
            $GLOBALS['DB']->exec("UPDATE patrons SET patron_name = '{$new_patron}'
                WHERE id = {$this->getId()}");
            $this->setPatronName($new_patron);
        }

        // function addCheckout($copy_id)
        // {
        //     $GLOBALS['DB']->exec("INSERT INTO checkouts (copy_id, patron_id, due_date)
        //         VALUES ({$copy_id}, {$this->id}, '{CURDATE(), interval 1 month}')");
        // }

        // function getCheckouts()
        // {
        //     $returned_checkouts = $GLOBALS['DB']->query("SELECT books.* FROM
        //         books JOIN copies ON (books.id = copies.book_id)
        //         JOIN checkouts ON (checkouts.copy_id = copies.id)
        //         JOIN patrons ON (patrons.id = checkouts.patron_id)
        //         WHERE patrons.id = {$this->getId()}");
        //         var_dump($returned_checkouts);
        //     $checkouts = array();
        //     foreach($returned_checkouts as $checkout)
        //     {
        //         $title = $checkout['title'];
        //         $id = $checkout['id'];
        //         $new_checkout = new Book($title, $id);
        //         array_push($chekcouts, $new_checkout);
        //     }
        //     return $checkouts;
        // }


    }
 ?>
