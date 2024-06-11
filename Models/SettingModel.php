<?php
class SettingModel extends BaseModel
{
    public function getAll($table, $select = ['*'], $orderBys = [], $limit = -1)
    {
        return $this->all($table, $select, $orderBys, $limit);
    }

    public function insertData($table, $data = [])
    {
        if ($this->addData($table, $data)) {
            return $this->connect->insert_id;
        }
        return false;
    }

    public function userInfo($id)
    {
        $sql = "SELECT u.*, p.PositionName, d.DepartmentName FROM Users u LEFT JOIN Positions p ON u.PositionID = p.PositionID LEFT JOIN Departments d ON u.DepartmentID = d.DepartmentID WHERE UserID = ${id}";
        return $this->getData($sql);
    }

    public function updateAvatar($avatar) {
        $update = "UPDATE Users SET Avatar = '{$avatar}' WHERE UserID = '{$_SESSION["UserInfo"][0]["UserID"]}'";
        return $this->_query($update);
    }

    public function changePassword($password) {
        $update = "UPDATE Users SET Password = '{$password}' WHERE UserID = '{$_SESSION["UserInfo"][0]["UserID"]}'";
        return $this->_query($update);
    }
}
