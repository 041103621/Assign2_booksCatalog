<?php
require_once (__DIR__ . '/../Utils/SqlHelper.php');
require_once (__DIR__ . '/CrudDAOInterface.php');
/**
 * The UserDAO class for managing interactions with the 'users' table in the database.
 * It implements the CrudDAOInterface, providing specific implementations for user-related operations.
 */
class UserDAO implements CrudDAOInterface
{
    private $sqlHelper;
    /**
     * Constructor of the UserDAO class.
     * 
     * @param $conn The database connection object used to create an instance of SqlHelper.
     */
    public function __construct($conn)
    {
        $this->sqlHelper = new SqlHelper($conn);
    }
    /**
     * Inserts a new user into the database.
     * 
     * @param $user The user object containing user data to insert.
     * @return array An associative array with the result code and message of the insert operation.
     */
    public function insert($user)
    {
        try {
             // Check if the user already exists before inserting
            $queryResult=$this->findByUserName($user->getUsername());
            if($queryResult['resCode']===0){
                return ['resCode' => 8, 'resMsg' => 'This user exists!'];
            }
			// SQL statement for inserting a new user
            $sql = "insert into users (username,password) values (?,?)";
            $params = [$user->getUsername(),$user->getPassword()];
            // Execute the insert query
            $result = $this->sqlHelper->executeQuery($sql, $params, false);
            // Check the insert result and return the appropriate response
            if ($result>0) {
                return ['resCode' => 0, 'resMsg' => 'Success', 'rows' => $result];
            } else {
                return ['resCode' => 3, 'resMsg' => 'Insert fail'];
            }

        } catch (Exception $e) {
			// Catch any exceptions and return an error message
            return ['resCode' => 3, 'resMsg' => 'An error occurred in database', 'error' => $e->getMessage()];
        }
    }
    /**
     * Updates a user in the database.
     * (Method not implemented but required by the interface)
     *
     * @param $user The user object containing data for update.
     */
    public function update($user)
    {
    }
    /**
     * Deletes a user from the database by their ID.
     * (Method not implemented but required by the interface)
     *
     * @param $id The unique identifier of the user to delete.
     */
    public function delete($id)
    {
    }
    /**
     * Finds a user by their ID.
     * (Method not implemented but required by the interface)
     *
     * @param $id The unique identifier of the user to find.
     */
    public function findById($id)
    {
    }
    /**
     * Finds a user by their username.
     * 
     * @param $username The username of the user to find.
     * @return array An associative array containing the user's data or a status message.
     */
    public function findByUserName($username)
    {
        try 
		// SQL statement to find a user by username
		{
            $sql = "select id,username,password from users where username=?";
            $params = [$username];
			// Execute the query and return the result
            $result = $this->sqlHelper->executeQuery($sql, $params, true);
            // Check if any user was found and return the result
            if (!empty($result)) {
                return ['resCode' => 0, 'resMsg' => 'Success', 'rows' => $result];
            } else {
                return ['resCode' => 4, 'resMsg' => 'Record does not exist'];
            }
        } catch (Exception $e) {
			// Catch any exceptions and return an error message
            return ['resCode' => 3, 'resMsg' => 'An error occurred in database', 'error' => $e->getMessage()];
        }
    }

    /**
     * Retrieves all users from the database.
     * (Method not implemented but required by the interface)
     */
    public function findAll()
    {
    }
}
