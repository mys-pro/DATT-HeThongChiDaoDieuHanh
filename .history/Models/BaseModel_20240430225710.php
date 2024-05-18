<?php
class BaseModel extends Database {
    protected $connect;
    public function __construct() {
        $this->connect = $this->connect();
    }

    public function all($table, $select = ['*'], $orderBys = [], $limit = -1) {
        $columns = implode(', ', $select);
        $orderByString = implode(' ', $orderBys);
        if($orderByString) {
            if($limit > -1) {
                $sql = "SELECT ${columns} FROM ${table} ORDER BY ${orderByString} LIMIT ${limit}";
            } else {
                $sql = "SELECT ${columns} FROM ${table} ORDER BY ${orderByString}";
            }
        } else {
            if($limit > 0) {
                $sql = "SELECT ${columns} FROM ${table} LIMIT ${limit}";
            } else {
                $sql = "SELECT ${columns} FROM ${table}";
            }
        }
        $query = $this->_query($sql);

        $data = [];
        while($row = mysqli_fetch_assoc($query)) {
            array_push($data, $row);
        }

        return $data;
    }

    public function getData($sql) {
        $query = $this->_query($sql);

        $data = [];
        while($row = mysqli_fetch_assoc($query)) {
            array_push($data, $row);
        }

        return $data;
    }

    private function _query($sql) {
        return mysqli_query($this->connect, $sql);
    }
}