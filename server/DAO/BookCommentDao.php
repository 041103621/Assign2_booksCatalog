<?php
require_once (__DIR__ . '/../Utils/SqlHelper.php');
require_once (__DIR__ . '/CrudDAOInterface.php');

class BookCommentDAO implements CrudDAOInterface
{
    private $sqlHelper;

    public function __construct($conn)
    {
        $this->sqlHelper = new SqlHelper($conn);
    }

    public function insert($bookcomment)
    {
        try {
            $sql = "insert into bookcomments(bookid,userid,comments) values (?,?,?)";
            $params = [$bookcomment->getBookid(),$bookcomment->getUserid(),$bookcomment->getComments()];

            $result = $this->sqlHelper->executeQuery($sql, $params, false);

            if ($result>0) {
                return ['resCode' => 0, 'resMsg' => 'Success', 'rows' => $result];
            } else {
                return ['resCode' => 3, 'resMsg' => 'Insert fail'];
            }

        } catch (Exception $e) {
            return ['resCode' => 3, 'resMsg' => 'An error occurred in database', 'error' => $e->getMessage()];
        }
    }

    public function update($user)
    {
    }

    public function delete($id)
    {
    }

    public function findById($id)
    {
    }

    public function findByBookId($bookid)
    {
        try {
            $sql = "select a.id,a.bookid,a.userid,a.comments,b.username,a.created_at from bookcomments a,users b where a.bookid=? and a.userid=b.id";
            $params = [$bookid];
            $result = $this->sqlHelper->executeQuery($sql, $params, true);

            if (!empty($result)) {
                return ['resCode' => 0, 'resMsg' => 'Success', 'rows' => $result];
            } else {
                return ['resCode' => 4, 'resMsg' => 'Record does not exist'];
            }
        } catch (Exception $e) {
            return ['resCode' => 3, 'resMsg' => 'An error occurred in database', 'error' => $e->getMessage()];
        }
    }


    public function findAll()
    {
    }
}
