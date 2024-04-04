<?php

class BookController
{
    private $bookService;

    public function __construct($bookService)
    {
        $this->bookService = $bookService;
    }

    public function addBook()
    {
        $data = json_decode(file_get_contents('php://input'), true);
        $response = $this->bookService->addBook($data['title'], $data['author'], $data['publish_date'], $data['isbn'], $data['description'], $data['img'], $data['score'], $data['genre']);
        echo json_encode($response);
    }

    public function modifyBook()
    {
        $data = json_decode(file_get_contents('php://input'), true);
        $response = $this->bookService->modifyBook($data['title'], $data['author'], $data['publish_date'], $data['isbn'], $data['description'], $data['img'], $data['score'], $data['genre'], $data['id']);
        echo json_encode($response);
    }

    public function deleteBook()
    {
        $data = json_decode(file_get_contents('php://input'), true);
        $response = $this->bookService->deleteBook($data['bookid']);
        echo json_encode($response);
    }

    public function getAllBooks()
    {
        $response = $this->bookService->getAllBooks();
        echo json_encode($response);
    }

    public function getBookById($id)
    {
        $response = $this->bookService->getBookById($id);
        echo json_encode($response);
    }

    public function findBySomeConditions($text)
    {
        $response = $this->bookService->findBySomeConditions($text);
        echo json_encode($response);
    }
}
