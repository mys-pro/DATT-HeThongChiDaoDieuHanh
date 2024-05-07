<?php
class Database {
    const HOST = "localhost";
    const USERNAME = "root";
    const PASSWORD = "";
    const DB_NAME = "direct_operator";

    private $connect;

    public function connect() {
        $this->connect = mysqli_connect(self::HOST, self::USERNAME, self::PASSWORD, self::DB_NAME);
    }
}