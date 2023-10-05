<?php

namespace App\Database\Models;

use App\Database\Models\Contract\MakeCrud;

class Order extends Model  implements MakeCrud
{
    private $id, $total_price,
        $status, $delivered_at, $address_id;
    private const ACTIVE = 1;

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
     * Get the value of status
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * Set the value of status
     *
     * @return  self
     */
    public function setStatus($status)
    {
        $this->status = $status;

        return $this;
    }


    public function create(): bool
    {
        $query = "INSERT INTO orders (total_price, status, delivered_at, address_id) 
        
        VALUES (? , ? , ? , ? )";

        $returned_stmt = $this->connect->prepare($query);
        if (!$returned_stmt) {
            return false;
        }

        $returned_stmt->bind_param(
            'disi',
            $this->total_price,
            $this->status,
            $this->delivered_at,
            $this->address_id,
        );

        return $returned_stmt->execute();
    }




    public function update(): bool
    {
    }

    public function delete(): bool
    {
    }

    public function read(): array
    {
        $query = "SELECT * FROM orders ORDER BY id DESC LIMIT 1";

        $returned_stmt = $this->connect->prepare($query);
        $returned_stmt->execute();

        $result = $returned_stmt->get_result();
        $order = $result->fetch_all(MYSQLI_ASSOC);
        return $order;
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
     * Get the value of delivered_at
     */
    public function getDelivered_at()
    {
        return $this->delivered_at;
    }

    /**
     * Set the value of delivered_at
     *
     * @return  self
     */
    public function setDelivered_at($delivered_at)
    {
        $this->delivered_at = $delivered_at;

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
}
