<?php

namespace App\Controllers;

use App\Models\Book;
use App\Controller;
use App\Models\BookAdmin;

class BookAdminController extends Controller
{
    private $bookModel;


    public function __construct()
    {
        $this->bookModel = new BookAdmin();
    }

    public function index()
    {
        // Fetch all books and display them in a view
        $books = $this->bookModel->getAllBooks();

        $this->render('books/book-list', ['books' => $books]);
    }

    public function show($bookId)
    {
        // Fetch a single book by ID and display in a view
        $book = $this->bookModel->getBookById($bookId);

        $this->render('books\book-form', ['book' => $book]);
    }

    public function searchBooks($keyword = null)
    {
        // Lấy từ khóa và phương thức tìm kiếm từ query string
        $keyword = $keyword ?? ($_GET['search'] ?? '');
        $searchBy = $_GET['searchBy'] ?? 'tensach';  // Mặc định là tìm theo tên sách

        if ($_SERVER['REQUEST_METHOD'] === 'GET') {
            // Kiểm tra nếu từ khóa tìm kiếm không trống
            if ($keyword) {
                // Gọi model để tìm kiếm sách theo tên sách hoặc tác giả
                $books = $this->bookModel->searchBooks($keyword, $searchBy);
            } else {
                // Nếu không có từ khóa tìm kiếm, trả về danh sách tất cả sách
                $books = $this->bookModel->getAllBooks();
            }

            // Kiểm tra nếu không có kết quả tìm kiếm
            $message = empty($books) ? 'Không tìm thấy kết quả' : '';

            // Hiển thị kết quả tìm kiếm hoặc thông báo không có kết quả
            $this->render('books/book-list', [
                'books' => $books,
                'message' => $message
            ]);
        } else {
            // Nếu không có từ khóa tìm kiếm, trả về danh sách tất cả sách
            $this->index();
        }
    }

    private function getAllGenres()
    {
        // Query the database to get all genres
        $query = "SELECT maloai, tenloai FROM loai";

        // Sử dụng prepare và thực hiện câu lệnh
        $stmt = $this->bookModel->connection->prepare($query);
        $stmt->execute();

        // Lấy kết quả và trả về dưới dạng mảng
        $result = $stmt->get_result(); // Dùng get_result() để lấy kết quả
        return $result->fetch_all(MYSQLI_ASSOC); // Dùng fetch_all() với kết quả MySQLi
    }

    public function create()
    {
        // Handle form submission to create a new book
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Retrieve form data
            $tensach = $_POST['tensach'];
            $gia = $_POST['gia'];
            $soluong = $_POST['soluong'];
            $tacgia = $_POST['tacgia'];
            $maloai = $_POST['maloai'];
            $ngayxuatban = $_POST['ngayxuatban'];
            $anh = $_FILES['anh']['name'];

            // Lưu ảnh vào thư mục public
            $targetDir = "<?=URLROOT?>/";
            $targetFile = $targetDir . basename($anh);
            move_uploaded_file($_FILES["anh"]["tmp_name"], $targetFile);

            // Call the model to create a new book
            $this->bookModel->createBook($tensach, $gia, $soluong, $tacgia, $maloai, $ngayxuatban, $anh);

            // Redirect về trang danh sách sách
            header('Location: /book-list');
            exit();
        }

        // Fetch all genres and display the form to create a new book
        $genres = $this->getAllGenres();
        $this->render('books\book-form', ['book' => [], 'genres' => $genres]);
    }

    public function update($bookId)
    {
        // Handle form submission to update a book
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Retrieve form data
            $tensach = $_POST['tensach'];
            $gia = $_POST['gia'];
            $soluong = $_POST['soluong'];
            $tacgia = $_POST['tacgia'];
            $maloai = $_POST['maloai'];
            $ngayxuatban = $_POST['ngayxuatban'] ?? null;
            // Giữ nguyên ảnh khi bấm Edit
            $anh = $_FILES['anh']['name'] ? $_FILES['anh']['name'] : $_POST['existing_image'];

            // Lưu ảnh nếu có thay đổi
            if ($_FILES['anh']['name']) {
                $targetDir = "<?=URLROOT?>/";
                $targetFile = $targetDir . basename($anh);
                move_uploaded_file($_FILES["anh"]["tmp_name"], $targetFile);
            }


            // Cập nhật sách qua model
            $this->bookModel->updateBook($bookId, $tensach, $gia, $soluong, $tacgia, $maloai, $anh, $ngayxuatban);

            // Redirect về trang danh sách sách
            header('Location: /book-list');
            exit();
        }

        // Fetch the book data and display the form to update
        $book = $this->bookModel->getBookById($bookId);
        // Lấy tất cả thể loại từ cơ sở dữ liệu
        $genres = $this->bookModel->getGenres();

        $this->render('books/book-form', ['book' => $book, 'genres' => $genres]);
    }
    public function getGenres()
    {
        $stmt = $this->bookModel->connection->query("SELECT maloai, tenloai FROM loai");
        return $stmt->fetch_all(MYSQLI_ASSOC);
    }

    public function delete($bookId)
    {
        // Call the model to delete the book
        $this->bookModel->deleteBook($bookId);

        // Redirect to the book index page
        header('Location: books/book-list');
    }
}
