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
        return NULL;
    }

    public function updateForgotToken($id, $verify) {
        $sql = "UPDATE Users SET ForgotToken = '${verify}' WHERE UserID = ${id}";
        return $this->_query($sql);
    }
    
    public function updatePassword($id, $password) {
        if($id != null && $id != "" && $password != null && $password != "") {
            $userID = $this->getIDbySha1($id);
            $sql = "UPDATE Users SET Password = '${password}' WHERE UserID = ${userID}";
            return $this->_query($sql);
        }
        return 0;
    }
}