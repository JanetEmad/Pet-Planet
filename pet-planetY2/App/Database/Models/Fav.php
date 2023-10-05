<?php

namespace App\Database\Models;

use App\Database\Models\Contract\MakeCrud;
use App\Database\Models\Model;

class Fav extends Model implements MakeCrud
{
    private
        $user_id,
        $product_id;


    public function create(): bool
    {
        $query = "INSERT INTO favs (user_id, product_id) 
        
        VALUES (? , ? )";

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

    public function read(): array
    {
        $query = "SELECT f.*,p.*
        FROM favs AS f
        JOIN products AS p ON p.id = f.product_id 
        WHERE f.user_id =?";

        $returned_stmt = $this->connect->prepare($query);

        $returned_stmt->bind_param(
            'i',
            $this->user_id,
        );
        $returned_stmt->execute();

        $result = $returned_stmt->get_result();
        $wishlist = $result->fetch_all(MYSQLI_ASSOC);
        return $wishlist;
    }


    public function delete(): bool
    {
        $query = "DELETE FROM favs WHERE user_id = ? AND product_id=?";


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

    public function checkUnique(): bool
    {
        $query = "SELECT COUNT(*) as count
                  FROM favs
                  WHERE user_id = ? AND product_id = ?";

        $returned_stmt = $this->connect->prepare($query);

        $returned_stmt->bind_param('ii', $this->user_id, $this->product_id);
        $returned_stmt->execute();

        $result = $returned_stmt->get_result();
        $row = $result->fetch_assoc();
        $count = $row['count'];

        return $count > 0;
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

    function update(): bool
    {
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
}
