<?php
session_start();

//Redirect to login page if user is not logged in
function checkLogin() {
    if (!isset($_SESSION['currentUser'])) {
        if (!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) === 'xmlhttprequest') {
            // For AJAX requests, return a JSON response
            echo json_encode(['status' => 'error', 'message' => 'User not logged in']);
            http_response_code(401); // Unauthorized
            exit();
        } else {
            // For regular requests, redirect to the login page
            header("Location: /Fin/user/login");
            exit();
        }
    }
}

?>
