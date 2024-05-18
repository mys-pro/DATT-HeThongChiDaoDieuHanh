<?php
class DBConfig {
    private $hostname = 'localhost';
    private $username = 'root';
    private $pass = '';
    private $dbname = 'direct_operator';

    private $conn = NULL;
    private $result = NULL;
 
    public function connect() {
        $this->conn = new mysqli($this->hostname, $this->username, $this->pass, $this->dbname);
        if($this->conn) {
            echo "Kết nối thất bại";
            exit();
        } else {
            mysqli_set_charset($this->conn, 'utf8');
        }
        return $this->conn;
    }
}
