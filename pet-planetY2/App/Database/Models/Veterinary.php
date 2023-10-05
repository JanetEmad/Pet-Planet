<?php

namespace App\Database\Models;

use App\Database\Models\Contract\MakeCrud;
use App\Database\Models\Model;

class Veterinary extends Model implements MakeCrud
{
    private $id,
        $user_id,
        $clinic_id;


    public function create(): bool
    {
        $query = "INSERT INTO veterinaries (user_id, clinic_id) 
        
        VALUES (? , ? )";

        $returned_stmt = $this->connect->prepare($query);
        if (!$returned_stmt) {
            return false;
        }

        $returned_stmt->bind_param(
            'ii',
            $this->user_id,
            $this->clinic_id
        );

        return $returned_stmt->execute();
    }

    public function read(): array
    {
        $query = "SELECT c.*,a.address
        FROM clinics AS c
        JOIN veterinaries AS v ON v.clinic_id = c.id
        JOIN users As u ON u.id = v.user_id
        JOIN addresses As a ON c.address_id = a.id
        WHERE u.id=?";

        $returned_stmt = $this->connect->prepare($query);
        $returned_stmt->bind_param('i',  $this->user_id);
        $returned_stmt->execute();

        $result = $returned_stmt->get_result();
        $clinics = $result->fetch_all(MYSQLI_ASSOC);
        return $clinics;
    }

    function fetchVetDataFromDatabaseByUserId($userId)
    {
        $query = "SELECT * FROM veterinaries WHERE user_id = ?";
        $stmt = $this->connect->prepare($query);
        $stmt->bind_param("i", $userId);
        $stmt->execute();

        $result = $stmt->get_result();
        $vetData = $result->fetch_assoc();

        $stmt->close();
        $this->connect->close();

        return $vetData;
    }


    public function update(): bool
    {
        $query = "UPDATE veterinaries SET  clinic_id = ?, user_id = ? WHERE id = ?";

        $stmt = $this->connect->prepare($query);
        if (!$stmt) {
            return false;
        }

        $stmt->bind_param('iii',  $this->clinic_id, $this->user_id, $this->id);

        return $stmt->execute();
    }

    public function delete(): bool
    {
        # code...
    }


    /**
     * Get the value of id
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set the value of id
     *
     * @return  self
     */
    public function setId($id)
    {
        $this->id = $id;

        return $this;
    }


    /**
     * Get the value of user_id
     */
    public function getUser_id()
    {
        return $this->user_id;
    }

    /**
     * Set the value of user_id
     *
     * @return  self
     */
    public function setUser_id($user_id)
    {
        $this->user_id = $user_id;

        return $this;
    }

    /**
     * Get the value of clinic_id
     */
    public function getClinic_id()
    {
        return $this->clinic_id;
    }

    /**
     * Set the value of clinic_id
     *
     * @return  self
     */
    public function setClinic_id($clinic_id)
    {
        $this->clinic_id = $clinic_id;

        return $this;
    }

    function readO(): \mysqli_result
    {
        #code
    }
}
