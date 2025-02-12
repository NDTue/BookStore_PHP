<?php

namespace App\Controllers;

use App\Controller;

class AdminController extends Controller {


    // Đảm bảo phương thức này tồn tại và được gọi đúng
    public function dashboard() {
        // Gọi view trang chủ admin
        $this->viewPage('admin/dashboard');  // Tên file view là 'dashboard.php'
    }
}
