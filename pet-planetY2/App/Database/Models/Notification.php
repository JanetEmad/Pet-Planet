<?php

namespace App\Database\Models;

use App\Database\Models\Contract\MakeCrud;
use App\Database\Models\Model;

class Notification extends Model implements MakeCrud
{
	private $id,
		$content,
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

	public function create(): bool
	{
		$query = "INSERT INTO notifications(content,user_id,date) VALUES (? , ?, ?)";

		$returned_stmt = $this->connect->prepare($query);

		if (!$returned_stmt) {
			return false;
		}

		$returned_stmt->bind_param('sis', $this->content, $this->user_id, $this->date);

		return $returned_stmt->execute();
	}
	public function readO(): \mysqli_result
	{
		$query = "SELECT * FROM notifications where user_id = ? ORDER BY id ASC";
		$stmt = $this->connect->prepare($query);
		$stmt->bind_param('i', $this->user_id);
		$stmt->execute();
		return $stmt->get_result();
	}
	function update(): bool
	{
		#code
	}

	function read(): array
	{
		#code
	}

	function delete(): bool
	{
		#code
	}
}
