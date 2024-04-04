<?php

class BookCommentController
{
    private $bookcommentService;

    public function __construct($bookcommentService)
    {
        $this->bookcommentService = $bookcommentService;
    }

    public function addBookComments()
    {
        $data = json_decode(file_get_contents('php://input'), true);
        if ($data['userid'] == "-1") {
            echo json_encode(['resCode' => 8, 'resMsg' => 'Please login first!']);
        } else {
            $response = $this->bookcommentService->addBookComments($data['bookid'], $data['userid'], $data['comments']);
            echo json_encode($response);
        }
    }

    public function  getBookComments($bookid)
    {
        $response = $this->bookcommentService->getBookComments($bookid);
        echo json_encode($response);
    }
}
