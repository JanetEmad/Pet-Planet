<?php

namespace App\Database\Models;

use App\Database\Models\Contract\MakeCrud;

class Subcategory extends Model  implements MakeCrud
{
    private $id, $name, $category_id;
    public function create(): bool
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

    public function read(): array
    {
        # code... 
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

    public function getSubByCat()
    {
        $query = "SELECT id,name FROM subcategories WHERE category_id = ?";
        $stmt = $this->connect->prepare($query);

        $stmt->bind_param('i', $this->category_id);
        $stmt->execute();

        $result = $stmt->get_result();
        $subcategories = $result->fetch_all(MYSQLI_ASSOC);
        return $subcategories;
    }

    public function getSub()
    {
        $query = "SELECT DISTINCT name FROM subcategories ";
        $stmt = $this->connect->prepare($query);
        // $stmt->bind_param('i', $this->category_id);
        $stmt->execute();

        $result = $stmt->get_result();
        $subcategories = $result->fetch_all(MYSQLI_ASSOC);
        return $subcategories;
    }

    function readO(): \mysqli_result
    {
        #code
    }
}
