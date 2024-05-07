<?php
class BaseModel extends Database {
    protected $connect;
    public function __construct() {
        $this->connect = $this->connect();
    }

    public function all($table) {

    }

    public function findById($id) {

    }

    public function store() {

    }

    public function update() {

    }

    public function delete() {

    }
}