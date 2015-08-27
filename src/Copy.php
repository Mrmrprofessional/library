<?php
    class Copy
    {
        private $book_id;
        private $id;

        function __construct($book_id, $id)
        {
            $this->book_id = $book_id;
            $this->id = $id;
        }
        //Setter
        function setcopyName($new_book_id)
        {
            $this->book_id = (string) $new_book_id;
        }

        //Getters
        function getcopyName()
        {
            return $this->book_id;
        }

        function getId()
        {
            return $this->id;
        }

        //Delete a single copy
        function delete()
        {
            $GLOBALS['DB']->exec("DELETE FROM copies WHERE id = {$this->getID()};");
        }

        function save()
        {
            $GLOBALS['DB']->exec("INSERT INTO copies (book_id) VALUES ('{$this->getcopyName()}');");
            $this->id = $GLOBALS['DB']->lastInsertId();
        }

        //Static Methods
        static function getAll()
        {
            $returned_copies = $GLOBALS['DB']->query("SELECT * FROM copies;");
            $copies = array();
            foreach($returned_copies as $copy) {
                $book_id = $copy['book_id'];
                $id = $copy['id'];
                $new_copy = new copy($book_id, $id);
                array_push($copies, $new_copy);
            }
            return $copies;
        }

        static function deleteAll()
        {
            $GLOBALS['DB']->exec("DELETE FROM copies;");
        }

        static function find($search_id)
        {
            $found_copy = NULL;
            $copies = copy::getAll();
            foreach ($copies as $copy) {
                $copy_id = $copy->getId();
                if ($copy_id == $search_id) {
                    $found_copy = $copy;
                }
            }
            return $found_copy;
        }
        //Update methods

        function updatecopyName($new_book_id)
        {
            $GLOBALS['DB']->exec("UPDATE copies SET book_id = '{$new_book_id}' WHERE id = {$this->getId()};");
            $this->book_id = $new_book_id;
        }
        //Add get and add book(s)

        function addBook($book)
        {
            $GLOBALS['DB']->exec("INSERT INTO copies_books (copy_id, book_id) Values ({$this->getId()}, {$book->getID()});");
        }

        function getBooks()
        {
            $query = $GLOBALS['DB']->query("SELECT books.* FROM
            copies JOIN copies_books ON (copies.id = copies_books.copy_id)
                    JOIN books ON (copies_books.book_id = books.id)
            WHERE copies.id = {$this->getID()};");
            $returned_books = $query->fetchAll(PDO::FETCH_ASSOC);
            $books = array();
            foreach($returned_books as $book){
                $title = $book['title'];
                $id = $book['id'];
                $new_book = new Book($title, $id);
                array_push($books, $new_book);
            }
            return $books;
        }

        function addCopy($copy)
        {
            $GLOBALS['DB']->exec("INSERT INTO copies (book_id) VALLUES ({$copy->getId()});");
        }

        function getCopies()
        {
            $returned_copies = $GLOBALS['DB']->query("SELECT copies.* ")
        }

























    }

 ?>
