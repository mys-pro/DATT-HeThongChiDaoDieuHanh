<?php
class UserModel extends BaseModel {
    public function getAll($table, $select = ['*'], $orderBys = [], $limit = -1)
    {
        return $this->all($table, $select, $orderBys, $limit);
    }

    public function login($username) {
        $sql = "SELECT UserID, Password FROM Users WHERE Gmail = '${username}'";
        return $this->getData($sql);
    }

    public function userInfo($id) {
        $sql = "SELECT * FROM Users WHERE UserID = ${id}";
        return $this->getData($sql);
    }

    public function getIDbySha1($sha1) {
        $data = $this->getAll("Users");
        foreach ($data as $user) {
            if (sha1($user['UserID']) == $sha1) {
                return $user['UserID'];
            }
        }
        return -1;
    }

    public function updateForgotToken($id, $verify) {

    }
}