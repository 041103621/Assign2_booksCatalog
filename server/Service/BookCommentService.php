<?php
require_once(__DIR__ . '/../Entity/BookComment.php');

class BookCommentService
{
    private $bookcommentDAO;

    public function __construct($bookcommentDAO)
    {
        $this->bookcommentDAO = $bookcommentDAO;
    }

    public function addBookComments($bookid,$userid,$comments)
    {

        $result = $this->bookcommentDAO->insert(new BookComment($bookid,$userid, $comments));
        return $result;
    }

    public function getBookComments($bookid)
    {
        $result = $this->bookcommentDAO->findByBookId($bookid);

        return $result;
    }
}
