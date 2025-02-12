<?php ob_start(); 
session_start();

?>
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
    <div class="container mt-5">
        <h1 style="color: white;">Đăng ký</h1>
        <form style="margin-bottom: 50px;color: white;"
            action="<?= URLROOT ?>/user/registered" method="post">
            <div class="mb-3">
                <label for="hoten">Họ và tên:</label>
                <input class="form-control" type="text" id="hoten" name="hoten"
                    value="<?= isset($user['hoten']) ? htmlspecialchars($user['hoten']) : '' ?>" required>
            </div>
            <div class="mb-3">
                <label for="diachi">Địa chỉ:</label>
                <input class="form-control" type="text" id="diachi" name="diachi"
                    value="<?= isset($user['diachi']) ? htmlspecialchars($user['diachi']) : '' ?>">
            </div>
            <div class="mb-3">
                <label for="diachi">Số điện thoại:</label>
                <input class="form-control" type="text" id="sodt" name="sodt"
                    value="<?= isset($user['sodt']) ? htmlspecialchars($user['sodt']) : '' ?>">
            </div>
            <div class="mb-3">
                <label for="email">Email:</label>
                <input class="form-control" type="email" id="email" name="email"
                    value="<?= isset($user['email']) ? htmlspecialchars($user['email']) : '' ?>">
            </div>
            <div class="mb-3">
                <label for="tendangnhap">Tên đăng nhập:</label>
                <input class="form-control" type="text" id="tendangnhap" name="tendangnhap"
                    value="<?= isset($user['tendangnhap']) ? htmlspecialchars($user['tendangnhap']) : '' ?>" required>
            </div>
            <div class="mb-3">
                <label for="matkhau">Mật khẩu:</label>
                <input class="form-control" type="password" id="matkhau" name="matkhau"
                    value="<?= isset($user['matkhau']) ? htmlspecialchars($user['matkhau']) : '' ?>" required>
            </div>
            <div class="d-flex justify-content-center">
                <input class="btn btn-primary" style="width: 25%;" type="submit"
                    value="Đăng ký">
            </div>
        </form>
    </div>
</body>

</html>

<?php $content = ob_get_clean(); ?>
<?php include(__DIR__ . '/../../../templates/layout.php'); ?>