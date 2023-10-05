<?php

namespace App\Database\Models;

use App\Database\Models\Contract\MakeCrud;
use App\Database\Models\Model;

class Trainer extends Model implements MakeCrud
{
    private $id,
        $user_id,
        $work_days,
        $price_per_hour,
        $address_id,
        $rate;


    public function create(): bool
    {
        $query = "INSERT INTO trainers (work_days, price_per_hour, address_id, user_id, rate) 
        
        VALUES (? , ? , ? , ? , ?)";

        $returned_stmt = $this->connect->prepare($query);
        if (!$returned_stmt) {
            return false;
        }

        $returned_stmt->bind_param(
            'sdiii',
            $this->work_days,
            $this->price_per_hour,
            $this->address_id,
            $this->user_id,
            $this->rate
        );

        return $returned_stmt->execute();
    }

    public function read(): array
    {
        $query = "SELECT u.*,t.*,a.*
        FROM users AS u
        JOIN trainers AS t ON u.id = t.user_id 
        JOIN addresses As a ON t.address_id = a.id";

        $returned_stmt = $this->connect->prepare($query);
        $returned_stmt->execute();

        $result = $returned_stmt->get_result();
        $trainers = $result->fetch_all(MYSQLI_ASSOC);
        return $trainers;
    }

    public function update(): bool
    {
        $query = "UPDATE trainers SET work_days = ?, price_per_hour = ?, rate = ?, address_id = ?, user_id = ? WHERE id = ?";

        $stmt = $this->connect->prepare($query);
        if (!$stmt) {
            return false;
        }

        $stmt->bind_param('sdiiii', $this->work_days, $this->price_per_hour, $this->rate, $this->address_id, $this->user_id, $this->id);

        return $stmt->execute();
    }

    public function updateRate(): bool
    {
        $query = "UPDATE trainers SET  rate = ?  WHERE user_id = ?";

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

    public function retrieveTrainersAddresses(): array
    {
        $query = "SELECT a.*
                    FROM addresses AS a
                    JOIN trainers AS t ON a.id = t.address_id
                    LEFT JOIN sitters AS s ON a.id = s.address_id
                    WHERE s.address_id IS NULL";

        $returned_stmt = $this->connect->prepare($query);
        $returned_stmt->execute();

        $result = $returned_stmt->get_result();
        $addresses = $result->fetch_all(MYSQLI_ASSOC);
        return $addresses;
    }

    public function retrieveTrainerInfoByAddressId($addressId)
    {
        $query = "SELECT t.*, u.*
            FROM trainers AS t
            JOIN users AS u ON t.user_id = u.id
            WHERE t.address_id = ?";

        $statement = $this->connect->prepare($query);

        $statement->bind_param("i", $addressId);
        $statement->execute();
        $result = $statement->get_result();
        $trainerInfo = $result->fetch_assoc();

        $statement->close();
        $result->close();

        if ($trainerInfo) {
            $userId = $trainerInfo['user_id'];
            $userQuery = "SELECT * FROM users WHERE id = ?";
            $userStatement = $this->connect->prepare($userQuery);
            $userStatement->bind_param("i", $userId);
            $userStatement->execute();
            $userResult = $userStatement->get_result();
            $userInfo = $userResult->fetch_assoc();
            $userStatement->close();
            $userResult->close();

            $trainerInfo['user'] = $userInfo;
        }

        return $trainerInfo;
    }


    public function fetchTrainerDataFromDatabase($address_id)
    {
        $query = "SELECT trainers.*,users.* FROM trainers
        JOIN users ON users.id = trainers.user_id
        JOIN addresses ON trainers.address_id = addresses.id
        WHERE trainers.address_id = ?";
        $stmt = $this->connect->prepare($query);
        $stmt->bind_param("i", $address_id);
        $stmt->execute();

        $result = $stmt->get_result();
        $trainerData = $result->fetch_assoc();

        $stmt->close();
        $this->connect->close();

        return $trainerData;
    }

    function fetchTrainerDataFromDatabaseByUserId($userId)
    {
        $query = "SELECT * FROM trainers WHERE user_id = ?";
        $stmt = $this->connect->prepare($query);
        $stmt->bind_param("i", $userId);
        $stmt->execute();

        $result = $stmt->get_result();
        $trainerData = $result->fetch_assoc();

        $stmt->close();
        $this->connect->close();

        return $trainerData;
    }

    function fetchTrainerDataFromDatabaseById($id)
    {
        $query = "SELECT * FROM trainers WHERE id = ?";
        $stmt = $this->connect->prepare($query);
        $stmt->bind_param("i", $id);
        $stmt->execute();

        $result = $stmt->get_result();
        $trainerData = $result->fetch_assoc();

        $stmt->close();
        $this->connect->close();

        return $trainerData;
    }

    public function retrieveTrainerServiceProvider_id($trainerId)
    {
        $query = "SELECT s.id
        FROM trainers AS t
        JOIN serviceproviders AS s ON t.user_id = s.user_id
        WHERE t.user_id = ?";

        $statement = $this->connect->prepare($query);

        $statement->bind_param("i", $trainerId);
        $statement->execute();
        $result = $statement->get_result();
        $trainerSPid = $result->fetch_assoc();

        return $trainerSPid;
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
     * Get the value of price_per_hour
     */
    public function getPrice_per_hour()
    {
        return $this->price_per_hour;
    }

    /**
     * Set the value of price_per_hour
     *
     * @return  self
     */
    public function setPrice_per_hour($price_per_hour)
    {
        $this->price_per_hour = $price_per_hour;

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
