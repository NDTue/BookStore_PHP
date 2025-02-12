<?php

require_once __DIR__ . '/vendor/autoload.php';

use App\Controller\UserController;
use App\Controllers\BookController;

use App\Models\User;

use App\Router;


require __DIR__. '/src/routes.php';
$uri = $_SERVER['REQUEST_URI'];

$router->match($uri);

// $testUsername = 'lmao'; // Replace this with a username that exists in your database

// try {
//     // Initialize the User class
//     $userModel = new User();

//     // Call the function
//     $user = $userModel->getUserByUsername($testUsername);

//     // Check if user was found and display the result
//     if ($user) {
//         echo "User found:\n";
//         print_r($user);
//     } else {
//         echo "No user found with username: " . htmlspecialchars($testUsername) . "\n";
//     }
// } catch (Exception $e) {
//     // Catch and display any errors
//     echo "An error occurred: " . $e->getMessage();
// }




// $bookController = new BookController();
// $bookController->view();

/*
// Match URIs
$uri = '/user';
$uri = '/user/index';
$uri = '/user/show/1';
$uri = '/';
$uri = '/user/create';
$uri = '/user/update/2';
*/