<?php
namespace App\Controllers;

use App\Models\User;
class AuthenticationController
{

    public function __construct()
    {

    }

    // public function authenticate() {

    //     if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    //         $username = $_POST['username'];
    //         $password = trim($_POST['password']);

    //         $user = (new User())->getUserByUsername($username);
    //         // if ($user) {
    //         //     die("There is user found with username: " . htmlspecialchars($username));
    //         // }

    //         // if ($user) {
    //         //     if (password_verify($password, $user['matkhau'])) {
    //         //         die("Password is correct");
    //         //     } else {
    //         //         die("Password verification failed. Entered: " . htmlspecialchars($password));
    //         //     }
    //         // }
    //         //var_dump($user);
    //         if ($user && password_verify($password, $user['matkhau'])) {
    //             // User authenticated, save user to session
    //             session_start();
    //             // $_SESSION['test'] = "Session is working.";
    //             // if (!isset($_SESSION['test'])) {
    //             //     die("Session is not persisting.");
    //             // }
    //             $_SESSION['currentUser'] = $user;
    //                // Check user role and redirect accordingly
    //                if ($user['role'] === 'admin') {
    //                 header("Location: ../Lab13/admin/dashboard");
    //             } elseif ($user['role'] === 'customer') {
    //                 header("Location: ../Lab13/");
    //             } else {
    //                 // Handle unknown roles, if necessary
    //                 $_SESSION['flash_message'] = "Role is not recognized.";
    //                 header("Location: ../Lab13/user/signin");
    //             }
    //             exit();
    //         } else {
    //             // Authentication failed, redirect to signin.php
    //              $_SESSION['flash_message'] = "Login has failed";
    //             header("Location: ../Lab13/user/signin");
    //             exit();
    //         }
    //     }


    // }



    public function authenticate()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $username = $_POST['username'];
            $password = trim($_POST['password']); // Ensure no extra spaces



            $user = (new User())->getUserByUsername($username);

            if ($user) {
                // Debugging output for verification
                
                if (password_verify($password, $user['matkhau'])) {
                    session_start();
                    $_SESSION['currentUser'] = $user;

                    // Check user role and redirect
                    if (htmlspecialchars($user['admin']) == 1) {
                        header("Location: ../Fin/admin/dashboard");
                    } elseif (htmlspecialchars($user['admin']) == 0) {
                        header("Location: ../Fin/");
                    } else {
                        $_SESSION['flash_message'] = "Role is not recognized.";
                        header("Location: ../Fin/user/login");
                    }
                    exit();
                } else {
                    $_SESSION['flash_message'] = "Password verification failed.";
                    header("Location: ../Fin/user/login");
                    exit();
                }
            } else {
                $_SESSION['flash_message'] = "User not found.";
                header("Location: ../Fin/user/login");
                exit();
            }
        }
    }

}