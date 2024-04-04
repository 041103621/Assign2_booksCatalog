<?php
require_once(__DIR__ . '/../Entity/Book.php');

class BookService
{
    private $bookDao;

    public function __construct($bookDao)
    {
        $this->bookDao = $bookDao;
    }

    public function addBook($title,$author,$publish_date,$isbn,$description,$img,$score,$genre)
    {

        $result = $this->bookDao->insert(new Book($title,$author,$publish_date,$isbn,$description,$img,$score,$genre));
        return $result;
    }

    public function modifyBook($title,$author,$publish_date,$isbn,$description,$img,$score,$genre,$id)
    {

        $result = $this->bookDao->update(new Book($title,$author,$publish_date,$isbn,$description,$img,$score,$genre,$id));
        return $result;
    }

    public function deleteBook($id)
    {

        $result = $this->bookDao->delete($id);
        return $result;
    }

    public function getAllBooks()
    {
        $result = $this->bookDao->findAll();
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }

        $userid = isset($_SESSION['userid']) ? $_SESSION['userid'] : -1;
        $username = isset($_SESSION['username']) ? $_SESSION['username'] : 'Guest';
        if ($result['resCode'] === 0) {
            return [
                'resCode' => 0,
                'resMsg' => 'success',
                'userid' => $userid,
                'username' => $username,
                'rows' => $result['rows']
            ];
        }
        return $result;
    }

    public function getBookById($id)
    {
        $result = $this->bookDao->findById($id);
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }

        $userid = isset($_SESSION['userid']) ? $_SESSION['userid'] : -1;
        $username = isset($_SESSION['username']) ? $_SESSION['username'] : 'Guest';
        if ($result['resCode'] === 0) {
            return [
                'resCode' => 0,
                'resMsg' => 'success',
                'userid' => $userid,
                'username' => $username,
                'rows' => $result['rows']
            ];
        }
        return $result;
    }

    public function findBySomeConditions($text)
    {
        $result = $this->bookDao->findBySomeConditions($text);
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }

        $userid = isset($_SESSION['userid']) ? $_SESSION['userid'] : -1;
        $username = isset($_SESSION['username']) ? $_SESSION['username'] : 'Guest';
        if ($result['resCode'] === 0) {
            return [
                'resCode' => 0,
                'resMsg' => 'success',
                'userid' => $userid,
                'username' => $username,
                'rows' => $result['rows']
            ];
        }
        return $result;
    }
}
