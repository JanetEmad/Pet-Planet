<?php

namespace App\Database\Models;

use App\Database\Models\Contract\MakeCrud;

class Category extends Model  implements MakeCrud
{
    private $id, $name, $image;
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
        $query = "SELECT id,name, image FROM categories";
        $stmt = $this->connect->prepare($query);
        $stmt->execute();

        $result = $stmt->get_result();
        $categories = $result->fetch_all(MYSQLI_ASSOC);
        return $categories;
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


    function readO(): \mysqli_result
    {
        #code
    }
}
