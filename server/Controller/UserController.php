<?php

class UserController
{
    private $userService;

    public function __construct($userService)
    {
        $this->userService = $userService;
    }

    public function register()
    {
        $data = json_decode(file_get_contents('php://input'), true);
        $response = $this->userService->register($data['username'], $data['password']);
        echo json_encode($response);
    }

    public function login()
    {
        $data = json_decode(file_get_contents('php://input'), true);
        $response = $this->userService->login($data['username'], $data['password']);
        echo json_encode($response);
    }

    public function logout()
    {
        if (session_status() !== PHP_SESSION_NONE) {
            session_destroy();
            echo json_encode([
                'resCode' => 0,
                'resMsg' => 'success'
            ]);
        } else {
            echo json_encode([
                'resCode' => 0,
                'resMsg' => 'No session'
            ]);
        }
    }
}
