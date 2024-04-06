<?php
require_once(__DIR__ . '/../Utils/SqlHelper.php');
require_once(__DIR__ . '/CrudDAOInterface.php');
/**
 * The UserBookDAO class implements the CrudDAOInterface for managing interactions
 * with the 'userbooks' table, which links users to books they own or are interested in.
 */
class UserBookDAO implements CrudDAOInterface
{
    private $sqlHelper;
    /**
     * Constructor of the UserBookDAO class.
     * 
     * @param $conn Database connection object used for initializing SqlHelper.
     */
    public function __construct($conn)
    {
        $this->sqlHelper = new SqlHelper($conn);
    }
    /**
     * Inserts a new association between a user and a book into the 'userbooks' table.
     * 
     * @param $userbook Object containing the user ID and book ID to be inserted.
     * @return array An associative array with the operation result code and message.
     */
    public function insert($userbook)
    {
        try {
			// Check if the association already exists
            $queryResult = $this->findByUserIdAndBookid($userbook->getUserid(), $userbook->getBookid());
            if ($queryResult['resCode'] === 0) {
                return ['resCode' => 8, 'resMsg' => "Book exists"];
            }
            // Insert the new association
            $sql = "insert into userbooks (userid,bookid) values (?,?)";
            $params = [$userbook->getUserid(), $userbook->getBookid()];

            $result = $this->sqlHelper->executeQuery($sql, $params, false);
            // Return the result
            if ($result > 0) {
                return ['resCode' => 0, 'resMsg' => 'Success', 'rows' => $result];
            } else {
                return ['resCode' => 3, 'resMsg' => 'Insert fail'];
            }
        } catch (Exception $e) {
            return ['resCode' => 3, 'resMsg' => 'An error occurred in database', 'error' => $e->getMessage()];
        }
    }
    // Method stubs for interface compliance
    public function findById($id){}

    public function update($user){}

    public function delete($id){}
    /**
     * Deletes an association between a user and a book by their IDs.
     * 
     * @param $userid User ID of the association to delete.
     * @param $bookid Book ID of the association to delete.
     * @return array An associative array with the operation result code and message.
     */
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
    /**
     * Finds an association by user ID and book ID.
     * 
     * @param $userid User ID of the association to find.
     * @param $bookid Book ID of the association to find.
     * @return array An associative array with the operation result code and message, including the found association(s).
     */
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
    /**
     * Finds all book associations for a given user ID.
     * 
     * @param $userid User ID for which to find all book associations.
     * @return array An associative array with the operation result code and message, including all associated books.
     */
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
    // Method stub for interface compliance
    public function findAll()
    {
    }
}
