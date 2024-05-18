<?php
class UserModel extends BaseModel
{
    public function getAll($table, $select = ['*'], $orderBys = [], $limit = -1)
    {
        return $this->all($table, $select, $orderBys, $limit);
    }

    public function login($username)
    {
        $sql = "SELECT UserID, Password FROM Users WHERE Gmail = '${username}'";
        return $this->getData($sql);
    }

    public function userInfo($id)
    {
        $sql = "SELECT Avatar, FullName, Gmail, PhoneNumber, PositionName, DepartmentName FROM Users u JOIN Positions p ON u.PositionID = p.PositionID LEFT JOIN Departments d ON u.DepartmentID = d.DepartmentID WHERE UserID = ${id}";
        return $this->getData($sql);
    }

    public function getIDbySha1($sha1)
    {
        $data = $this->getAll("Users");
        foreach ($data as $user) {
            if (sha1($user['UserID']) == $sha1) {
                return $user['UserID'];
            }
        }
        return NULL;
    }

    public function updateForgotToken($id, $verify)
    {
        $sql = "UPDATE Users SET ForgotToken = '${verify}' WHERE UserID = ${id}";
        return $this->_query($sql);
    }

    public function updatePassword($id, $password)
    {
        $sql = "UPDATE Users SET Password = '${password}', ForgotToken = NULL WHERE UserID = ${id}";
        return $this->_query($sql);
    }
}