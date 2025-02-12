<?php ob_start(); ?>


<style>
    .form-label {
        color: black;
    }
    .btn {
        margin-top: 50px;
    }
</style>


<div class="container d-flex justify-content-center align-items-center vh-100">
    <form class="form-signin p-4 border rounded shadow" action="<?= URLROOT ?>/auth/validate" method="post"
        style="max-width: 50%; width: 100%; background-color:white;">
        <h2 class="text-center mb-4" style="color: black;">Log In</h2>

        <div class="mb-3">
            <label for="username" class="form-label">Username:</label>
            <input type="text" id="username" name="username" class="form-control" required>
        </div>

        <div class="mb-3">
            <label for="password" class="form-label">Password:</label>
            <input type="password" id="password" name="password" class="form-control" required>
        </div>
        <div class="mb-3">
            <a href="<?=URLROOT?>/user/signin">Chưa có tài khoản? Đăng ký</a>
        </div>
        <div class="text-center">
            <input type="submit" value="Đăng nhập" class="btn btn-primary w-100">
        </div>
    </form>
</div>

<?php
session_start();

if (isset($_SESSION['flash_message'])) {
    $message = $_SESSION['flash_message'];
    unset($_SESSION['flash_message']);
    echo $message . '<br>';
}
?>
<?php $content = ob_get_clean(); ?>
<?php include(__DIR__ . '/../../../templates/layout.php'); ?>