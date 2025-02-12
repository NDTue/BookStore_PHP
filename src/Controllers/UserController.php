<?php

namespace App\Controllers;

use App\Models\User;
use App\Controller;

class UserController extends Controller
{
    private $userModel;

    public function __construct()
    {
        $this->userModel = new User();
    }

    public function index()
    {
        // Lấy tất cả người dùng và hiển thị danh sách
        $users = $this->userModel->getAllUsers();
        $this->render('users/user-list', ['users' => $users]);
    }

    public function show($userId)
    {
        // Lấy một người dùng cụ thể theo ID
        $user = $this->userModel->getUserById($userId);
        $this->render('users/user-form', ['user' => $user]);
    }

    public function create()
    {
        // Xử lý form tạo người dùng mới
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $this->processForm();
        } else {
            $this->render('users\user-form', ['user' => []]);
        }
    }

    public function registered()
    {
        // Xử lý form tạo người dùng mới
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $this->processRegisteredForm();
        } else {
            $this->render('users\sigin', ['user' => []]);
        }
    }

    private function processRegisteredForm()
    {
        // Retrieve form data
        $hoten = $_POST['hoten'];
        $diachi = $_POST['diachi'];
        $sodt = $_POST['sodt'];
        $email = $_POST['email'];
        $tendangnhap = $_POST['tendangnhap'];
        $matkhau = $_POST['matkhau'];

        // Call the model to create a new user
        $user = $this->userModel->createUser($hoten, $diachi, $sodt, $email, $tendangnhap, $matkhau);

        if ($user) {
            // Redirect to the user list page or show a success message
            header('Location: /Fin/user/login');
            exit();
        } else {
            // Handle the case where the user creation failed
            echo 'User creation failed.';
        }
    }

    private function processForm()
    {
        // Retrieve form data
        $hoten = $_POST['hoten'];
        $diachi = $_POST['diachi'];
        $sodt = $_POST['sodt'];
        $email = $_POST['email'];
        $tendangnhap = $_POST['tendangnhap'];
        $matkhau = $_POST['matkhau'];

        // Call the model to create a new user
        $user = $this->userModel->createUser($hoten, $diachi, $sodt, $email, $tendangnhap, $matkhau);

        if ($user) {
            // Redirect to the user list page or show a success message
            header('Location: /Fin/user');
            exit();
        } else {
            // Handle the case where the user creation failed
            echo 'User creation failed.';
        }
    }

    public function update($userId)
    {
        // Xử lý form cập nhật thông tin người dùng
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $this->processFormUpdate($userId);
        } else {
            $user = $this->userModel->getUserById($userId);
            $this->render('users/user-form', ['user' => $user]);
        }
    }


    private function processFormUpdate($userId)
    {

        // Retrieve form data
        $hoten = $_POST['hoten'];
        $diachi = $_POST['diachi'];
        $sodt = $_POST['sodt'];
        $email = $_POST['email'];
        $tendangnhap = $_POST['tendangnhap'];
        $matkhau = $_POST['matkhau'];

        // Call the model to update the user
        $user = $this->userModel->updateUser($userId, $hoten, $diachi, $sodt, $email, $tendangnhap, $matkhau);

        if ($user) {
            // Redirect to the user list page or show a success message
            header('Location: /Fin/user');
            exit();
        } else {
            // Handle the case where the user creation failed
            echo 'User update failed.';
        }
    }

    public function delete($userId)
    {
        // Xóa người dùng
        $this->userModel->deleteUser($userId);

        // Chuyển về trang danh sách
        header('Location: /Fin/user');
        exit();
    }

    public function login()
    {
        $this->render('users\login', []);
    }

    public function signin()
    {
        $this->render('users\signin', []);
    }


    public function logout()
    {
        // Start the session if not already started
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        // Remove the currentUser session variable
        unset($_SESSION['currentUser']);

        // Destroy the session if no other session variables are needed
        session_destroy();

        // Redirect to the homepage
        header("Location: " . URLROOT);
        exit();
    }

    public function toggleRole($userId)
    {
        // Fetch the current role
        $user = $this->userModel->getUserById($userId);
        if (!$user) {
            die('User not found');
        }

        // Toggle the admin value
        $newRole = $user['admin'] == 0 ? 1 : 0;

        // Update the role in the database
        if ($this->userModel->updateUserRole($userId, $newRole)) {
            // Redirect back with success
            header('Location: ' . URLROOT . '/user/list');
            exit;
        } else {
            die('Error updating role');
        }
    }


}
