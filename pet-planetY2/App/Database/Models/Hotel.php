<?php

namespace App\Database\Models;

use App\Database\Models\Contract\MakeCrud;
use App\Database\Models\Model;

class Hotel extends Model implements MakeCrud
{
    private $id,
        $name,
        $phone,
        $rate,
        $image,
        $user_id,
        $address_id;


    public function create(): bool
    {
        $query = "INSERT INTO hotels (name, phone, rate, image, user_id, address_id) 
        
        VALUES (? , ? , ? , ? , ? , ? )";

        $returned_stmt = $this->connect->prepare($query);
        if (!$returned_stmt) {
            return false;
        }

        $returned_stmt->bind_param(
            'ssisii',
            $this->name,
            $this->phone,
            $this->rate,
            $this->image,
            $this->user_id,
            $this->address_id
        );
        return $returned_stmt->execute();
    }

    public function read(): array
    {
        $query = "SELECT h.*
        FROM hotels AS h";

        $returned_stmt = $this->connect->prepare($query);
        $returned_stmt->execute();

        $result = $returned_stmt->get_result();
        $trainers = $result->fetch_all(MYSQLI_ASSOC);
        return $trainers;
    }

    public function update(): bool
    {
        $query = "UPDATE hotels SET name = ?, phone = ?, rate = ?";

        // Check if the image parameter is provided
        if (!empty($_FILES['update-image']['name'])) {
            $query .= ", image = ?";
            $this->image = $_FILES['update-image']['name'];
        }

        $query .= " WHERE id = ?;";


        $stmt = $this->connect->prepare($query);
        if (!$stmt) {
            return false;
        }

        if (!empty($_FILES['update-image']['name'])) {
            $stmt->bind_param('ssdsi', $this->name, $this->phone, $this->rate,  $this->image,  $this->id);
        } else {
            $stmt->bind_param('ssdi', $this->name, $this->phone, $this->rate, $this->id);
        }

        return $stmt->execute();
    }

    public function updateRate(): bool
    {
        $query = "UPDATE hotels SET  rate = ?  WHERE user_id = ?";

        $stmt = $this->connect->prepare($query);
        if (!$stmt) {
            return false;
        }

        $stmt->bind_param('ii',  $this->rate, $this->user_id);

        return $stmt->execute();
    }

    public function delete(): bool
    {
        # code...
    }

    public function retrieveHotelsAddresses(): array
    {
        $query = "SELECT a.*
                    FROM addresses AS a
                    JOIN hotels AS h ON a.id = h.address_id";

        $returned_stmt = $this->connect->prepare($query);
        $returned_stmt->execute();

        $result = $returned_stmt->get_result();
        $addresses = $result->fetch_all(MYSQLI_ASSOC);
        return $addresses;
    }


    public function getHotelInfo()
    {
        $query = "SELECT * FROM hotels WHERE phone = ? ";

        $returned_stmt = $this->connect->prepare($query);
        if (!$returned_stmt) {
            return false;
        }

        $returned_stmt->bind_param('s', $this->phone);
        $returned_stmt->execute();
        return $returned_stmt->get_result();
    }

    function fetchHotelDataFromDatabase($address_id)
    {
        $query = "SELECT * FROM hotels WHERE address_id = ?";
        $stmt = $this->connect->prepare($query);
        $stmt->bind_param("i", $address_id);
        $stmt->execute();

        // Fetch the result
        $result = $stmt->get_result();
        $hotelData = $result->fetch_assoc();

        // Close the statement and database connection
        $stmt->close();
        $this->connect->close();

        return $hotelData;
    }

    function fetchHotelDataFromDatabaseByHotelId($hotel_id)
    {
        $query = "SELECT * FROM hotels WHERE id = ?";
        $stmt = $this->connect->prepare($query);
        $stmt->bind_param("i", $hotel_id);
        $stmt->execute();

        // Fetch the result
        $result = $stmt->get_result();
        $hotelData = $result->fetch_assoc();

        // Close the statement and database connection
        $stmt->close();
        $this->connect->close();

        return $hotelData;
    }

    public function retrieveHotelInfoByAddressId($addressId)
    {
        $query = "SELECT c.*
        FROM hotels AS h
        JOIN addresses AS a ON h.address_id = a.id
        WHERE h.address_id = ?";

        $statement = $this->connect->prepare($query);

        $statement->bind_param("i", $addressId);
        $statement->execute();
        $result = $statement->get_result();
        $clinicInfo = $result->fetch_assoc();

        $statement->close();
        $result->close();

        return $clinicInfo;
    }

    public function retrieveHotelServiceProvider_id($hotel_id)
    {
        $query = "SELECT s.id
        FROM hotels AS h
        JOIN serviceproviders AS s ON h.user_id = s.user_id
        WHERE h.id = ?";

        $statement = $this->connect->prepare($query);

        $statement->bind_param("i", $hotel_id);
        $statement->execute();
        $result = $statement->get_result();
        $hotelSPid = $result->fetch_assoc();

        $statement->close();
        $result->close();

        return $hotelSPid;
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
     * Get the value of address_id
     */
    public function getAddress_id()
    {
        return $this->address_id;
    }

    /**
     * Set the value of address_id
     *
     * @return  self
     */

    public function setAddress_id($address_id)
    {
        $this->address_id = $address_id;

        return $this;
    }

    /**
     * Get the value of name
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set the value of name
     *
     * @return  self
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get the value of phone
     */
    public function getPhone()
    {
        return $this->phone;
    }

    /**
     * Set the value of phone
     *
     * @return  self
     */
    public function setPhone($phone)
    {
        $this->phone = $phone;

        return $this;
    }

    /**
     * Get the value of image
     */
    public function getImage()
    {
        return $this->image;
    }

    /**
     * Set the value of image
     *
     * @return  self
     */
    public function setImage($image)
    {
        $this->image = $image;

        return $this;
    }

    /**
     * Get the value of rate
     */
    public function getRate()
    {
        return $this->rate;
    }



    /**
     * Set the value of rate
     *
     * @return  self
     */
    public function setRate($rate)
    {
        $this->rate = $rate;
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
}
