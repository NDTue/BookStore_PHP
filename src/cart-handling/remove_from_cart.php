<?php
session_start(); 
// Enable error reporting for debugging
ini_set('display_errors', 1);
error_reporting(E_ALL);

// remove_from_cart.php

require_once __DIR__ . '/../../vendor/autoload.php';

use App\Controllers\BookController;

// Database connection using MySQLi
$host = 'localhost';
$username = 'root';
$password = '';
$dbname = 'quanlysach';

$conn = new mysqli($host, $username, $password, $dbname);

// Check for connection error
if ($conn->connect_error) {
    die('Connection failed: ' . $conn->connect_error);
}

// Instantiate the controller with the MySQLi connection
$bookController = new BookController();

// Get the data from the request
$data = json_decode(file_get_contents('php://input'), true);
$bookId = $data['bookId'] ?? null;

// Check if the bookId is valid
if ($bookId && isset($_SESSION['cart'][$bookId])) {
    // Remove the book from the cart
    unset($_SESSION['cart'][$bookId]);
    echo json_encode(['status' => 'success']);
} else {
    // If the book is not found, return an error response
    echo json_encode(['status' => 'error', 'message' => 'Book not found in cart']);
}

// Close the MySQLi connection
$conn->close();

?>
