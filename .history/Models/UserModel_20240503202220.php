<?php
class UserModel extends BaseModel {
    public function getAll($table, $select = ['*'], $orderBys = [], $limit = -1)
    {
        return $this->all($table, $select, $orderBys, $limit);
    }

    public function login($username) {
        $sql = "SELECT * FROM Users WHERE Gmail = '${username}'";
        $this->_query($sql);
    }
}