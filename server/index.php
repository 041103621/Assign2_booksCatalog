<?php
require_once './Database/Database.php';

require_once './DAO/UserDAO.php';
require_once './Service/UserService.php';
require_once './Controller/UserController.php';

require_once './DAO/BookDAO.php';
require_once './Service/BookService.php';
require_once './Controller/BookController.php';

require_once './DAO/UserBookDAO.php';
require_once './Service/UserBookService.php';
require_once './Controller/UserBookController.php';

require_once './DAO/BookCommentDAO.php';
require_once './Service/BookCommentService.php';
require_once './Controller/BookCommentController.php';

header('Content-Type: application/json');

$requestMethod = $_SERVER['REQUEST_METHOD'];
$requestUri = $_SERVER['REQUEST_URI'];

$uriSegments = explode('/', trim($requestUri, '/'));
$apiSegment = $uriSegments[2] ?? null;
$actionSegment = $uriSegments[3] ?? null;
$actionSegmentObject = $uriSegments[4] ?? null;
$actionSegmentObjectId = $uriSegments[5] ?? null;
$actionSegmentSearchVal = $uriSegments[6] ?? null;

$userDAO = new UserDAO(Database::getInstance()->getConnection());
$userService = new UserService($userDAO);
$userController = new UserController($userService);

$bookDAO = new BookDAO(Database::getInstance()->getConnection());
$bookService = new BookService($bookDAO);
$bookController = new BookController($bookService);

$userbookDAO = new UserBookDAO(Database::getInstance()->getConnection());
$userbookService = new UserBookService($userbookDAO);
$userbookController = new UserBookController($userbookService);

$bookcommentDAO = new BookCommentDAO(Database::getInstance()->getConnection());
$bookcommentService = new BookCommentService($bookcommentDAO);
$bookcommentController = new BookCommentController($bookcommentService);

if ($apiSegment === 'api') {
    switch ($actionSegment) {
        case 'register':
            if ($requestMethod == 'POST') {
                $userController->register();
            } else {
                http_response_code(405);
                echo json_encode(['error' => 'Method Not Allowed']);
            }
            break;
        case 'login':
            $userController->login();
            break;
        case 'logout':
            $userController->logout();
            break;
        case 'get':
            if ($actionSegmentObject === 'books') {
                if ($actionSegmentObjectId === "searchVal") {
                    $bookController->findBySomeConditions($actionSegmentSearchVal);
                } else if (isset($actionSegmentObjectId)) {
                    $bookController->getBookById($actionSegmentObjectId);
                } else {
                    $bookController->getAllBooks();
                }
            } else if ($actionSegmentObject === 'userbooks') {
                $userbookController->getUserBooks();
            } else if ($actionSegmentObject === 'bookcomment') {
                $bookcommentController->getBookComments($actionSegmentObjectId);
            }
            break;
        case 'post':
            if ($actionSegmentObject === 'userbook') {
                $userbookController->addBookToBookShelf();
            } else if ($actionSegmentObject === 'bookcomment') {
                $bookcommentController->addBookComments();
            } else if ($actionSegmentObject === 'books') {
                $bookController->addBook();
            }
            break;
        case 'put':
            if ($actionSegmentObject === 'books') {
                $bookController->modifyBook();
            }
            break;
        case 'delete':
            if ($actionSegmentObject === 'userbook') {
                $userbookController->removeBookFromBookShelf();
            }else if ($actionSegmentObject === 'books') {
                $bookController->deleteBook();
            }
            break;
        default:
            http_response_code(404);
            echo json_encode(['error' => 'Not Found']);
            break;
    }
} else {
    http_response_code(404);
    echo json_encode(['error' => 'Not Found']);
}
