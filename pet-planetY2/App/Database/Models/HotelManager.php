<?php

namespace App\Database\Models;

use App\Database\Models\Contract\MakeCrud;
use App\Database\Models\Model;

class HotelManager extends Model implements MakeCrud
{
    private $id,
        $user_id,
        $hotel_id;


    public function create(): bool
    {
        $query = "INSERT INTO hotelmanagers (user_id, hotel_id) 
        
        VALUES (? , ? )";

        $returned_stmt = $this->connect->prepare($query);
        if (!$returned_stmt) {
            return false;
        }

        $returned_stmt->bind_param(
            'ii',
            $this->user_id,
            $this->hotel_id
        );

        return $returned_stmt->execute();
    }

    public function read(): array
    {
        $query = "SELECT h.*,a.address
        FROM hotels AS h
        JOIN hotelmanagers AS hm ON hm.hotel_id = h.id
        JOIN users As u ON u.id = hm.user_id
        JOIN addresses As a ON h.address_id = a.id
        WHERE u.id=?";

        $returned_stmt = $this->connect->prepare($query);
        $returned_stmt->bind_param("i", $this->user_id);

        $returned_stmt->execute();

        $result = $returned_stmt->get_result();
        $hotels = $result->fetch_all(MYSQLI_ASSOC);
        return $hotels;
    }

    function fetchManagerDataFromDatabaseByUserId($userId)
    {
        $query = "SELECT * FROM hotelmanagers WHERE user_id = ?";
        $stmt = $this->connect->prepare($query);
        $stmt->bind_param("i", $userId);
        $stmt->execute();

        $result = $stmt->get_result();
        $managerData = $result->fetch_assoc();

        $stmt->close();
        $this->connect->close();

        return $managerData;
    }

    public function update(): bool
    {
        $query = "UPDATE hotelmanagers SET  hotel_id = ?, user_id = ? WHERE id = ?";

        $stmt = $this->connect->prepare($query);
        if (!$stmt) {
            return false;
        }

        $stmt->bind_param('iii',  $this->hotel_id, $this->user_id, $this->id);

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
     * Get the value of hotel_id
     */
    public function getHotel_id()
    {
        return $this->hotel_id;
    }

    /**
     * Set the value of hotel_id
     *
     * @return  self
     */
    public function setHotel_id($hotel_id)
    {
        $this->hotel_id = $hotel_id;

        return $this;
    }

    function readO(): \mysqli_result
    {
        #code
    }
}
