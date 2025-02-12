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
    <div class="container mt-5">
        <h1>Book Form</h1>
        <form action="<?= URLROOT ?>/book/<?= isset($book['masach']) ? "update/$book[masach]" : 'create' ?>"
            method="post" enctype="multipart/form-data">
            <div class="mb-3">
                <label for="tensach">Tên sách:</label>
                <input class="form-control" type="text" id="tensach" name="tensach"
                    value="<?= isset($book['tensach']) ? htmlspecialchars($book['tensach']) : '' ?>" required>
            </div>
            <div class="mb-3">
                <label for="tacgia">Tác giả:</label>
                <input class="form-control" type="text" id="tacgia" name="tacgia"
                    value="<?= isset($book['tacgia']) ? htmlspecialchars($book['tacgia']) : '' ?>" required>
            </div>
            <div class="mb-3">
                <label for="theloai">Thể loại:</label>
                <select class="form-select" id="theloai" name="maloai"> <!-- Sử dụng 'maloai' ở đây -->
                    <?php foreach ($genres as $genre): ?>
                        <option value="<?= htmlspecialchars($genre['maloai']) ?>" <?= isset($book['maloai']) && $book['maloai'] == $genre['maloai'] ? 'selected' : '' ?>>
                            <?= htmlspecialchars($genre['tenloai']) ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>

            <div class="mb-3">
                <label for="gia">Giá:</label>
                <input class="form-control" type="number" id="gia" name="gia"
                    value="<?= isset($book['gia']) ? htmlspecialchars($book['gia']) : '' ?>" required>
            </div>
            <div class="mb-3">
                <label for="soluong">Số lượng:</label>
                <input class="form-control" type="number" id="soluong" name="soluong"
                    value="<?= isset($book['soluong']) ? htmlspecialchars($book['soluong']) : '' ?>" required>
            </div>

            <div class="mb-3">
                <label for="ngayxuatban">Ngày xuất bản:</label>
                <input class="form-control" type="date" id="ngayxuatban" name="ngayxuatban"
                    value="<?= isset($book['ngayxuatban']) ? htmlspecialchars($book['ngayxuatban']) : '' ?>">
            </div>

            <div class="mb-3">
                <label for="anh">Hình ảnh:</label>
                <!-- Hiển thị ảnh hiện tại nếu có -->
                <?php if (isset($book['anh']) && $book['anh']): ?>
                    <div>
                        <img src="<?= URLROOT . '/' . htmlspecialchars($book['anh']) ?>" alt="Book Image"
                            class="img-thumbnail" style="max-width: 150px;">
                    </div>
                    <input type="hidden" name="existing_image" value="<?= htmlspecialchars($book['anh']) ?>">
                <?php endif; ?>
                <input class="form-control" type="file" id="anh" name="anh">
            </div>
            <input class="btn btn-primary" type="submit"
                value="<?= isset($book['masach']) ? 'Update Book' : 'Create Book' ?>">
        </form>
        <a href="<?= URLROOT ?>/book/book-list" class="btn btn-secondary mt-3">Return to Book List</a>
    </div>
</body>

</html>
<?php $content = ob_get_clean(); ?>
<?php include(__DIR__ . '/../../../templates/layout_admin.php'); ?>