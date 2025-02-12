<?php ob_start();
session_start();




?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Trang Chủ Admin</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <link href="<?= URLROOT ?>/css/adminpanel.css" rel="stylesheet">
    <script src="<?= URLROOT ?>/public/js/script.js"></script>
</head>

<body>
    <?php if (isset($_SESSION['currentUser'])): ?>
        <h3 class="text-center medium">
            <span class="nav-link">Xin chào admin
                <?= htmlspecialchars($_SESSION['currentUser']['hoten']) ?>!</span>
        </h3>
        <h3 class="text-center medium">
            <span class="nav-link">Chào mừng admin
                <?= htmlspecialchars($_SESSION['currentUser']['hoten']) ?> đến với trang quản lý!</span>
        </h3>
    <?php endif; ?>
</body>

</html>
<?php $content = ob_get_clean(); ?>
<?php include(__DIR__ . '/../../../templates/layout_admin.php'); ?>