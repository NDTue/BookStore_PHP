<?php



require_once __DIR__ . '/../../vendor/autoload.php';
require_once __DIR__ . '/../auth-check.php';

use App\Controllers\BookController;


$bookController = new BookController();

checkLogin();
// Handle the add to cart action
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $bookController->addToCart();
}


?>
