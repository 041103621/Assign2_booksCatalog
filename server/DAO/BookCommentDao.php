<?php
require_once (__DIR__ . '/../Utils/SqlHelper.php');
require_once (__DIR__ . '/CrudDAOInterface.php');
/**
 * The BookCommentDAO class implements the CrudDAOInterface to manage book comments in the database.
 * It provides methods to insert, find, and manage book comments.
 */
class BookCommentDAO implements CrudDAOInterface
{
    private $sqlHelper;
    /**
     * Constructor initializes the class with a SQL helper object.
     * 
     * @param mysqli $conn The database connection object.
     */
    public function __construct($conn)
    {
        $this->sqlHelper = new SqlHelper($conn);
    }
    /**
     * Inserts a new book comment into the database.
     * 
     * @param object $bookcomment The book comment object containing all necessary data.
     * @return array An associative array with the result code, message, and potentially affected rows.
     */
    public function insert($bookcomment)
    {
        try {
			// SQL statement for inserting a book comment
            $sql = "insert into bookcomments(bookid,userid,comments) values (?,?,?)";
			// Parameters for the prepared statement
            $params = [$bookcomment->getBookid(),$bookcomment->getUserid(),$bookcomment->getComments()];
            // Execute the query and return the result
            $result = $this->sqlHelper->executeQuery($sql, $params, false);
            // Check the result and return the appropriate response
            if ($result>0) {
                return ['resCode' => 0, 'resMsg' => 'Success', 'rows' => $result];
            } else {
                return ['resCode' => 3, 'resMsg' => 'Insert fail'];
            }

        } catch (Exception $e) {
			// Handle any exceptions and return an error message
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
    /**
     * Finds comments for a specific book by its ID.
     * 
     * @param int $bookid The ID of the book.
     * @return array An associative array with the result code, message, and data rows if successful.
     */
    public function findByBookId($bookid)
    {
        try {
			// SQL statement to find comments for a specific book
            $sql = "select a.id,a.bookid,a.userid,a.comments,b.username,a.created_at from bookcomments a,users b where a.bookid=? and a.userid=b.id";
            // Parameters for the prepared statement
			$params = [$bookid];
			// Execute the query and return the result
            $result = $this->sqlHelper->executeQuery($sql, $params, true);
            // Check the result and return the appropriate response
            if (!empty($result)) {
                return ['resCode' => 0, 'resMsg' => 'Success', 'rows' => $result];
            } else {
                return ['resCode' => 4, 'resMsg' => 'Record does not exist'];
            }
        } catch (Exception $e) {
			// Handle any exceptions and return an error message
            return ['resCode' => 3, 'resMsg' => 'An error occurred in database', 'error' => $e->getMessage()];
        }
    }

    // Placeholder for unimplemented method
    public function findAll()
    {
    }
}
