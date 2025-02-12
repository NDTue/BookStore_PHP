<?php ob_start(); ?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Book List</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <link href="<?= URLROOT ?>/css/adminpanel.css" rel="stylesheet">
    <script src="<?= URLROOT ?>/public/js/script.js"></script>
    <style>
        body {
            background-color: #f4f4f4;
            font-family: 'Roboto', sans-serif;
        }

        .container {
            max-width: 1200px;
        }

        h1 {
            color: #333;
            margin-bottom: 40px;
            font-weight: 700;
        }

        .lead {
            color: #777;
        }

        .btn-success {
            background-color: #28a745;
            border-color: #28a745;
        }

        .btn-success:hover {
            background-color: #218838;
            border-color: #1e7e34;
        }

        .table-responsive {
            background-color: #ffffff;
            border-radius: 10px;
            padding: 20px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            margin-top: 20px;
        }

        .table-striped tbody tr:nth-of-type(odd) {
            background-color: #f9f9f9;
        }

        .table-hover tbody tr:hover {
            background-color: #f1f1f1;
        }

        .table th,
        .table td {
            vertical-align: middle;
            text-align: center;
        }

        .table th {
            background-color: #333;
            color: #fff;
        }

        .action-buttons a {
            margin-right: 5px;
        }

        .table img {
            max-width: 80px;
            height: auto;
            object-fit: cover;
            border-radius: 5px;
            border: 2px solid #ddd;
            transition: transform 0.2s ease-in-out, box-shadow 0.2s ease-in-out;
            cursor: pointer;
        }

        .table img:hover {
            transform: scale(1.1);
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
        }

        @media (max-width: 768px) {
            .table img {
                max-width: 60px;
            }
        }
    </style>
</head>


<body>
    <div class="container mt-3">
        <h1>Danh sách người dùng</h1>
        <a href="<?= URLROOT ?>/user/create">
            <button class="btn btn-success mb-3">Thêm người dùng</button>
        </a>
        <div class="table-responsive">
            <table class="table table-striped table-hover align-middle">
                <thead class="table-dark">
                    <tr>
                        <th>Tên đăng nhập</th>
                        <th>Họ tên</th>
                        <th>Địa chỉ</th>
                        <th>Email</th>
                        <th>Quyền</th>
                        <th>Thao tác</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($users as $user): ?>
                        <tr>
                            <td><?= htmlspecialchars($user['tendangnhap']) ?></td>
                            <td><?= htmlspecialchars($user['hoten']) ?></td>
                            <td><?= htmlspecialchars($user['diachi']) ?></td>
                            <td><?= htmlspecialchars($user['email']) ?></td>
                            <td><?= htmlspecialchars($user['admin']) == 0 ? 'customer' : 'admin' ?></td>
                            <td>
                                <a href="<?= URLROOT ?>/user/toggleRole/<?= $user['mand'] ?>"
                                    onclick="return confirm('Are you sure you want to change this user\'s role?');">
                                    <button
                                        class="btn btn-info"><?= $user['admin'] == 0 ? 'Promote to Admin' : 'Demote to Customer' ?></button>
                                </a>
                                <a href="<?= URLROOT ?>/user/update/<?= $user['mand'] ?>">
                                    <button class="btn btn-warning">Sửa</button>
                                </a>
                                <a href="<?= URLROOT ?>/user/delete/<?= $user['mand'] ?>"
                                    onclick="return confirm('Bạn có chắc chắn muốn xóa người dùng này không?');">
                                    <button class="btn btn-danger">Xóa</button>
                                </a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</body>

</html>
<?php $content = ob_get_clean(); ?>
<?php include(__DIR__ . '/../../../templates/layout_admin.php'); ?>