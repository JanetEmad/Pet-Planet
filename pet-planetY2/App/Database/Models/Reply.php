<?php

namespace App\Database\Models;

use App\Database\Models\Contract\MakeCrud;
use App\Database\Models\Model;

class Reply extends Model implements MakeCrud
{
	private $id,
		$content,
		$comment_id,
		$username,
		$user_id,
		$date;


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

	/**
	 * @return mixed
	 */
	public function getContent()
	{
		return $this->content;
	}

	/**
	 * @param mixed $content 
	 * @return self
	 */
	public function setContent($content): self
	{
		$this->content = $content;
		return $this;
	}

	/**
	 * @return mixed
	 */
	public function getComment_id()
	{
		return $this->comment_id;
	}

	/**
	 * @param mixed $comment_id 
	 * @return self
	 */
	public function setComment_id($comment_id): self
	{
		$this->comment_id = $comment_id;
		return $this;
	}

	/**
	 * @return mixed
	 */
	public function getUsername()
	{
		return $this->username;
	}

	/**
	 * @param mixed $username 
	 * @return self
	 */
	public function setUsername($username): self
	{
		$this->username = $username;
		return $this;
	}

	/**
	 * @return mixed
	 */
	public function getUser_id()
	{
		return $this->user_id;
	}

	/**
	 * @param mixed $user_id 
	 * @return self
	 */
	public function setUser_id($user_id): self
	{
		$this->user_id = $user_id;
		return $this;
	}

	public function create(): bool
	{
		$query = "INSERT INTO replies(content,date,username,user_id,comment_id) VALUES (? , ?, ?, ?, ?)";

		$returned_stmt = $this->connect->prepare($query);

		if (!$returned_stmt) {
			return false;
		}

		$returned_stmt->bind_param('sssii', $this->content, $this->date, $this->username, $this->user_id, $this->comment_id);

		return $returned_stmt->execute();
	}

	public function  readO(): \mysqli_result
	{
		$query = "SELECT id,username, content , user_id,date FROM replies WHERE report=0 AND comment_id = ?";
		$stmt = $this->connect->prepare($query);
		$stmt->bind_param('i', $this->comment_id);
		$stmt->execute();
		return $stmt->get_result();
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
		$query = "SELECT id,content,username,date FROM replies WHERE id = ?";
		$stmt = $this->connect->prepare($query);
		$stmt->bind_param('i', $this->id);
		$stmt->execute();
		return $stmt->get_result();
	}
	public function deleteReply(): bool
	{
		$query = "DELETE FROM replies WHERE id = ?";
		$returned_stmt = $this->connect->prepare($query);
		if (!$returned_stmt) {
			return false;
		}
		$returned_stmt->bind_param('i', $this->id);
		return $returned_stmt->execute();
	}


	public function updateReplyInfo(): bool
	{
		$query = "UPDATE replies SET content = ?,date = ? WHERE id = ?";
		$returned_stmt = $this->connect->prepare($query);
		if (!$returned_stmt) {
			return false;
		}
		$returned_stmt->bind_param('ssi', $this->content, $this->date, $this->id);
		return $returned_stmt->execute();
	}

	public function reportReply(): bool
	{
		$query = "UPDATE replies SET report = 1 WHERE id = ?";
		$returned_stmt = $this->connect->prepare($query);
		if (!$returned_stmt) {
			return false;
		}
		$returned_stmt->bind_param('i', $this->id);
		return $returned_stmt->execute();
	}

	public function getReplyReports()
	{
		return $this->connect->query("SELECT id,username, content , user_id,date FROM replies WHERE report=1");
	}


	/**
	 * @return mixed
	 */
	public function getDate()
	{
		return $this->date;
	}

	/**
	 * @param mixed $date 
	 * @return self
	 */
	public function setDate($date): self
	{
		$this->date = $date;
		return $this;
	}

	public function removeReport(): bool
	{
		$query = "UPDATE replies SET report = 0 WHERE id = ?";
		$returned_stmt = $this->connect->prepare($query);
		if (!$returned_stmt) {
			return false;
		}
		$returned_stmt->bind_param('i', $this->id);
		return $returned_stmt->execute();
	}
}
