<?php
class UserModel extends BaseModel {
    public function getAll($table, $select = ['*'], $orderBys = [], $limit = -1)
    {
        return $this->all($table, $select, $orderBys, $limit);
    }

    public function login($username, $password) {
        $sql = "SELECT * FROM Users WHERE Gmail = '${account}' AND Password = '${password}'";
        $this->_query($sql);
    }
}