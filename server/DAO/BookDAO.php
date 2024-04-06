<?php
require_once(__DIR__ . '/../Utils/SqlHelper.php');
require_once(__DIR__ . '/CrudDAOInterface.php');
/**
 * The BookDAO class implements the CrudDAOInterface.
 * It provides methods to perform CRUD operations on the 'books' table.
 */
class BookDAO implements CrudDAOInterface
{
    private $sqlHelper;
    /**
     * BookDAO constructor.
     * @param $conn Database connection object
     */
    public function __construct($conn)
    {
        $this->sqlHelper = new SqlHelper($conn);
    }
    /**
     * Inserts a new book record into the database.
     * @param $book Object containing book details
     * @return array Result of the insert operation
     */
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
    /**
     * Updates an existing book record in the database.
     * @param $book Object containing updated book details
     * @return array Result of the update operation
     */
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
     /**
     * Deletes a book record from the database by its ID.
     * @param $id ID of the book to be deleted
     * @return array Result of the delete operation
     */
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
    /**
     * Finds a book record in the database by its ID.
     * @param $id ID of the book to be retrieved
     * @return array Result containing the book record or a status message
     */
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
    /**
     * Searches for book records that match certain conditions like title, author, ISBN, and genre.
     * @param $text Search keyword
     * @return array Result containing book records that match the search criteria or a status message
     */
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
        } catch (\Exception $e) {
            return ['resCode' => 3, 'resMsg' => 'An error occurred in database', 'error' => $e->getMessage()];
        }
    }

    /**
     * Retrieves all book records from the database.
     * @return array Result containing all book records or a status message
     */
    public function findAll()
    {
        try {
            $sql = "SELECT * FROM books order by created_at desc";
            $result = $this->sqlHelper->executeQuery($sql, [], true);
                      return ['resCode' => 0, 'resMsg' => 'success', 'rows' => $result];
        } catch (Exception $e) {
            return ['resCode' => 3, 'resMsg' => 'An error occurred in database', 'error' => $e->getMessage()];
        }
    }
}
