<?php

namespace App\Database\Models;

use App\Database\Models\Contract\MakeCrud;
use App\Database\Models\Model;

class Rate extends Model implements MakeCrud
{
    private $id,
        $rate,
        $service_provider_id,
        $user_id;
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

    public function create(): bool
    {
        $query = "INSERT INTO rates (rate, service_provider_id, user_id) 
        
        VALUES (?, ? , ? )";

        $returned_stmt = $this->connect->prepare($query);
        if (!$returned_stmt) {
            return false;
        }

        $returned_stmt->bind_param(
            'iii',
            $this->rate,
            $this->service_provider_id,
            $this->user_id
        );

        return $returned_stmt->execute();
    }

    public function read(): array
    {
    }

    public function rateCount(): float
    {
        $query = "SELECT count(rate) AS count
        FROM rates
        WHERE service_provider_id = ?";

        $returned_stmt = $this->connect->prepare($query);

        $returned_stmt->bind_param('i', $this->service_provider_id);
        $returned_stmt->execute();

        $result = $returned_stmt->get_result();
        $row = $result->fetch_assoc();
        $count = $row['count'];

        return $count;
    }

    public function rateSum(): float
    {
        $query = "SELECT sum(rate) AS sum
        FROM rates
        WHERE service_provider_id = ?";

        $returned_stmt = $this->connect->prepare($query);

        $returned_stmt->bind_param('i', $this->service_provider_id);
        $returned_stmt->execute();

        $result = $returned_stmt->get_result();
        $row = $result->fetch_assoc();
        $sum = $row['sum'];

        return $sum;
    }

    public function update(): bool
    {
        # code...
    }

    public function delete(): bool
    {
        # code...
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
}
