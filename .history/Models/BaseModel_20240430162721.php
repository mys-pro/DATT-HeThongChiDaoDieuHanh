<?php
class BaseModel extends Database {
    protected $connect;
    public function __construct() {
        $this->connect = $this->connect();
    }

    public function getAll() {

    }

    
}