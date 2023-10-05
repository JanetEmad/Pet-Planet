<?php

namespace App\Database\Models;

use App\Database\Models\Contract\MakeCrud;
use App\Database\Models\Model;

class Clinic extends Model implements MakeCrud
{
    private $id,
        $name,
        $phone,
        $price,
        $work_days,
        $image,
        $opens_at,
        $closes_at,
        $address_id,
        $rate;


    public function create(): bool
    {
        $query = "INSERT INTO clinics (name, phone, price, work_days,image, opens_at, closes_at, address_id, rate) 
        
        VALUES (? , ? , ? , ? ,? ,? , ?, ? , ?)";

        $returned_stmt = $this->connect->prepare($query);
        if (!$returned_stmt) {
            return false;
        }

        $returned_stmt->bind_param(
            'ssdssssii',
            $this->name,
            $this->phone,
            $this->price,
            $this->work_days,
            $this->image,
            $this->opens_at,
            $this->closes_at,
            $this->address_id,
            $this->rate
        );

        return $returned_stmt->execute();
    }

    public function read(): array
    {
        $query = "SELECT c.*
        FROM clinics AS c";

        $returned_stmt = $this->connect->prepare($query);
        $returned_stmt->execute();

        $result = $returned_stmt->get_result();
        $trainers = $result->fetch_all(MYSQLI_ASSOC);
        return $trainers;
    }

    public function update(): bool
    {
        $query = "UPDATE clinics SET name = ?, phone = ?, price = ?, work_days = ?, opens_at = ?, closes_at = ?";

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
            $stmt->bind_param('ssdssssi', $this->name, $this->phone, $this->price, $this->work_days, $this->opens_at, $this->closes_at, $this->image,  $this->id);
        } else {
            $stmt->bind_param('ssdsssi', $this->name, $this->phone, $this->price, $this->work_days, $this->opens_at, $this->closes_at, $this->id);
        }

        return $stmt->execute();
    }

    public function updateRate(): bool
    {
        $query = "UPDATE clinics SET  rate = ?  WHERE address_id = ?";

        $stmt = $this->connect->prepare($query);
        if (!$stmt) {
            return false;
        }

        $stmt->bind_param('ii',  $this->rate, $this->address_id);

        return $stmt->execute();
    }

    public function delete(): bool
    {
        # code...
    }

    public function retrieveClinicsAddresses(): array
    {
        $query = "SELECT a.*
                    FROM addresses AS a
                    JOIN clinics As c ON a.id = c.address_id
                    LEFT JOIN sitters AS s ON a.id = s.address_id
                    LEFT JOIN trainers AS t ON a.id = t.address_id
                    WHERE s.address_id IS NULL AND t.address_id IS NULL";

        $returned_stmt = $this->connect->prepare($query);
        $returned_stmt->execute();

        $result = $returned_stmt->get_result();
        $addresses = $result->fetch_all(MYSQLI_ASSOC);
        return $addresses;
    }

    public function getClinicInfo()
    {
        $query = "SELECT * FROM clinics WHERE phone = ? ";

        $returned_stmt = $this->connect->prepare($query);
        if (!$returned_stmt) {
            return false;
        }

        $returned_stmt->bind_param('s', $this->phone);
        $returned_stmt->execute();
        return $returned_stmt->get_result();
    }

    public function getClinicInfoById()
    {
        $query = "SELECT * FROM clinics WHERE id = ? ";

        $returned_stmt = $this->connect->prepare($query);
        if (!$returned_stmt) {
            return false;
        }

        $returned_stmt->bind_param('i', $this->id);
        $returned_stmt->execute();
        return $returned_stmt->get_result();
    }

    function fetchClinicDataFromDatabase($address_id)
    {
        // Prepare and execute the query to fetch the clinic data
        $query = "SELECT * FROM clinics WHERE address_id = ?";
        $stmt = $this->connect->prepare($query);
        $stmt->bind_param("i", $address_id);
        $stmt->execute();

        // Fetch the result
        $result = $stmt->get_result();
        $clinicData = $result->fetch_assoc();

        // Close the statement and database connection
        $stmt->close();
        $this->connect->close();

        return $clinicData;
    }

    function fetchClinicDataFromDatabaseByClinicId($clinic_id)
    {
        // Prepare and execute the query to fetch the clinic data
        $query = "SELECT * FROM clinics WHERE id = ?";
        $stmt = $this->connect->prepare($query);
        $stmt->bind_param("i", $clinic_id);
        $stmt->execute();

        // Fetch the result
        $result = $stmt->get_result();
        $clinicData = $result->fetch_assoc();

        // Close the statement and database connection
        $stmt->close();
        $this->connect->close();

        return $clinicData;
    }

    public function retrieveClinicInfoByAddressId($addressId)
    {
        $query = "SELECT c.*
        FROM clinics AS c
        JOIN addresses AS a ON c.address_id = a.id
        WHERE c.address_id = ?";

        $statement = $this->connect->prepare($query);

        $statement->bind_param("i", $addressId);
        $statement->execute();
        $result = $statement->get_result();
        $clinicInfo = $result->fetch_assoc();

        $statement->close();
        $result->close();

        return $clinicInfo;
    }

    public function retrieveClinicServiceProvider_id($clinic_id)
    {
        $query = "SELECT s.id
        FROM veterinaries AS v
        JOIN serviceproviders AS s ON v.user_id = s.user_id
        WHERE v.clinic_id = ?";

        $statement = $this->connect->prepare($query);

        $statement->bind_param("i", $clinic_id);
        $statement->execute();
        $result = $statement->get_result();
        $clinicSPid = $result->fetch_assoc();

        $statement->close();
        $result->close();

        return $clinicSPid;
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
     * Get the value of work_days
     */
    public function getWork_days()
    {
        return $this->work_days;
    }

    /**
     * Set the value of work_days
     *
     * @return  self
     */
    public function setWork_days($work_days)
    {
        $this->work_days = $work_days;

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
     * Get the value of price
     */
    public function getPrice()
    {
        return $this->price;
    }

    /**
     * Set the value of price
     *
     * @return  self
     */
    public function setPrice($price)
    {
        $this->price = $price;

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
     * Get the value of opens_at
     */
    public function getOpens_at()
    {
        return $this->opens_at;
    }

    /**
     * Set the value of opens_at
     *
     * @return  self
     */
    public function setOpens_at($opens_at)
    {
        $this->opens_at = $opens_at;

        return $this;
    }

    /**
     * Get the value of closes_at
     */
    public function getCloses_at()
    {
        return $this->closes_at;
    }

    /**
     * Set the value of closes_at
     *
     * @return  self
     */
    public function setCloses_at($closes_at)
    {
        $this->closes_at = $closes_at;

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


    function readO(): \mysqli_result
    {
        #code
    }
}
