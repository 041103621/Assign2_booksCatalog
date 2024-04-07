<?php
require_once(__DIR__ . '/../Entity/UserBook.php');

class UserBookService
{
    private $userbookDAO;

    public function __construct($userbookDAO)
    {
        $this->userbookDAO = $userbookDAO;
    }

    public function addBookToBookShelf($userid, $bookid)
    {

        $result = $this->userbookDAO->insert(new UserBook($userid, $bookid));
        return $result;
    }

    public function removeBookFromBookShelf($userid, $bookid)
    {
        $result = $this->userbookDAO->deleteByUserIdAndBookId($userid, $bookid);
        return $result;
    }

    public function getUserBooks($userid)
    {
        $result = $this->userbookDAO->findByUserId($userid);

        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }

        $userid = isset($_SESSION['userid']) ? $_SESSION['userid'] : -1;
        $username = isset($_SESSION['username']) ? $_SESSION['username'] : 'Guest';
        if ($result['resCode'] == 0) {
            return [
                'resCode' => $result['resCode'],
                'resMsg' => $result['resMsg'],
                'userid' => $userid,
                'username' => $username,
                'rows' => $result['rows']
            ];
        } else {
            return [
                'resCode' => $result['resCode'],
                'resMsg' => $result['resMsg'],
                'userid' => $userid,
                'username' => $username
            ];
        }
        return $result;
    }
}
