<?php

namespace App\Models;
//require_once(__DIR__ . '/../../config.php');

class Post
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

    public function getAllPosts()
    {
        $result = $this->connection->query("SELECT * FROM post");
        return $result->fetch_all(MYSQLI_ASSOC);
    }

    public function getPostById($postId)
    {
        $postId = $this->connection->real_escape_string($postId);
        $result = $this->connection->query("SELECT * FROM post WHERE id = $postId");

        return $result->fetch_assoc();
    }

    public function createPost($title, $content)
    {
        $title = $this->connection->real_escape_string($title);
        $content = $this->connection->real_escape_string($content);

        $this->connection->query("INSERT INTO post (title, content) VALUES ('$title', '$content')");
        
        // Redirect to the index page after creating post
        header('Location: /Lab13/post/index');
    }

    public function updatePost($postId, $title, $content)
    {
        $postId = $this->connection->real_escape_string($postId);
        $title = $this->connection->real_escape_string($title);
        $content = $this->connection->real_escape_string($content);
        

        $this->connection->query("UPDATE post SET title='$title', content='$content' WHERE id=$postId");
        
        // Redirect to the index page after update
        header('Location: /Lab13/post/index ');
    }

    public function deletePost($postId)
    {
        $postId = $this->connection->real_escape_string($postId);
        $this->connection->query("DELETE FROM post WHERE id=$postId");
    }
}
