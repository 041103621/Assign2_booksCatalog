<?php
require_once(__DIR__ . '/../Entity/User.php');

class UserService
{
    private $userDao;

    public function __construct($userDao)
    {
        $this->userDao = $userDao;
    }

    public function register($username, $password)
    {
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

        $result = $this->userDao->insert(new User($username, $hashedPassword));
        if ($result['resCode'] === 0) {
            $result2 = $this->userDao->findByUserName($username);
            if (session_status() == PHP_SESSION_NONE) {
                session_start();
            }

            $_SESSION['userid'] = $result2['rows'][0]['id'];
            $_SESSION['username'] = $username;
        }
        return $result;
    }

    public function login($username, $password)
    {
        $result = $this->userDao->findByUserName($username);

        if ($result['resCode'] === 0) {
            if (password_verify($password, $result['rows'][0]['password'])) {
                if (session_status() == PHP_SESSION_NONE) {
                    session_start();
                }

                $_SESSION['userid'] = $result['rows'][0]['id'];
                $_SESSION['username'] = $result['rows'][0]['username'];
                // password matched then return success info
                return ['resCode' => 0, 'resMsg' => 'Login successfully!'];
            } else {
                // password not matched then return fail info
                return ['resCode' => 1, 'resMsg' => 'Username or password is incorrect!'];
            }
        } else if ($result['resCode'] === 4) {
            return ['resCode' => 4, 'resMsg' => "You have not registered yet!"];
        } else {
            echo $result;
        }
    }
}
