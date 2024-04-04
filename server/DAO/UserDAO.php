<?php
require_once (__DIR__ . '/../Utils/SqlHelper.php');
require_once (__DIR__ . '/CrudDAOInterface.php');

class UserDAO implements CrudDAOInterface
{
    private $sqlHelper;

    public function __construct($conn)
    {
        $this->sqlHelper = new SqlHelper($conn);
    }

    public function insert($user)
    {
        try {
            // should identify wheather the user exists
            $queryResult=$this->findByUserName($user->getUsername());
            if($queryResult['resCode']===0){
                return ['resCode' => 8, 'resMsg' => 'This user exists!'];
            }
            $sql = "insert into users (username,password) values (?,?)";
            $params = [$user->getUsername(),$user->getPassword()];

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

    public function findByUserName($username)
    {
        try {
            $sql = "select id,username,password from users where username=?";
            $params = [$username];
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
