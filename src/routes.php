<?php

use App\Controllers\AuthenticationController;
use App\Controllers\BookController;
use App\Router;
use App\Controllers\UserController;
use App\Controllers\AdminController;
use App\Controllers\BookAdminController;


// Usage:
$router = new Router();

// Add routes
$router->addRoute('/\//', [new BookController(), 'view']);
// $router->addRoute('/\//', [new UserController(), 'index']);
//$router->addRoute('/\/user/', [new UserController(), 'userList']);
//$router->addRoute('/\/user\/index/', [new UserController(), 'userList']);

//$router->addRoute('/\/user/', [new UserController(), 'index']);

// User routes: 
// $router->addRoute('/\//', [new UserController(), 'index']);
$router->addRoute('/\/user/', [new UserController(), 'index']);
$router->addRoute('/\/user\/index/', [new UserController(), 'index']);
$router->addRoute('/\/user\/show\/(\d+)/', [new UserController(), 'show']);
$router->addRoute('/\/user\/create\/?/', [new UserController(), 'create']);
$router->addRoute('/\/user\/update\/(\d+)/', [new UserController(), 'update']);
$router->addRoute('/\/user\/toggleRole\/(\d+)/', [new UserController(), 'toggleRole']);
$router->addRoute('/\/user\/delete\/(\d+)/', [new UserController(), 'delete']);
$router->addRoute('/\/user\/registered\/?/', [new UserController(), 'registered']);



// Book routes:
$router->addRoute('/\/book/', [new BookAdminController(), 'index']);
$router->addRoute('/\/book\/index/', [new BookAdminController(), 'index']);
$router->addRoute('/\/book\/show\/(\d+)/', [new BookAdminController(), 'show']);
$router->addRoute('/\/book\/create\/?/', [new BookAdminController(), 'create']);
$router->addRoute('/\/book\/update\/(\d+)/', [new BookAdminController(), 'update']);
$router->addRoute('/\/book\/delete\/(\d+)/', [new BookAdminController(), 'delete']);
$router->addRoute('/\/book\/searchBooks\/?/', [new BookAdminController(), 'searchBooks']);

// Admin routes:
$router->addRoute('/\/admin\/dashboard/', [new AdminController(), 'dashboard']);

// End - Post routes
$router->addRoute('/\/user\/login/', [new UserController(), 'login']);
$router->addRoute('/\/user\/signin/', [new UserController(), 'signin']);
$router->addRoute('/\/auth\/validate/', [new AuthenticationController(), 'authenticate']);
$router->addRoute('/\/user\/logout/', [new UserController(), 'logout']);

