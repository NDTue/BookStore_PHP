<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- Include Bootstrap CSS via CDN -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Include Font Awesome CSS via CDN -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <!-- Include Custom CSS -->
    <link href="/Fin/css/styles.css" rel="stylesheet">
    <title>Book Store App</title>
    <style>
        /* Ensure the footer stays at the bottom */
        html,
        body {
            height: 100%;
            /* Make sure the full height of the viewport is used */
            margin: 0;
        }

        body {
            display: flex;
            flex-direction: column;
            /* Stack elements vertically */
        }

        main {
            flex: 1;
            /* Allow main content to grow and take available space */
        }

        footer {
            padding: 1rem 0;
            text-align: center;
        }
    </style>
</head>

<body>
    <nav class="navbar navbar-expand-lg">
        <div class="container">
            <a class="navbar-brand" href="#">Book Store</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
                aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav me-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="<?= URLROOT ?>">Home</a>
                    </li>
                    <?php if(isset($_SESSION['currentUser']) && $_SESSION['currentUser']['admin'] == 1):?>
                        <li class="nav-item">
                            <a class="nav-link" href="<?= URLROOT?>/admin/dashboard" >Dashboard</a>
                        </li>
                    <?php endif; ?>
                </ul>
                <ul class="navbar-nav">
                    <?php if (isset($_SESSION['currentUser'])): ?>
                        <li class="nav-item">
                            <span class="nav-link">Xin chào
                                <?= htmlspecialchars($_SESSION['currentUser']['hoten']) ?>!</span>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="<?= URLROOT ?>/user/logout">Đăng Xuất</a>
                        </li>
                    <?php else: ?>
                        <li class="nav-item">
                            <a class="nav-link" href="<?= URLROOT ?>/user/login">Đăng Nhập</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="<?= URLROOT ?>/user/signin">Đăng Ký</a>
                        </li>
                    <?php endif; ?>
                    <li class="nav-item">
                        <a class="nav-link" href="<?= URLROOT ?>/src/Views/cart/cart.php">
                            <i class="fas fa-shopping-basket fa-lg"></i>
                        </a>
                    </li>
                </ul>

            </div>
        </div>
    </nav>

    <main class="container mt-3">
        <?= $content ?>
    </main>

    <footer class="py-4">
        <div class="container text-center">
            <p>&copy; 2024 Book Store. All rights reserved.</p>
        </div>
    </footer>

    <!-- Include Bootstrap JS via CDN (required for Bootstrap JavaScript features) -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>