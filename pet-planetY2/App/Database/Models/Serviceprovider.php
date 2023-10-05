<?php

namespace App\Database\Models;

use App\Database\Models\Contract\MakeCrud;
use App\Database\Models\Model;

class Serviceprovider extends Model implements MakeCrud
{
    private $id,
        $service_provider_type,
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
        $query = "INSERT INTO serviceproviders (service_provider_type, user_id) 
        
        VALUES (?, ? )";

        $returned_stmt = $this->connect->prepare($query);
        if (!$returned_stmt) {
            return false;
        }

        $returned_stmt->bind_param(
            'ii',
            $this->service_provider_type,
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

    /**
     * Get the value of service_provider_type
     */
    public function getService_provider_type()
    {
        return $this->service_provider_type;
    }

    /**
     * Set the value of service_provider_type
     *
     * @return  self
     */
    public function setService_provider_type($service_provider_type)
    {
        $this->service_provider_type = $service_provider_type;

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
