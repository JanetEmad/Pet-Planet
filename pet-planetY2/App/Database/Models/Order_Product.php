<?php

namespace App\Database\Models;

use App\Database\Models\Contract\MakeCrud;

class Order_Product extends Model  implements MakeCrud
{
    private $order_id, $product_id,
        $quantity;
    private const ACTIVE = 1;



    public function create(): bool
    {
        $query = "INSERT INTO orders_products (order_id, product_id, quantity) 
        
        VALUES (? , ? , ? )";

        $returned_stmt = $this->connect->prepare($query);
        if (!$returned_stmt) {
            return false;
        }

        $returned_stmt->bind_param(
            'iii',
            $this->order_id,
            $this->product_id,
            $this->quantity,
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
        // $query = "SELECT id,name,details,price,image FROM products WHERE status = " . self::ACTIVE . " AND quantity > 0 ORDER BY price , name";

        // $returned_stmt = $this->connect->prepare($query);
        // $returned_stmt->execute();

        // $result = $returned_stmt->get_result();
        // $products = $result->fetch_all(MYSQLI_ASSOC);
        // return $products;
    }


    function readO(): \mysqli_result
    {
        #code
    }

    /**
     * Get the value of order_id
     */
    public function getOrder_id()
    {
        return $this->order_id;
    }

    /**
     * Set the value of order_id
     *
     * @return  self
     */
    public function setOrder_id($order_id)
    {
        $this->order_id = $order_id;

        return $this;
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
     * Get the value of quantity
     */
    public function getQuantity()
    {
        return $this->quantity;
    }

    /**
     * Set the value of quantity
     *
     * @return  self
     */
    public function setQuantity($quantity)
    {
        $this->quantity = $quantity;

        return $this;
    }
}
