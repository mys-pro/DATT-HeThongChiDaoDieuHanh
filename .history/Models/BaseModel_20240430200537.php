<?php
class BaseModel extends Database {
    protected $connect;
    public function __construct() {
        $this->connect = $this->connect();
    }

    public function all($table) {
        $sql = "SELECT * FROM ${table}";
        $query = $this->_query($sql);

        $data = [];
        while($row = mysqli_fetch_assoc($query)) {
            array_push($data, $row);
        }
        
        echo '<pre>';
        print_r($data);
        echo '</pre>';
        die;
    }

    public function findById($id) {

    }

    public function store() {

    }

    public function update() {

    }

    public function delete() {

    }

    private function _query($sql) {
        return mysqli_query($this->connect, $sql);
    }
}