<?php

namespace App\Database\Models;

use App\Database\Models\Contract\MakeCrud;
use App\Database\Models\Model;

class Petreport extends Model implements MakeCrud
{
    private $date,
        $location,
        $situation_description;

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
     * Get the value of location
     */
    public function getLocation()
    {
        return $this->location;
    }

    /**
     * Set the value of location
     *
     * @return  self
     */
    public function setLocation($location)
    {
        $this->location = $location;

        return $this;
    }

    /**
     * Get the value of situation_description
     */
    public function getSituation_description()
    {
        return $this->situation_description;
    }

    /**
     * Set the value of situation_description
     *
     * @return  self
     */
    public function setSituation_description($situation_description)
    {
        $this->situation_description = $situation_description;

        return $this;
    }

    public function create(): bool
    {
        $query = "INSERT INTO petreports(date,location,situation_description) VALUES (? , ? , ?)";

        $returned_stmt = $this->connect->prepare($query);
        if (!$returned_stmt) {
            return false;
        }

        $returned_stmt->bind_param('sss', $this->date, $this->location, $this->situation_description);

        return $returned_stmt->execute();
    }

    public function read(): array
    {
        $query = "SELECT date,location,situation_description FROM petreports ORDER BY id DESC";

        $returned_stmt = $this->connect->prepare($query);
        $returned_stmt->execute();

        $result = $returned_stmt->get_result();
        $reports = $result->fetch_all(MYSQLI_ASSOC);
        return $reports;
    }

    public function update(): bool
    {
        # code...
    }

    public function delete(): bool
    {
        # code...
    }

    function readO(): \mysqli_result
    {
        #code
    }
}
