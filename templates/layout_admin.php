<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- Include Bootstrap CSS via CDN -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="<?= URLROOT ?>/public/css/adminpanel.css" rel="stylesheet">

    <title>Layout</title>
    </style> 

</head>

<body class="layout-body">
    <div class="sidebar" id="sidebar">
        <div class="sidebar-header">
            <span class="menu-toggle" onclick="toggleSidebar()">&#9776;</span>
            <h1>Admin Panel</h1>
        </div>
            <ul class="menu-list">
                <li><a href="<?= URLROOT ?>/admin/dashboard/" class="hidden">Dashboard</a></li> <!-- Thêm liên kết tới trang chủ -->
                <li><a href="<?= URLROOT ?>/user/user-list/" class="hidden">Danh sách người dùng</a></li>
                <li><a href="<?= URLROOT ?>/book/book-list/" class="hidden">Danh sách sách</a></li>
                <li><a href="<?= URLROOT ?>" class="hidden">Trang bán hàng</a></li>
        </ul>

    </div>
    
    <div class="layout-content">
        <?= $content ?>
    </div>
    <script src="<?= URLROOT ?>/public/js/script.js"></script>

</body>

</html>