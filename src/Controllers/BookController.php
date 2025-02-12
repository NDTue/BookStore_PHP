<?php

// BookController.php

namespace App\Controllers;

use App\Controller;
use App\Models\Book;

class BookController extends Controller
{
    private $connection;
    private $bookModel;
    public function __construct()
    {
        $this->bookModel = new Book();
    }

    public function view()
    {
        $category = $_GET['category'] ?? null;
        $search = $_GET['search'] ?? null;
        $searchBy = $_GET['searchBy'] ?? 'tensach';

        if ($search) {
            $books = $this->bookModel->searchBook($search, $searchBy);
        } elseif ($category) {
            $bookObj = new Book();
            $books = $bookObj->getBooksByCategory($category);
        } else {
            $bookObj = new Book();
            $books = $bookObj->getAllBooks();
        }

        $categories = $this->categories();
        include(__DIR__ . '/../Views/home/index.php');
    }

    public function addToCart()
    {
        // Get POST data from the JSON body
        $data = json_decode(file_get_contents('php://input'), true);
        $bookId = $data['bookId'];

        // Start session if it's not already started
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }

        // Initialize the cart if it doesn't exist
        if (!isset($_SESSION['cart'])) {
            $_SESSION['cart'] = [];
        }

        // If the book is already in the cart, increment the quantity; else, add it
        if (!isset($_SESSION['cart'][$bookId])) {
            $_SESSION['cart'][$bookId] = 1;
        } else {
            $_SESSION['cart'][$bookId]++;
        }

        // Debugging line to check cart contents
        error_log('Cart Contents: ' . print_r($_SESSION['cart'], true));

        // Send success response
        echo json_encode(['status' => 'success']);
    }

    public function getCartItems()
    {
        $cartItems = [];

        if (isset($_SESSION['cart'])) {
            foreach ($_SESSION['cart'] as $bookId => $quantity) {
                $bookObj = new Book();
                $book = $bookObj->getBookById($bookId);
                $book->quantity = $quantity;
                $cartItems[] = $book;
            }
        }

        return $cartItems;
    }

    // Method to fetch distinct categories from the database
    public function categories()
    {
        $categories = $this->bookModel->getCategories(); // Get all categories at once

        $formattedCategories = [];
        foreach ($categories as $category) {
            $formattedCategories[] = [
                'id' => $category['maloai'],
                'name' => $category['tenloai']
            ];
        }

        return $formattedCategories;
    }

}

