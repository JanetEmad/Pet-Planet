<?php

namespace App\Database\Models;

use App\Database\Models\Contract\MakeCrud;
use App\Database\Models\Model;

class VST_Reservation extends Model implements MakeCrud
{
    private $id,
        $come_at,
        $leave_at,
        $date,
        $total_price,
        $user_id,
        $service_provider_id,
        $clinic_id;


    public function create(): bool
    {
        $query = "INSERT INTO vst_reservations (come_at, leave_at, date, user_id, service_provider_id, total_price, clinic_id) 
        
        VALUES (? , ? , ? , ? , ? ,? , ?)";

        $returned_stmt = $this->connect->prepare($query);
        if (!$returned_stmt) {
            return false;
        }

        $returned_stmt->bind_param(
            'sssiidi',
            $this->come_at,
            $this->leave_at,
            $this->date,
            $this->user_id,
            $this->service_provider_id,
            $this->total_price,
            $this->clinic_id
        );
        return $returned_stmt->execute();
    }

    public function read(): array
    {
        $query = "SELECT r.*,u.first_name AS userFirstName, u.last_name AS userLastName
        FROM vst_reservations AS r
        JOIN users AS u ON r.user_id=u.id
        WHERE r.service_provider_id=?";

        $returned_stmt = $this->connect->prepare($query);
        $returned_stmt->bind_param(
            'i',
            $this->service_provider_id
        );
        $returned_stmt->execute();

        $result = $returned_stmt->get_result();
        $reservations = $result->fetch_all(MYSQLI_ASSOC);
        return $reservations;
    }

    public function viewSTAppointments($user_id): array
    {

        // Retrieve the service_provider_id based on the user_id
        $query = "SELECT id FROM serviceproviders WHERE user_id = ?";
        $stmt = $this->connect->prepare($query);
        $stmt->bind_param('i', $user_id);
        $stmt->execute();
        $result = $stmt->get_result();
        $row = $result->fetch_assoc();
        $service_provider_id = $row['id'];

        $query = "SELECT v.*, u.first_name AS userFirstName, u.last_name AS userLastName
                  FROM vst_reservations AS v
                  JOIN users AS u ON v.user_id = u.id
                  JOIN serviceproviders AS s ON s.id = v.service_provider_id
                  WHERE v.service_provider_id = ?";

        $returned_stmt = $this->connect->prepare($query);
        $returned_stmt->bind_param('i', $service_provider_id);
        $returned_stmt->execute();

        $result = $returned_stmt->get_result();
        $appointments = $result->fetch_all(MYSQLI_ASSOC);
        return $appointments;
    }

    public function viewVetAppointments($user_id, $clinic_id): array
    {

        // Retrieve the service_provider_id based on the user_id
        $query = "SELECT id FROM serviceproviders WHERE user_id = ?";
        $stmt = $this->connect->prepare($query);
        $stmt->bind_param('i', $user_id);
        $stmt->execute();
        $result = $stmt->get_result();
        $row = $result->fetch_assoc();
        $service_provider_id = $row['id'];

        $query = "SELECT v.*, u.first_name AS userFirstName, u.last_name AS userLastName, c.name AS clinicName
                  FROM vst_reservations AS v
                  JOIN users AS u ON v.user_id = u.id
                  JOIN clinics AS c ON v.clinic_id = c.id
                  JOIN serviceproviders AS s ON s.id = v.service_provider_id
                  WHERE v.service_provider_id = ? AND v.clinic_id = ?";

        $returned_stmt = $this->connect->prepare($query);
        $returned_stmt->bind_param('ii', $service_provider_id, $clinic_id);
        $returned_stmt->execute();

        $result = $returned_stmt->get_result();
        $appointments = $result->fetch_all(MYSQLI_ASSOC);
        return $appointments;
    }


    public function delete(): bool
    {
        # code...
    }

    public function update(): bool
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
     * Get the value of come_at
     */
    public function getCome_at()
    {
        return $this->come_at;
    }

    /**
     * Set the value of come_at
     *
     * @return  self
     */
    public function setCome_at($come_at)
    {
        $this->come_at = $come_at;

        return $this;
    }

    /**
     * Get the value of leave_at
     */
    public function getLeave_at()
    {
        return $this->leave_at;
    }

    /**
     * Set the value of leave_at
     *
     * @return  self
     */
    public function setLeave_at($leave_at)
    {
        $this->leave_at = $leave_at;

        return $this;
    }

    /**
     * Get the value of date
     */
    public function getDate()
    {
        return $this->date;
    }

    /**
     * Set the value of date
     *
     * @return  self
     */
    public function setDate($date)
    {
        $this->date = $date;

        return $this;
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
     * Get the value of service_provider_id
     */
    public function getService_provider_id()
    {
        return $this->service_provider_id;
    }

    /**
     * Set the value of service_provider_id
     *
     * @return  self
     */
    public function setService_provider_id($service_provider_id)
    {
        $this->service_provider_id = $service_provider_id;

        return $this;
    }

    /**
     * Get the value of clinic_id
     */
    public function getClinic_id()
    {
        return $this->clinic_id;
    }

    /**
     * Set the value of clinic_id
     *
     * @return  self
     */
    public function setClinic_id($clinic_id)
    {
        $this->clinic_id = $clinic_id;

        return $this;
    }
}
