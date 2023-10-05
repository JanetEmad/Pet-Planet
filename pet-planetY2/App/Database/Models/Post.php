<?php

namespace App\Database\Models;

use App\Database\Models\Contract\MakeCrud;
use App\Database\Models\Model;

class Post extends Model implements MakeCrud
{
    private $id,
        $content,
        $date,
        $user_id,
        $username,
        $image;

    public function setContent($content)
    {
        $this->content = $content;

        return $this;
    }

    public function getContent()
    {
        return $this->content;
    }

    public function setDate($date)
    {
        $this->date = $date;

        return $this;
    }

    public function getDate()
    {
        return $this->date;
    }

    public function setUser_id($user_id)
    {
        $this->user_id = $user_id;

        return $this;
    }

    public function getUser_id()
    {
        return $this->user_id;
    }

    /**
     * @return mixed
     */
    public function getUsername()
    {
        return $this->username;
    }

    public function setUsername($username)
    {
        $this->username = $username;
        return $this;
    }
    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param mixed $id 
     * @return self
     */
    public function setId($id): self
    {
        $this->id = $id;
        return $this;
    }

    public function create(): bool
    {
        $query = "INSERT INTO posts(content,date,user_id,username,image) VALUES (? , ?, ?, ?,?)";

        $returned_stmt = $this->connect->prepare($query);

        if (!$returned_stmt) {
            return false;
        }

        $returned_stmt->bind_param('ssiss', $this->content, $this->date, $this->user_id, $this->username, $this->image);

        return $returned_stmt->execute();
    }

    public function readO(): \mysqli_result
    {
        return $this->connect->query("SELECT id,username, content, date , user_id,image FROM posts where report = 0 ORDER BY id DESC");
    }

    function read(): array
    {
        #code
    }

    public function update(): bool
    {
        # code...
    }

    public function delete(): bool
    {
        # code...
    }

    public function find(): \mysqli_result
    {
        $query = "SELECT id,content,username,date,image FROM posts WHERE id = ?";
        $stmt = $this->connect->prepare($query);
        $stmt->bind_param('i', $this->id);
        $stmt->execute();
        return $stmt->get_result();
    }

    public function updatePostInfo(): bool
    {
        $query = "UPDATE posts SET content = ?,date = ? WHERE id = ?";
        $returned_stmt = $this->connect->prepare($query);
        if (!$returned_stmt) {
            return false;
        }
        $returned_stmt->bind_param('ssi', $this->content, $this->date, $this->id);
        return $returned_stmt->execute();
    }

    public function deletePost(): bool
    {
        $query = "DELETE FROM posts WHERE id = ?";
        $returned_stmt = $this->connect->prepare($query);
        if (!$returned_stmt) {
            return false;
        }
        $returned_stmt->bind_param('i', $this->id);
        return $returned_stmt->execute();
    }
    public function reportPost(): bool
    {
        $query = "UPDATE posts SET report = 1 WHERE id = ?";
        $returned_stmt = $this->connect->prepare($query);
        if (!$returned_stmt) {
            return false;
        }
        $returned_stmt->bind_param('i', $this->id);
        return $returned_stmt->execute();
    }

    /**
     * @return mixed
     */
    public function getImage()
    {
        return $this->image;
    }

    /**
     * @param mixed $image 
     * @return self
     */
    public function setImage($image): self
    {
        $this->image = $image;
        return $this;
    }
    public function getPostReports(): \mysqli_result
    {
        return $this->connect->query("SELECT id,username, content, date , user_id,image FROM posts where report = 1 ORDER BY id ASC");
    }

    public function removeReport(): bool
    {
        $query = "UPDATE posts SET report = 0 WHERE id = ?";
        $returned_stmt = $this->connect->prepare($query);
        if (!$returned_stmt) {
            return false;
        }
        $returned_stmt->bind_param('i', $this->id);
        return $returned_stmt->execute();
    }
}
