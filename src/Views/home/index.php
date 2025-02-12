<?php $title = 'Books'; ?>

<?php ob_start();
session_start();
?>
<div class="container mt-4">
    <h1 class="text-center mb-4"><?= htmlspecialchars($title); ?></h1>

    <!-- Search Bar Form -->
    <form method="get" action="" class="d-flex mb-4 search-form">
        <input type="text" name="search" class="form-control me-2" placeholder="Search by book name or author"
            value="<?= htmlspecialchars($_GET['search'] ?? '') ?>">
        <select name="searchBy" class="form-select me-2 search-dropdown">
            <option value="tensach" <?= (isset($_GET['searchBy']) && $_GET['searchBy'] == 'tensach') ? 'selected' : '' ?>>
                Book Name</option>
            <option value="tacgia" <?= (isset($_GET['searchBy']) && $_GET['searchBy'] == 'tacgia') ? 'selected' : '' ?>>
                Author Name</option>
        </select>
        <button type="submit" class="btn btn-primary">Search</button>
    </form>

    <!-- Filter Form -->
    <form method="get" action="" class="d-flex align-items-center mb-4 filter-form">
        <label for="category" class="form-label me-2 mb-0">Filter by Category</label>
        <select class="form-select form-select-sm" id="category" name="category" onchange="this.form.submit()">
            <option value="">All Categories</option>
            <?php foreach ($categories as $category): ?>
                <option value="<?= htmlspecialchars($category['id']); ?>" <?= isset($_GET['category']) && $_GET['category'] == $category['id'] ? 'selected' : ''; ?>>
                    <?= htmlspecialchars($category['name']); ?>
                </option>
            <?php endforeach; ?>
        </select>
    </form>

    <?php if (empty($books)): ?>
        <!-- Display a message if no books are found -->
        <div class="alert alert-warning text-center">
            No books found. Try searching with a different term.
        </div>
    <?php else: ?>
        <div class="row mt-4">
            <?php foreach ($books as $book): ?>
                <div class="col-md-4 mb-4">
                    <div class="card h-100">
                        <img src="<?= 'http://localhost/Fin/' . htmlspecialchars($book->getAnh()); ?>"
                            class="book-image card-img-top" alt="<?= htmlspecialchars($book->getTensach()); ?>">
                        <div class="card-body">
                            <h5 class="card-title"><?= htmlspecialchars($book->getTensach()); ?></h5>
                            <p class="card-text"><strong>Author:</strong> <?= htmlspecialchars($book->getTacgia()); ?></p>
                            <p class="card-text"><strong>Price:</strong> <?= htmlspecialchars($book->getGia()); ?> VND</p>
                            <p class="card-text"><strong>Quantity:</strong> <?= htmlspecialchars($book->getSoluong()); ?></p>
                            <p class="card-text"><strong>Category:</strong> <?= htmlspecialchars($book->getMaloai()); ?></p>
                            <p class="card-text"><strong>Published Date:</strong>
                                <?= htmlspecialchars($book->getNgayxuatban()); ?></p>
                        </div>
                        <div class="card-footer bg-transparent border-0">
                            <a href="#" class="shopping-cart-icon" data-book-id="<?= htmlspecialchars($book->getMasach()); ?>">
                                <i class="fas fa-cart-plus fa-2x"></i>
                            </a>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>
</div>

<script>
    document.querySelectorAll('.shopping-cart-icon').forEach(function (icon) {
        icon.addEventListener('click', function (event) {
            event.preventDefault();

            const bookId = this.getAttribute('data-book-id');

            fetch('/Fin/src/cart-handling/add_to_cart.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                },
                body: JSON.stringify({ bookId: bookId }),
            })
                .then(response => {
                    if (response.redirected) {
                        // If the server redirects, navigate to the redirected URL
                        window.location.href = response.url;
                    } else {
                        return response.json(); // Parse JSON if no redirect
                    }
                })
                .then(data => {
                    if (data && data.status === 'success') {
                        alert('Book added to cart successfully!');
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                });
        });
    });

</script>

<?php $content = ob_get_clean(); ?>

<?php include(__DIR__ . '/../../../templates/layout.php'); ?>