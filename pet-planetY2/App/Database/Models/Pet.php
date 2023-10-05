<?php

namespace App\Database\Models;

use App\Database\Models\Contract\MakeCrud;
use App\Database\Models\Model;

class Pet extends Model implements MakeCrud
{
    private $id,
        $category_id,
        $name,
        $type,
        $family,
        $age,
        $gender,
        $image,
        $user_id,
        $user_id_for_operation,
        $pending;

    public function create(): bool
    {
        $query = "INSERT INTO pets (name,type,family,age,gender,image,user_id ,category_id,pending ) 
        
        VALUES (? , ? , ? , ? , ? , ? , ? ,?,?)";

        $returned_stmt = $this->connect->prepare($query);
        if (!$returned_stmt) {
            return false;
        }

        $returned_stmt->bind_param(
            'sssissiii',
            $this->name,
            $this->type,
            $this->family,
            $this->age,
            $this->gender,
            $this->image,
            $this->user_id,
            $this->category_id,
            $this->pending
        );

        return $returned_stmt->execute();
    }

    function readO(): \mysqli_result
    {
        #code
    }

    public function update(): bool
    {
        # code...
    }

    public function delete(): bool
    {
        # code...
    }

    function read(): array
    {
        #code
    }

    public function getPetInfo()
    {
        $query = "SELECT * FROM pets WHERE id = ? ";

        $returned_stmt = $this->connect->prepare($query);
        if (!$returned_stmt) {
            return false;
        }

        $returned_stmt->bind_param('i', $this->id);
        $returned_stmt->execute();
        return $returned_stmt->get_result();
    }

    public function get()
    {
        $query = "SELECT
                    `pets`.*
                FROM
                    `pets`
                JOIN `users`
                ON `users`.`id` = `pets`.`user_id`
                WHERE
                    `user_id` = ?";
        $stmt = $this->connect->prepare($query);
        $stmt->bind_param('i', $this->user_id);
        $stmt->execute();
        return $stmt->get_result();
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
     * Get the value of type
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * Set the value of type
     *
     * @return  self
     */
    public function setType($type)
    {
        $this->type = $type;

        return $this;
    }

    /**
     * Get the value of family
     */
    public function getFamily()
    {
        return $this->family;
    }

    /**
     * Set the value of family
     *
     * @return  self
     */
    public function setFamily($family)
    {
        $this->family = $family;

        return $this;
    }

    /**
     * Get the value of age
     */
    public function getAge()
    {
        return $this->age;
    }

    /**
     * Set the value of age
     *
     * @return  self
     */
    public function setAge($age)
    {
        $this->age = $age;

        return $this;
    }

    /**
     * Get the value of gender
     */
    public function getGender()
    {
        return $this->gender;
    }

    /**
     * Set the value of gender
     *
     * @return  self
     */
    public function setGender($gender)
    {
        $this->gender = $gender;

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

    /**
     * Get the value of user_id_for_operation
     */
    public function getUser_id_for_operation()
    {
        return $this->user_id_for_operation;
    }

    /**
     * Set the value of user_id_for_operation
     *
     * @return  self
     */
    public function setUser_id_for_operation($user_id_for_operation)
    {
        $this->user_id_for_operation = $user_id_for_operation;

        return $this;
    }

    /**
     * Get the value of pending
     */
    public function getPending()
    {
        return $this->pending;
    }

    /**
     * Set the value of pending
     *
     * @return  self
     */
    public function setPending($pending)
    {
        $this->pending = $pending;

        return $this;
    }

    public function placePetForAdoption()
    {
        $query = "UPDATE pets SET placed_adoption = 1 WHERE id = ?";
        $returned_stmt = $this->connect->prepare($query);
        if (!$returned_stmt) {
            return false;
        }
        $returned_stmt->bind_param('i', $this->id);
        return $returned_stmt->execute();
    }
    public function placePetForSelling()
    {
        $query = "UPDATE pets SET placed_selling = 1 WHERE id = ?";
        $returned_stmt = $this->connect->prepare($query);
        if (!$returned_stmt) {
            return false;
        }
        $returned_stmt->bind_param('i', $this->id);
        return $returned_stmt->execute();
    }
    public function placePetForMating()
    {
        $query = "UPDATE pets SET placed_mating = 1 WHERE id = ?";
        $returned_stmt = $this->connect->prepare($query);
        if (!$returned_stmt) {
            return false;
        }
        $returned_stmt->bind_param('i', $this->id);
        return $returned_stmt->execute();
    }
    public function getAvailablePetsForBuying(): \mysqli_result
    {
        return $this->connect->query("SELECT * FROM pets where placed_selling = 1 ORDER BY id ASC");
    }
    public function getAvailablePetsForAdoption(): \mysqli_result
    {
        return $this->connect->query("SELECT * FROM pets where placed_adoption = 1 ORDER BY id ASC");
    }
    public function getAvailablePetsForMating(): \mysqli_result
    {
        return $this->connect->query("SELECT * FROM pets where placed_mating = 1 ORDER BY id ASC");
    }
    public function updatePetStatus($string)
    {

        if ($string == 'mate' || $string == 'buy' || $string == 'adopt') {
            $query = "UPDATE pets SET placed_selling = 0, placed_adoption = 0, placed_mating = 0, pending = 1, user_id_for_operation = ? WHERE id = ?";

            $returned_stmt = $this->connect->prepare($query);
            if (!$returned_stmt) {
                return false;
            }
            $returned_stmt->bind_param('ii', $this->user_id_for_operation, $this->id);
            return $returned_stmt->execute();
        }
    }

    public function getPetByCat($string)
    {
        if ($string == 'buy') {
            $query = "SELECT * FROM pets WHERE placed_selling=1 AND  category_id = ?";
        }
        if ($string == 'adopt') {
            $query = "SELECT * FROM pets WHERE placed_adoption=1 AND  category_id = ?";
        }
        if ($string == 'mate') {
            $query = "SELECT * FROM pets WHERE placed_mating=1 AND  category_id = ?";
        }
        $stmt = $this->connect->prepare($query);
        $stmt->bind_param('i', $this->category_id);
        $stmt->execute();
        return $stmt->get_result();
    }
}
