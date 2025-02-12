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
    <div class="content">
        <div class="container mt-4">
            <h1 class="text-center">Books List</h1>
            <div class="d-flex justify-content-between align-items-center mb-3">
                <p class="lead mb-0">Manage your books efficiently.</p>
            </div>
            <!-- Search Bar Form -->
            <form method="get" action="<?= URLROOT ?>/book/searchBooks" class="d-flex mb-4 search-form">
                <input type="text" name="search" class="form-control me-2" placeholder="Search by book name or author"
                    value="<?= htmlspecialchars($_GET['search'] ?? '') ?>" style="flex-grow: 1; max-width: 600px;">
                <select name="searchBy" class="form-select me-2" style="width: 200px;">
                    <option value="tensach" <?= (isset($_GET['searchBy']) && $_GET['searchBy'] == 'tensach') ? 'selected' : '' ?>>Book Name</option>
                    <option value="tacgia" <?= (isset($_GET['searchBy']) && $_GET['searchBy'] == 'tacgia') ? 'selected' : '' ?>>Author Name</option>
                </select>
                <button type="submit" class="btn btn-primary me-3">Search</button>
                <a href="<?= URLROOT ?>/book/create" class="btn btn-success">Add Book</a>
            </form>

            <!-- Display Message -->
            <?php if (!empty($message)): ?>
                <div class="alert alert-warning"><?= htmlspecialchars($message) ?></div>
            <?php endif; ?>

            <div class="table-responsive">
                <table class="table table-striped table-hover align-middle">
                    <thead class="table-dark">
                        <tr>
                            <th>Tên sách</th>
                            <th>Giá</th>
                            <th>Số lượng</th>
                            <th>Tác giả</th>
                            <th>Thể loại</th>
                            <th>Ngày xuất bản</th>
                            <th>Hình ảnh</th>
                            <th>Thao tác</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($books as $book): ?>
                            <tr>
                                <td><?= htmlspecialchars($book['tensach']) ?></td>
                                <td><?= number_format($book['gia'], 0, ',', '.') ?> VNĐ</td>
                                <td><?= htmlspecialchars($book['soluong']) ?></td>
                                <td><?= htmlspecialchars($book['tacgia']) ?></td>
                                <td><?= htmlspecialchars($book['tenloai']) ?></td>
                                <td><?= htmlspecialchars($book['ngayxuatban']) ?></td>
                                <td>
                                    <img src="<?= URLROOT . '/' . htmlspecialchars($book['anh']) ?>"
                                        alt="<?= htmlspecialchars($book['tensach']) ?>" 
                                        onclick="showImageModal('<?= URLROOT . '/' . htmlspecialchars($book['anh']) ?>')"
                                        style="cursor: pointer;">
                                </td>
                                <td>
                                    <div class="action-buttons d-flex justify-content-center">
                                        <a href="<?= URLROOT ?>/book/update/<?= $book['masach'] ?>"
                                            class="btn btn-warning btn-sm">Edit</a>
                                        <a href="<?= URLROOT ?>/book/delete/<?= $book['masach'] ?>" method="POST"
                                            class="btn btn-danger btn-sm"
                                            onclick="return confirm('Are you sure you want to delete this book?');">
                                            Delete
                                        </a>
                                    </div>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Modal để hiển thị ảnh -->
    <div class="modal fade" id="imageModal" tabindex="-1" aria-labelledby="imageModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="imageModalLabel">Book Image</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body text-center">
                    <img id="modalImage" src="" alt="Book Image" class="img-fluid" style="max-height: 500px;">
                </div>
            </div>
        </div>
    </div>

    <script>
        // Hàm hiển thị modal với ảnh được chọn
        function showImageModal(imageUrl) {
            const modalImage = document.getElementById("modalImage");
            modalImage.src = imageUrl; // Đặt URL của ảnh vào modal
            const imageModal = new bootstrap.Modal(document.getElementById("imageModal"));
            imageModal.show(); // Hiển thị modal
        }
    </script>

</body>



</html>
<?php $content = ob_get_clean(); ?>
<?php include(__DIR__ . '/../../../templates/layout_admin.php'); ?>