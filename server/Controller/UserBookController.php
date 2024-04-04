<?php

class UserBookController
{
    private $userbookService;

    public function __construct($userbookService)
    {
        $this->userbookService = $userbookService;
    }

    public function addBookToBookShelf()
    {
        $data = json_decode(file_get_contents('php://input'), true);
        $response = $this->userbookService->addBookToBookShelf($data['userid'], $data['bookid']);
        echo json_encode($response);
    }

    public function removeBookFromBookShelf(){
        $data = json_decode(file_get_contents('php://input'), true);
        $response = $this->userbookService->removeBookFromBookShelf($data['userid'], $data['bookid']);
        echo json_encode($response);
    }

    public function getUserBooks($userid)
    {
        $response = null;
        if ($userid === -1) {
            $response=['resCode' => 8, 'resMsg' => 'No login'];
        } else {
            $response = $this->userbookService->getUserBooks($userid);
        }
        echo json_encode($response);
    }
}
