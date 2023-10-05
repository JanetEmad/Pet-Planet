<?php

namespace App\Database\Models;

use App\Database\Models\Contract\MakeCrud;

class Product extends Model  implements MakeCrud
{
    private $id, $name, $price, $product_code, $quantity,
        $status, $details, $image, $subcategory_id, $category_id;
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
     * Get the value of product_code
     */
    public function getProduct_code()
    {
        return $this->product_code;
    }

    /**
     * Set the value of product_code
     *
     * @return  self
     */
    public function setProduct_code($product_code)
    {
        $this->product_code = $product_code;

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

    /**
     * Get the value of details
     */
    public function getDetails()
    {
        return $this->details;
    }

    /**
     * Set the value of details
     *
     * @return  self
     */
    public function setDetails($details)
    {
        $this->details = $details;

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
     * Get the value of subcategroy_id
     */
    public function getSubcategory_id()
    {
        return $this->subcategory_id;
    }

    /**
     * Set the value of subcategroy_id
     *
     * @return  self
     */
    public function setSubcategory_id($subcategory_id)
    {
        $this->subcategory_id = $subcategory_id;

        return $this;
    }

    public function create(): bool
    {
        $query = "INSERT INTO products (name, price, product_code, quantity,
        status, details, image, subcategory_id, category_id) 
        
        VALUES (? , ? , ? , ? ,? ,? , ?, ? , ?)";

        $returned_stmt = $this->connect->prepare($query);
        if (!$returned_stmt) {
            return false;
        }

        $returned_stmt->bind_param(
            'sdiiissii',
            $this->name,
            $this->price,
            $this->product_code,
            $this->quantity,
            $this->status,
            $this->details,
            $this->image,
            $this->subcategory_id,
            $this->category_id
        );

        return $returned_stmt->execute();
    }


    public function update(): bool
    {
        $query = "UPDATE products SET name = ?, price = ?, product_code = ?, quantity = ?, status = ?, details = ?, subcategory_id = ?, category_id = ?";

        // Check if the image parameter is provided
        if (!empty($_FILES['update-image']['name'])) {
            $query .= ", image = ?";
            $this->image = $_FILES['update-image']['name'];
        }

        $query .= " WHERE id = ?";

        $stmt = $this->connect->prepare($query);
        if (!$stmt) {
            return false;
        }


        if (!empty($_FILES['update-image']['name'])) {
            $stmt->bind_param(
                'sdiiisiisi',
                $this->name,
                $this->price,
                $this->product_code,
                $this->quantity,
                $this->status,
                $this->details,
                $this->subcategory_id,
                $this->category_id,
                $this->image,
                $this->id
            );
        } else {
            $stmt->bind_param(
                'sdiiisiii',
                $this->name,
                $this->price,
                $this->product_code,
                $this->quantity,
                $this->status,
                $this->details,
                $this->subcategory_id,
                $this->category_id,
                $this->id
            );
        }

        return $stmt->execute();

        return true;
    }

    public function delete(): bool
    {
        $query = "DELETE FROM products WHERE id = ?";


        $returned_stmt = $this->connect->prepare($query);
        if (!$returned_stmt) {
            return false;
        }

        $returned_stmt->bind_param(
            'i',
            $this->id
        );

        return $returned_stmt->execute();
    }

    public function read(): array
    {
        $query = "SELECT id,name,details,price,image FROM products WHERE status = " . self::ACTIVE . " AND quantity > 0 ORDER BY price , name";

        $returned_stmt = $this->connect->prepare($query);
        $returned_stmt->execute();

        $result = $returned_stmt->get_result();
        $products = $result->fetch_all(MYSQLI_ASSOC);
        return $products;
    }

    public function getProductsBySub(): \mysqli_result
    {
        $query = "SELECT id,name,details,price,image FROM products WHERE status = " . self::ACTIVE . " AND quantity > 0 AND subcategory_id = ? ORDER BY price , name";
        $stmt =  $this->connect->prepare($query);
        $stmt->bind_param('i', $this->subcategory_id);
        $stmt->execute();

        return $stmt->get_result();
    }

    public function getProductsByCat(): \mysqli_result
    {
        $query = "SELECT id,name,details, price,image FROM products WHERE status = " . self::ACTIVE . " AND quantity > 0 AND category_id = ? ORDER BY price , name";
        $stmt =  $this->connect->prepare($query);
        $stmt->bind_param('i', $this->category_id);
        $stmt->execute();

        return $stmt->get_result();
    }

    public function find(): \mysqli_result
    {
        $query = "SELECT * FROM products WHERE status = " . self::ACTIVE . " AND id = ?";
        $stmt =  $this->connect->prepare($query);
        $stmt->bind_param('i', $this->id);
        $stmt->execute();

        return $stmt->get_result();
    }

    public function getProductsBySubName($SubName): \mysqli_result
    {
        $query = "SELECT products.id, products.name, products.details, products.price, products.image
        FROM products
        JOIN subcategories ON products.subcategory_id = subcategories.id
        WHERE subcategories.name = ? AND status = " . self::ACTIVE . "
        ORDER BY price, name";
        $stmt =  $this->connect->prepare($query);
        $stmt->bind_param('s', $SubName);
        $stmt->execute();

        return $stmt->get_result();
    }

    public function readForAdmin(): array
    {
        $query = "SELECT * FROM products ";

        $returned_stmt = $this->connect->prepare($query);
        $returned_stmt->execute();

        $result = $returned_stmt->get_result();
        $products = $result->fetch_all(MYSQLI_ASSOC);
        return $products;
    }

    /**
     * Get the value of category_id
     */
    public function getCategory_id()
    {
        return $this->category_id;
    }

    /**
     * Set the value of category_id
     *
     * @return  self
     */
    public function setCategory_id($category_id)
    {
        $this->category_id = $category_id;

        return $this;
    }
    function readO(): \mysqli_result
    {
        #code
    }
}
