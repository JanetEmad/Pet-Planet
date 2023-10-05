<?php

namespace App\Database\Models;

use App\Database\Models\Contract\MakeCrud;
use App\Database\Models\Model;

class User extends Model implements MakeCrud
{
    private $id,
        $first_name,
        $last_name,
        $email,
        $password,
        $gender,
        $phone,
        $image,
        $status,
        $admin_status,
        $service_provider_status,
        $service_provider_type,
        $verification_code,
        $email_verified_at,
        $banned;


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
     * Get the value of first_name
     */
    public function getFirst_name()
    {
        return $this->first_name;
    }

    /**
     * Set the value of first_name
     *
     * @return  self
     */
    public function setFirst_name($first_name)
    {
        $this->first_name = $first_name;

        return $this;
    }

    /**
     * Get the value of last_name
     */
    public function getLast_name()
    {
        return $this->last_name;
    }

    /**
     * Set the value of last_name
     *
     * @return  self
     */
    public function setLast_name($last_name)
    {
        $this->last_name = $last_name;

        return $this;
    }

    /**
     * Get the value of email
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * Set the value of email
     *
     * @return  self
     */
    public function setEmail($email)
    {
        $this->email = $email;

        return $this;
    }

    /**
     * Get the value of password
     */
    public function getPassword()
    {
        return $this->password;
    }

    /**
     * Set the value of password
     *
     * @return  self
     */
    public function setPassword($password)
    {
        $this->password =  password_hash($password, PASSWORD_BCRYPT);

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
     * Get the value of phone
     */
    public function getPhone()
    {
        return $this->phone;
    }

    /**
     * Set the value of phone
     *
     * @return  self
     */
    public function setPhone($phone)
    {
        $this->phone = $phone;

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
     * Get the value of admin_status
     */
    public function getAdmin_status()
    {
        return $this->admin_status;
    }

    /**
     * Set the value of admin_status
     *
     * @return  self
     */
    public function setAdmin_status($admin_status)
    {
        $this->admin_status = $admin_status;

        return $this;
    }

    /**
     * Get the value of service_provider_status
     */
    public function getService_provider_status()
    {
        return $this->service_provider_status;
    }

    /**
     * Set the value of service_provider_status
     *
     * @return  self
     */
    public function setService_provider_status($service_provider_status)
    {
        $this->service_provider_status = $service_provider_status;

        return $this;
    }

    /**
     * Get the value of verification_code
     */
    public function getVerification_code()
    {
        return $this->verification_code;
    }

    /**
     * Set the value of verification_code
     *
     * @return  self
     */
    public function setVerification_code($verification_code)
    {
        $this->verification_code = $verification_code;

        return $this;
    }

    /**
     * Get the value of email_verified_at
     */
    public function getEmail_verified_at()
    {
        return $this->email_verified_at;
    }

    /**
     * Set the value of email_verified_at
     *
     * @return  self
     */
    public function setEmail_verified_at($email_verified_at)
    {
        $this->email_verified_at = $email_verified_at;

        return $this;
    }


    public function create(): bool
    {
        $query = "INSERT INTO users (first_name,last_name,
        email,password,gender,phone,verification_code,admin_status,service_provider_status, service_provider_type, image, banned) 
        
        VALUES (? , ? , ? , ? , ? , ? , ? , ? , ? , ? , ? , ? )";

        $returned_stmt = $this->connect->prepare($query);
        if (!$returned_stmt) {
            return false;
        }

        $returned_stmt->bind_param(
            'ssssssiiiisi',
            $this->first_name,
            $this->last_name,
            $this->email,
            $this->password,
            $this->gender,
            $this->phone,
            $this->verification_code,
            $this->admin_status,
            $this->service_provider_status,
            $this->service_provider_type,
            $this->image,
            $this->banned
        );

        return $returned_stmt->execute();
    }



    public function read(): array
    {
        # code...
    }

    public function update(): bool
    {
        $query = "UPDATE users SET first_name = ?, last_name = ?, email = ?, gender = ?, phone = ?";

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
            $stmt->bind_param('ssssssi', $this->first_name, $this->last_name, $this->email, $this->gender, $this->phone, $this->image, $this->id);
        } else {
            $stmt->bind_param('sssssi', $this->first_name, $this->last_name, $this->email, $this->gender, $this->phone, $this->id);
        }

        return $stmt->execute();
    }


    public function delete(): bool
    {
        # code...
    }

    public function codeVerification()
    {
        $query = "SELECT * FROM users WHERE email = ? AND verification_code = ?";

        $returned_stmt = $this->connect->prepare($query);
        if (!$returned_stmt) {
            return false;
        }

        $returned_stmt->bind_param('si', $this->email, $this->verification_code);
        $returned_stmt->execute();
        return $returned_stmt->get_result();
    }

    public function verifyUser(): bool
    {
        $query = "UPDATE users SET email_verified_at = ? WHERE email = ?";

        $returned_stmt = $this->connect->prepare($query);
        if (!$returned_stmt) {
            return false;
        }
        $returned_stmt->bind_param('ss', $this->email_verified_at, $this->email);
        return $returned_stmt->execute();
    }

    public function getUserInfo()
    {
        $query = "SELECT * FROM users WHERE email = ? ";

        $returned_stmt = $this->connect->prepare($query);
        if (!$returned_stmt) {
            return false;
        }

        $returned_stmt->bind_param('s', $this->email);
        $returned_stmt->execute();
        return $returned_stmt->get_result();
    }

    public function getUserInfoById($id)
    {
        $query = "SELECT * FROM users WHERE id = ? ";

        $returned_stmt = $this->connect->prepare($query);
        if (!$returned_stmt) {
            return false;
        }

        $returned_stmt->bind_param('i', $id);
        $returned_stmt->execute();
        $result = $returned_stmt->get_result();
        $userData = $result->fetch_assoc();

        $returned_stmt->close();
        $this->connect->close();

        return $userData;
    }

    public function updatePassword(): bool
    {
        $query = "UPDATE users SET password = ? WHERE email = ?";

        $returned_stmt = $this->connect->prepare($query);
        if (!$returned_stmt) {
            return false;
        }

        $returned_stmt->bind_param('ss', $this->password, $this->email);
        return $returned_stmt->execute();
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

    function readO(): \mysqli_result
    {
        #code
    }
    public function banUserAccount()
    {

        $query = "UPDATE users SET banned = 1 WHERE id = ?";

        $returned_stmt = $this->connect->prepare($query);
        if (!$returned_stmt) {
            return false;
        }
        $returned_stmt->bind_param('i', $this->id);
        return $returned_stmt->execute();
    }

    /**
     * @return mixed
     */
    public function getBanned()
    {
        return $this->banned;
    }

    /**
     * @param mixed $banned 
     * @return self
     */
    public function setBanned($banned): self
    {
        $this->banned = $banned;
        return $this;
    }
}
