<?php

namespace App\Database\Models;

use App\Database\Models\Contract\MakeCrud;
use App\Database\Models\Model;

class Cart extends Model implements MakeCrud
{
    private
        $user_id,
        $product_id,
        $quantity_needed;


    public function create(): bool
    {
        $query = "INSERT INTO carts (user_id, product_id ,quantity_needed) 
        
        VALUES (? , ? , ? )";

        $returned_stmt = $this->connect->prepare($query);
        if (!$returned_stmt) {
            return false;
        }

        $returned_stmt->bind_param(
            'iii',
            $this->user_id,
            $this->product_id,
            $this->quantity_needed
        );

        return $returned_stmt->execute();
    }

    public function read(): array
    {
        $query = "SELECT c.*,p.*
        FROM carts AS c
        JOIN products AS p ON p.id = c.product_id
        WHERE c.user_id= ?";

        $returned_stmt = $this->connect->prepare($query);

        $returned_stmt->bind_param('i', $this->user_id);
        $returned_stmt->execute();

        $result = $returned_stmt->get_result();
        $wishlist = $result->fetch_all(MYSQLI_ASSOC);
        return $wishlist;
    }


    public function delete(): bool
    {
        $query = "DELETE FROM carts WHERE user_id = ? AND product_id=?";


        $returned_stmt = $this->connect->prepare($query);
        if (!$returned_stmt) {
            return false;
        }

        $returned_stmt->bind_param(
            'ii',
            $this->user_id,
            $this->product_id
        );

        return $returned_stmt->execute();
    }

    public function deleteCart(): bool
    {
        $query = "DELETE FROM carts WHERE user_id = ?";


        $returned_stmt = $this->connect->prepare($query);
        if (!$returned_stmt) {
            return false;
        }

        $returned_stmt->bind_param(
            'i',
            $this->user_id,
        );

        return $returned_stmt->execute();
    }

    public function checkUnique(): bool
    {
        $query = "SELECT COUNT(*) as count
                  FROM carts
                  WHERE user_id = ? AND product_id = ?";

        $returned_stmt = $this->connect->prepare($query);

        $returned_stmt->bind_param('ii', $this->user_id, $this->product_id);
        $returned_stmt->execute();

        $result = $returned_stmt->get_result();
        $row = $result->fetch_assoc();
        $count = $row['count'];

        return $count > 0;
    }

    public function update(): bool
    {
        $query = "UPDATE carts SET  quantity_needed = ? WHERE user_id = ? AND product_id=?";

        $stmt = $this->connect->prepare($query);
        if (!$stmt) {
            return false;
        }

        $stmt->bind_param('iii',  $this->quantity_needed, $this->user_id, $this->product_id);

        return $stmt->execute();
    }

    public function get(): int
    {
        $query = "SELECT quantity_needed
              FROM carts
              WHERE user_id = ? AND product_id = ?";

        $returned_stmt = $this->connect->prepare($query);

        $returned_stmt->bind_param('ii', $this->user_id, $this->product_id);
        $returned_stmt->execute();

        $result = $returned_stmt->get_result();
        $row = $result->fetch_assoc();
        $quantityNeeded = $row['quantity_needed'];

        return $quantityNeeded;
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
     * Get the value of product_id
     */
    public function getProduct_id()
    {
        return $this->product_id;
    }

    /**
     * Set the value of product_id
     *
     * @return  self
     */
    public function setProduct_id($product_id)
    {
        $this->product_id = $product_id;

        return $this;
    }


    /**
     * Get the value of quantity_needed
     */
    public function getQuantity_needed()
    {
        return $this->quantity_needed;
    }

    /**
     * Set the value of quantity_needed
     *
     * @return  self
     */
    public function setQuantity_needed($quantity_needed)
    {
        $this->quantity_needed = $quantity_needed;

        return $this;
    }
}
