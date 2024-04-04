<?php
require_once(__DIR__ . '/../Utils/SqlHelper.php');
require_once(__DIR__ . '/CrudDAOInterface.php');

class UserBookDAO implements CrudDAOInterface
{
    private $sqlHelper;

    public function __construct($conn)
    {
        $this->sqlHelper = new SqlHelper($conn);
    }

    public function insert($userbook)
    {
        try {
            $queryResult = $this->findByUserIdAndBookid($userbook->getUserid(), $userbook->getBookid());
            if ($queryResult['resCode'] === 0) {
                return ['resCode' => 8, 'resMsg' => "Book exists"];
            }

            $sql = "insert into userbooks (userid,bookid) values (?,?)";
            $params = [$userbook->getUserid(), $userbook->getBookid()];

            $result = $this->sqlHelper->executeQuery($sql, $params, false);

            if ($result > 0) {
                return ['resCode' => 0, 'resMsg' => 'Success', 'rows' => $result];
            } else {
                return ['resCode' => 3, 'resMsg' => 'Insert fail'];
            }
        } catch (Exception $e) {
            return ['resCode' => 3, 'resMsg' => 'An error occurred in database', 'error' => $e->getMessage()];
        }
    }

    public function findById($id)
    {
    }

    public function update($user)
    {
    }

    public function delete($id)
    {
    }

    public function deleteByUserIdAndBookId($userid, $bookid)
    {
        try {
            
            $sql = "delete from userbooks where userid=? and bookid=?";
            $params = [$userid, $bookid];

            $result = $this->sqlHelper->executeQuery($sql, $params, false);

            if ($result > 0) {
                return ['resCode' => 0, 'resMsg' => 'Success', 'rows' => $result];
            } else {
                return ['resCode' => 3, 'resMsg' => 'Delete fail'];
            }
        } catch (Exception $e) {
            return ['resCode' => 3, 'resMsg' => 'An error occurred in database', 'error' => $e->getMessage()];
        }
    }

    public function findByUserIdAndBookid($userid, $bookid)
    {
        try {
            $sql = "select * from userbooks where userid=? and bookid=?";
            $params = [$userid, $bookid];
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

    public function findByUserId($userid)
    {
        try {
            $sql = "select a.userid,a.bookid,b.title,b.author,b.isbn,b.publish_date,b.genre,b.description,b.img,b.score,b.created_at from userbooks a,books b where a.bookid=b.id and a.userid=?";
            $params = [$userid];
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
