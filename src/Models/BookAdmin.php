<?php

namespace App\Models;

use DateTime;

class BookAdmin
{
    public $connection;

    public function __construct()
    {
        // Replace these with your actual database configuration constants
        $host = DB_HOST;
        $username = DB_USER;
        $password = DB_PASSWORD;
        $database = DB_NAME;

        $this->connection = new \mysqli($host, $username, $password, $database);

        // Check connection
        if ($this->connection->connect_error) {
            die("Connection failed: " . $this->connection->connect_error);
        }
    }

    public function getAllBooks()
    {
        $query = "SELECT sach.*, loai.tenloai 
              FROM sach JOIN loai ON sach.maloai = loai.maloai";

        $result = $this->connection->query($query);

        return $result->fetch_all(MYSQLI_ASSOC);
    }

    public function getBookById($bookId)
    {
        $bookId = $this->connection->real_escape_string($bookId);
        $result = $this->connection->query("SELECT * FROM sach WHERE masach = '$bookId'");

        return $result->fetch_assoc();
    }

    public function getGenres()
    {
        // Truy vấn các thể loại từ cơ sở dữ liệu
        $stmt = $this->connection->query("SELECT maloai, tenloai FROM loai");
        return $stmt->fetch_all(MYSQLI_ASSOC); // Nếu sử dụng MySQLi
    }

    public function searchBooks($keyword, $searchBy)
    {
        // Thêm ký tự đại diện vào từ khóa
        $keyword = '%' . $this->connection->real_escape_string($keyword) . '%';

        // Kiểm tra xem tìm kiếm theo trường nào (tên sách hoặc tác giả)
        if ($searchBy == 'tensach') {
            $query = "SELECT sach.*, loai.tenloai FROM sach 
            LEFT JOIN loai ON sach.maloai = loai.maloai
            WHERE tensach LIKE ?";
        } elseif ($searchBy == 'tacgia') {
            $query = "SELECT sach.*, loai.tenloai FROM sach 
            LEFT JOIN loai ON sach.maloai = loai.maloai WHERE tacgia LIKE ?";
        } else {
            // Nếu không có giá trị hợp lệ, mặc định tìm kiếm theo tên sách
            $query = "SELECT sach.*, loai.tenloai FROM sach 
            LEFT JOIN loai ON sach.maloai = loai.maloai tensach LIKE ?";
        }

        // Sử dụng prepared statement để bảo mật truy vấn
        $stmt = $this->connection->prepare($query);
        $stmt->bind_param("s", $keyword);
        $stmt->execute();

        $result = $stmt->get_result();

        // Chuyển đổi kết quả thành mảng
        return $result->fetch_all(MYSQLI_ASSOC);
    }

    public function createBook($tensach, $gia, $soluong, $tacgia, $maloai, $ngayxuatban, $anh)
    {
        $tensach = $this->connection->real_escape_string($tensach);
        $gia = $this->connection->real_escape_string($gia);
        $soluong = $this->connection->real_escape_string($soluong);
        $tacgia = $this->connection->real_escape_string($tacgia);
        $maloai = $this->connection->real_escape_string($maloai);
        $anh = 'image_anh/' . $this->connection->real_escape_string($anh);

        // Prepare the base query
        $query = "INSERT INTO sach (tensach, gia, soluong, tacgia, maloai, anh";

        // Add ngayxuatban column if it's not empty
        if (!empty($ngayxuatban)) {
            $ngayxuatban = $this->connection->real_escape_string($ngayxuatban);
            $query .= ", ngayxuatban";
        }

        $query .= ") VALUES ('$tensach', '$gia', '$soluong', '$tacgia', '$maloai', '$anh'";

        // Add ngayxuatban value if it's not empty
        if (!empty($ngayxuatban)) {
            $query .= ", '$ngayxuatban'";
        }

        $query .= ")";

        // Execute the query
        if (!$this->connection->query($query)) {
            die('Error: ' . $this->connection->error);
        }

        header('Location: index.php');
        exit();
    }


    public function updateBook($bookId, $tensach, $gia, $soluong, $tacgia, $maloai, $anh, $ngayxuatban = null)
    {
        $bookId = $this->connection->real_escape_string($bookId);
        $tensach = $this->connection->real_escape_string($tensach);
        $gia = $this->connection->real_escape_string($gia);
        $soluong = $this->connection->real_escape_string($soluong);
        $tacgia = $this->connection->real_escape_string($tacgia);
        $maloai = $this->connection->real_escape_string($maloai);
        // $anh = $this->connection->real_escape_string($anh);
        $anh = $this->connection->real_escape_string($anh);

        // $this->connection->query("UPDATE sach 
        //                           SET tensach='$tensach', gia='$gia', soluong='$soluong', tacgia='$tacgia', maloai='$maloai', anh='$anh' 
        //                           WHERE masach='$bookId'");
        $query = "UPDATE sach SET 
              tensach='$tensach', gia='$gia', soluong='$soluong', tacgia='$tacgia', maloai='$maloai', anh='$anh'";

        // Chỉ cập nhật ngày xuất bản nếu có giá trị
        if (!empty($ngayxuatban)) {
            $ngayxuatban = $this->connection->real_escape_string($ngayxuatban);
            $query .= ", ngayxuatban='$ngayxuatban'";
        }

        $query .= " WHERE masach='$bookId'";

        $this->connection->query($query);
        header('Location: index.php');
        exit();
    }

    public function deleteBook($bookId)
    {
        $bookId = $this->connection->real_escape_string($bookId);
        $this->connection->query("DELETE FROM sach WHERE masach='$bookId'");
    }
}
