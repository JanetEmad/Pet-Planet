<?php

namespace App\Database\Models;

use App\Database\Models\Contract\MakeCrud;
use App\Database\Models\Model;

class Hotel_Reservation extends Model implements MakeCrud
{
    private $id,
        $start_at,
        $end_at,
        $type_of_room,
        $hotel_id,
        $user_id,
        $service_provider_id,
        $total_price;


    public function create(): bool
    {
        $query = "INSERT INTO hotel_reservations (start_at, end_at, type_of_room, total_price, hotel_id, user_id, service_provider_id) 
        
        VALUES (? , ? , ? , ? , ? , ? , ?)";

        $returned_stmt = $this->connect->prepare($query);
        if (!$returned_stmt) {
            return false;
        }

        $returned_stmt->bind_param(
            'ssidiii',
            $this->start_at,
            $this->end_at,
            $this->type_of_room,
            $this->total_price,
            $this->hotel_id,
            $this->user_id,
            $this->service_provider_id
        );
        return $returned_stmt->execute();
    }

    public function read(): array
    {
        $query = "SELECT h.*,u.first_name AS userFirstName, u.last_name AS userLastName
        FROM hotel_reservations AS h
        JOIN users AS u ON h.user_id=u.id
        WHERE h.hotel_id=?";

        $returned_stmt = $this->connect->prepare($query);
        $returned_stmt->bind_param(
            'i',
            $this->hotel_id
        );
        $returned_stmt->execute();

        $result = $returned_stmt->get_result();
        $reservations = $result->fetch_all(MYSQLI_ASSOC);
        return $reservations;
    }



    public function delete(): bool
    {
        # code...
    }

    public function update(): bool
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

    function readO(): \mysqli_result
    {
        #code
    }


    /**
     * Get the value of total_price
     */
    public function getTotal_price()
    {
        return $this->total_price;
    }

    /**
     * Set the value of total_price
     *
     * @return  self
     */
    public function setTotal_price($total_price)
    {
        $this->total_price = $total_price;

        return $this;
    }

    /**
     * Get the value of service_provider_id
     */
    public function getService_provider_id()
    {
        return $this->service_provider_id;
    }

    /**
     * Set the value of service_provider_id
     *
     * @return  self
     */
    public function setService_provider_id($service_provider_id)
    {
        $this->service_provider_id = $service_provider_id;

        return $this;
    }

    /**
     * Get the value of start_at
     */
    public function getStart_at()
    {
        return $this->start_at;
    }

    /**
     * Set the value of start_at
     *
     * @return  self
     */
    public function setStart_at($start_at)
    {
        $this->start_at = $start_at;

        return $this;
    }

    /**
     * Get the value of end_at
     */
    public function getEnd_at()
    {
        return $this->end_at;
    }

    /**
     * Set the value of end_at
     *
     * @return  self
     */
    public function setEnd_at($end_at)
    {
        $this->end_at = $end_at;

        return $this;
    }

    /**
     * Get the value of type_of_room
     */
    public function getType_of_room()
    {
        return $this->type_of_room;
    }

    /**
     * Set the value of type_of_room
     *
     * @return  self
     */
    public function setType_of_room($type_of_room)
    {
        $this->type_of_room = $type_of_room;

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
}
