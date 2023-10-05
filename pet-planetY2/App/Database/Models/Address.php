<?php

namespace App\Database\Models;

use App\Database\Models\Contract\MakeCrud;
use App\Database\Models\Model;

class Address extends Model implements MakeCrud
{
    private $id,
        $address,
        $lat,
        $lng,
        $user_id;


    public function create(): bool
    {
        $query = "INSERT INTO addresses (address ,lat, lng, user_id) 
        
        VALUES (? , ? , ? , ? )";

        $returned_stmt = $this->connect->prepare($query);
        if (!$returned_stmt) {
            return false;
        }

        $returned_stmt->bind_param(
            'sddi',
            $this->address,
            $this->lat,
            $this->lng,
            $this->user_id
        );

        return $returned_stmt->execute();
    }

    public function read(): array
    {
        # code...
    }

    public function update(): bool
    {
        # code...
    }

    public function delete(): bool
    {
        # code...
    }

    public function getAddressInfo()
    {
        $query = "SELECT * FROM addresses WHERE address = ? ";

        $returned_stmt = $this->connect->prepare($query);
        if (!$returned_stmt) {
            return false;
        }

        $returned_stmt->bind_param('s', $this->address);
        $returned_stmt->execute();
        return $returned_stmt->get_result();
    }

    public function getAddressInfoByUserId()
    {
        $query = "SELECT * FROM addresses WHERE user_id = ? ";

        $returned_stmt = $this->connect->prepare($query);
        if (!$returned_stmt) {
            return false;
        }

        $returned_stmt->bind_param('i', $this->user_id);
        $returned_stmt->execute();
        $result = $returned_stmt->get_result();

        if ($result->num_rows === 0) {
            return null; // No rows found
        }

        $address = $result->fetch_object(); // Fetch the first row as an object
        $result->free_result(); // Free the result set
        return $address;
    }

    public function updateById($id, $address)
    {
        $query = "UPDATE addresses SET address = ? WHERE id = ?";
        $stmt = $this->connect->prepare($query);
        if (!$stmt) {
            return false;
        }

        $stmt->bind_param('si', $address, $id);
        $result = $stmt->execute();
        $stmt->close();

        return $result;
    }

    public function getAddressInfoById()
    {
        $query = "SELECT * FROM addresses WHERE id = ? ";

        $returned_stmt = $this->connect->prepare($query);
        if (!$returned_stmt) {
            return false;
        }
        $returned_stmt->bind_param('i', $this->id);
        $returned_stmt->execute();
        $result = $returned_stmt->get_result();

        if ($result->num_rows === 0) {
            return null; // No rows found
        }

        $address = $result->fetch_object(); // Fetch the first row as an object
        $result->free_result(); // Free the result set
        return $address;
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
     * Get the value of address
     */
    public function getAddress()
    {
        return $this->address;
    }

    /**
     * Set the value of address
     *
     * @return  self
     */
    public function setAddress($address)
    {
        $this->address = $address;

        return $this;
    }

    /**
     * Get the value of lat
     */
    public function getLat()
    {
        return $this->lat;
    }

    /**
     * Set the value of lat
     *
     * @return  self
     */
    public function setLat($lat)
    {
        $this->lat = $lat;

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
     * Get the value of lng
     */
    public function getLng()
    {
        return $this->lng;
    }

    /**
     * Set the value of lng
     *
     * @return  self
     */
    public function setLng($lng)
    {
        $this->lng = $lng;

        return $this;
    }


    function readO(): \mysqli_result
    {
        #code
    }
}
