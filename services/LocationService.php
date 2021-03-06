<?php
include_once($_SERVER['DOCUMENT_ROOT'].'/salesteamapp/config.php');
include_once($_SERVER['DOCUMENT_ROOT'].'/salesteamapp/utility/DatabaseManager.php');
include_once($_SERVER['DOCUMENT_ROOT'].'/salesteamapp/models/Country.php');
include_once($_SERVER['DOCUMENT_ROOT'].'/salesteamapp/models/State.php');
include_once($_SERVER['DOCUMENT_ROOT'].'/salesteamapp/models/City.php');

class LocationService {

    private $databaseManager;
    private $connection;

    public function __construct() {
        $this->databaseManager = new DatabaseManager();
        $this->connection = $this->databaseManager->getConnection();
    }

    public function checkCountry($country) {
        $stmt = $this->connection->prepare("select * from countries where country_name = ?");
        $stmt->bind_param("s", $country);
        $stmt->execute();
        $res = $stmt->get_result();
        $stmt->close();
        if($res->num_rows > 0) {
            return false;
        } else {
            return true;
        }
    }

    public function saveCountry($country) {
        $stmt = $this->connection->prepare("insert into countries(country_name) values(?)");
        $stmt->bind_param("s", $country);
        $stmt->execute();
        $stmt->close();
    }

    public function checkState($country, $state) {
        $stmt = $this->connection->prepare("select * from states where country_id = ? and state_name = ?");
        $stmt->bind_param("is", $country, $state);
        $stmt->execute();
        $res = $stmt->get_result();
        $stmt->close();
        if($res->num_rows > 0) {
            return false;
        } else {
            return true;
        }
    }

    public function saveState($country, $state) {
        $stmt = $this->connection->prepare("insert into states (country_id, state_name) values (?, ?)");
        $stmt->bind_param("is", $country, $state);
        $stmt->execute();
        $stmt->close();
    }

    public function checkCity($country, $state, $city) {
        $stmt = $this->connection->prepare("select * from cities where country_id = ? and state_id = ? and city_name = ?");
        $stmt->bind_param("iis", $country, $state, $city);
        $stmt->execute();
        $res = $stmt->get_result();
        $stmt->close();
        if($res->num_rows > 0) {
            return false;
        } else {
            return true;
        }
    }

    public function saveCity($country, $state, $city) {
        $stmt = $this->connection->prepare("insert into cities (country_id, state_id, city_name) values (?, ?, ?)");
        $stmt->bind_param("iis", $country, $state, $city);
        $stmt->execute();
        $stmt->close();
    }

    public function getAllCountries() {
        $stmt = $this->connection->prepare("select * from countries");
        $stmt->execute();
        $res = $stmt->get_result();
        $listOfCountries = array();
        while($row = $res->fetch_assoc()) {
            $country = new Country();
            $country->setId($row['country_id']);
            $country->setName($row['country_name']);
            array_push($listOfCountries, $country);
        }
        $stmt->close();
        return $listOfCountries;
    }

    public function getAllStates() {
        $stmt = $this->connection->prepare("select * from states");
        $stmt->execute();
        $res = $stmt->get_result();
        $listOfStates = array();
        while($row = $res->fetch_assoc()) {
            $state = new State();
            $state->setId($row['state_id']);
            $state->setName($row['state_name']);
            $state->setCountry($row['country_id']);
            array_push($listOfStates, $state);
        }
        $stmt->close();
        return $listOfStates;
    }

    public function getAllCities() {
        $stmt = $this->connection->prepare("select * from cities");
        $stmt->execute();
        $res = $stmt->get_result();
        $listOfCities = array();
        while($row = $res->fetch_assoc()) {
            $city = new City();
            $city->setId($row['city_id']);
            $city->setName($row['city_name']);
            $city->setState($row['state_id']);
            $city->setCountry($row['country_id']);
            array_push($listOfCities, $city);
        }
        $stmt->close();
        return $listOfCities;
    }

    public function getAllStatesByCountryId($countryId) {
        $stmt = $this->connection->prepare("select * from states where country_id = ?");
        $stmt->bind_param("i", $countryId);
        $stmt->execute();
        $res = $stmt->get_result();
        $listOfStates = array();
        while($row = $res->fetch_assoc()) {
            $state = new State();
            $state->setId($row['state_id']);
            $state->setName($row['state_name']);
            $state->setCountry($row['country_id']);
            array_push($listOfStates, $state);
        }
        $stmt->close();
        return $listOfStates;
    }

}