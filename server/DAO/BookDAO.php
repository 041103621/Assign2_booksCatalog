<?php
require_once(__DIR__ . '/../Utils/SqlHelper.php');
require_once(__DIR__ . '/CrudDAOInterface.php');

class BookDAO implements CrudDAOInterface
{
    private $sqlHelper;

    public function __construct($conn)
    {
        $this->sqlHelper = new SqlHelper($conn);
    }

    public function insert($book)
    {
        try {
            $sql = "insert into books (title,author,isbn,publish_date,genre,description,img,score) values (?,?,?,?,?,?,?,?)";
            $params = [$book->getTitle(), $book->getAuthor(),$book->getIsbn(),$book->getPublish_date(),$book->getGenre(),$book->getDescription(),$book->getImg(),$book->getScore()];

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

    public function update($book)
    {
        try {
            $sql = "update books set title=?,author=?,isbn=?,publish_date=?,genre=?,description=?,img=?,score=? where id=?";
            $params = [$book->getTitle(), $book->getAuthor(),$book->getIsbn(),$book->getPublish_date(),$book->getGenre(),$book->getDescription(),$book->getImg(),$book->getScore(),$book->getId()];

            $result = $this->sqlHelper->executeQuery($sql, $params, false);

            if ($result > 0) {
                return ['resCode' => 0, 'resMsg' => 'Success', 'rows' => $result];
            } else {
                return ['resCode' => 3, 'resMsg' => 'Update fail'];
            }
        } catch (Exception $e) {
            return ['resCode' => 3, 'resMsg' => 'An error occurred in database', 'error' => $e->getMessage()];
        }
    }

    public function delete($id)
    {
        try {

            $sql = "delete from books where id=?";
            $params = [$id];

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

    public function findById($id)
    {
        try {
            $sql = "select * from books where id=?";
            $params = [$id];
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

    public function findBySomeConditions($text)
    {
        try {
            $sql = "select * from books where title=? or author=? or isbn=? or genre=?";
            $sql = "select * from books where title LIKE ? OR author LIKE ? OR isbn LIKE ? OR genre LIKE ?";
            $likeText = '%' . $text . '%';
            $params = [$likeText, $likeText, $likeText, $likeText];
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
        try {
            //$books = [];
            $sql = "SELECT * FROM books order by created_at desc";
            $result = $this->sqlHelper->executeQuery($sql, [], true);

            // if ($result-> > 0) {
            //     while($row = $result->fetch_assoc()) {
            //         $book=$this->sqlHelper::createObjectFromRow('Book',$row);
            //         $books[] = $book;
            //     }
            // }
            return ['resCode' => 0, 'resMsg' => 'success', 'rows' => $result];
        } catch (Exception $e) {
            return ['resCode' => 3, 'resMsg' => 'An error occurred in database', 'error' => $e->getMessage()];
        }
    }
}
