<?php

namespace App\Models;
//require_once(__DIR__ . '/../../config.php');

class User
{
    private $connection;

    public function __construct()
    {
        // Replace these values with your actual database configuration
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

    public function getAllUsers()
    {
        $result = $this->connection->query("SELECT * FROM nguoidungs");
        return $result->fetch_all(MYSQLI_ASSOC);
    }

    public function getUserById($userId)
    {
        $userId = intval($userId);
        $userId = $this->connection->real_escape_string($userId);
        $result = $this->connection->query("SELECT * FROM nguoidungs WHERE mand = '$userId'");

        return $result->fetch_assoc();
    }

    public function getUserByUsername($username)
    {
        $username = $this->connection->real_escape_string($username);
        $result = $this->connection->query("SELECT * FROM nguoidungs WHERE tendangnhap = '$username'");

        return $result->fetch_assoc();
    }

    public function createUser($hoten, $diachi, $sodt, $email, $tendangnhap, $matkhau)
    {
        $hoten = $this->connection->real_escape_string($hoten);
        $diachi = $this->connection->real_escape_string($diachi);
        $sodt = $this->connection->real_escape_string($sodt);
        $email = $this->connection->real_escape_string($email);
        $tendangnhap = $this->connection->real_escape_string($tendangnhap);
        $matkhau = $this->connection->real_escape_string($matkhau);
        $hashedPassword = password_hash($matkhau, PASSWORD_DEFAULT);


        return $this->connection->query("INSERT INTO nguoidungs (hoten, diachi, sodt, email, tendangnhap, matkhau, admin) 
        VALUES ('$hoten','$diachi','$sodt' ,'$email', '$tendangnhap', '$hashedPassword', '0')");
    }

    public function updateUser($mand, $hoten, $diachi, $sodt, $email, $tendangnhap, $matkhau)
    {
        $mand = $this->connection->real_escape_string($mand);
        $hoten = $this->connection->real_escape_string($hoten);
        $diachi = $this->connection->real_escape_string($diachi);
        $sodt = $this->connection->real_escape_string($sodt);
        $email = $this->connection->real_escape_string($email);
        $tendangnhap = $this->connection->real_escape_string($tendangnhap);
        $matkhau = $this->connection->real_escape_string($matkhau);
        $hashedPassword = password_hash($matkhau, PASSWORD_DEFAULT);

        return $this->connection->query("UPDATE nguoidungs 
        SET hoten = '$hoten', diachi = '$diachi', sodt = '$sodt', email = '$email', tendangnhap = '$tendangnhap', matkhau = '$hashedPassword'
        WHERE mand = $mand");
    }

    public function updateUserRole($mand, $newRole)
    {
        $mand = $this->connection->real_escape_string($mand);
        $newRole = $this->connection->real_escape_string($newRole);
        return $this->connection->query("UPDATE nguoidungs set admin = '$newRole' WHERE mand = $mand ");
    }

    public function deleteUser($userId)
    {
        $userId = intval($userId);
        $userId = $this->connection->real_escape_string($userId);
        $this->connection->query("DELETE FROM nguoidungs WHERE mand = $userId");
    }
}
