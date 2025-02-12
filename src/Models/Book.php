<?php

namespace App\Models;

class Book
{
    private $connection;
    private $masach;
    private $tensach;
    private $gia;
    private $soluong;
    private $tacgia;
    private $maloai;
    private $anh;
    private $ngayxuatban;
    public $quantity; // Add this property

    public function __construct(
        $masach = null,
        $tensach = null,
        $gia = null,
        $soluong = null,
        $tacgia = null,
        $maloai = null,
        $anh = null,
        $ngayxuatban = null
    ) {
        $this->masach = $masach;
        $this->tensach = $tensach;
        $this->gia = $gia;
        $this->soluong = $soluong;
        $this->tacgia = $tacgia;
        $this->maloai = $maloai;
        $this->anh = $anh;
        $this->ngayxuatban = $ngayxuatban;
        $this->quantity = 0; // Initialize quantity

        $host = DB_HOST;
        $username = DB_USER;
        $password = DB_PASSWORD;
        $database = DB_NAME;

        $this->connection = new \mysqli($host, $username, $password, $database);
        $this->connection->set_charset("utf8mb4");

        // Check connection
        if ($this->connection->connect_error) {
            die("Connection failed: " . $this->connection->connect_error);
        }
    }



    // Getter and Setter methods...

    public function getMasach()
    {
        return $this->masach;
    }

    public function getTensach()
    {
        return $this->tensach;
    }

    public function getGia()
    {
        return $this->gia;
    }

    public function getSoluong()
    {
        return $this->soluong;
    }

    public function getTacgia()
    {
        return $this->tacgia;
    }

    public function getMaloai()
    {
        return $this->maloai;
    }

    public function getAnh()
    {
        return $this->anh;
    }

    public function getNgayxuatban()
    {
        return $this->ngayxuatban;
    }

    public function getQuantity()
    {
        return $this->quantity;
    }

    public function setQuantity($quantity)
    {
        $this->quantity = $quantity;
    }

    public function getCategories()
    {
        $result = $this->connection->query("SELECT maloai, tenloai FROM loai");
        if (!$result) {
            error_log("Query failed: " . $this->connection->error);
            return [];
        }
        return $result->fetch_all(MYSQLI_ASSOC); // Fetch all rows as an arrayFFF
    }

    public function getAllBooks()
    {
        $result = $this->connection->query("SELECT * FROM sach");

        $books = [];
        while ($row = $result->fetch_assoc()) {
            $books[] = new Book(
                $row['masach'],
                $row['tensach'],
                $row['gia'],
                $row['soluong'],
                $row['tacgia'],
                $row['maloai'],
                $row['anh'],
                $row['ngayxuatban']
            );
        }

        return $books;
    }

    public function searchBook($keyword, $searchBy)
    {
        $validColumns = ['tensach', 'tacgia']; // Allowed columns for safety
        $column = in_array($searchBy, $validColumns) ? $searchBy : 'tensach'; // Default to 'tensach' if invalid

        $stmt = $this->connection->prepare("SELECT * FROM sach WHERE $column LIKE ?");
        $searchTerm = '%' . $keyword . '%';
        $stmt->bind_param("s", $searchTerm);
        $stmt->execute();
        $result = $stmt->get_result();
        $books = [];
        while ($row = $result->fetch_assoc()) {
            $books[] = new Book(
                $row['masach'],
                $row['tensach'],
                $row['gia'],
                $row['soluong'],
                $row['tacgia'],
                $row['maloai'],
                $row['anh'],
                $row['ngayxuatban']
            );
        }

        return $books;
    }

    public function getBooksByCategory($category)
    {
        $stmt = $this->connection->prepare("SELECT * FROM sach WHERE maloai = ?");
        $stmt->bind_param("s", $category);
        $stmt->execute();
        $result = $stmt->get_result();

        $books = [];
        while ($row = $result->fetch_assoc()) {
            $books[] = new Book(
                $row['masach'],
                $row['tensach'],
                $row['gia'],
                $row['soluong'],
                $row['tacgia'],
                $row['maloai'],
                $row['anh'],
                $row['ngayxuatban']
            );
        }

        return $books;
    }

    public function getBookById($bookId)
    {
        $stmt = $this->connection->prepare("SELECT * FROM sach WHERE masach = ?");
        $stmt->bind_param("s", $bookId);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($row = $result->fetch_assoc()) {
            return new Book(
                $row['masach'],
                $row['tensach'],
                $row['gia'],
                $row['soluong'],
                $row['tacgia'],
                $row['maloai'],
                $row['anh'],
                $row['ngayxuatban']
            );
        }

        return null;
    }
}
?>