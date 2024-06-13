<?php
class AdminModel extends BaseModel
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

    public function getDepartmentByName($name)
    {
        $sql = "SELECT * FROM Departments WHERE DepartmentName LIKE '%{$name}%'";
        return $this->getData($sql);
    }

    public function getDepartmentById($id)
    {
        $sql = "SELECT * FROM Departments WHERE DepartmentID = '{$id}'";
        return $this->getData($sql);
    }

    public function updateDepartment($id, $name)
    {
        $sql = "UPDATE Departments SET DepartmentName = '{$name}' WHERE DepartmentID = {$id}";
        return $this->_query($sql);
    }

    public function deleteDepartment($id)
    {
        $sql = "DELETE FROM Departments WHERE DepartmentID = {$id}";
        return $this->_query($sql);
    }

    public function getPositionByName($name)
    {
        $sql = "SELECT * FROM Positions WHERE PositionName LIKE '%{$name}%'";
        return $this->getData($sql);
    }

    public function getPositionByID($id)
    {
        $sql = "SELECT * FROM Positions WHERE PositionID = '{$id}'";
        return $this->getData($sql);
    }

    public function updatePosition($id, $name, $description)
    {
        $sql = "UPDATE Positions SET PositionName = '{$name}', Description = '{$description}' WHERE PositionID = {$id}";
        return $this->_query($sql);
    }

    public function deletePosition($id)
    {
        $sql = "DELETE FROM Positions WHERE PositionID = {$id}";
        return $this->_query($sql);
    }

    public function getUser()
    {
        $sql = "SELECT u.*, p.PositionName, d.DepartmentName FROM Users u LEFT JOIN Positions p ON u.PositionID = p.PositionID LEFT JOIN Departments d ON u.DepartmentID = d.DepartmentID WHERE UserID != {$_SESSION["UserInfo"][0]["UserID"]} GROUP BY u.UserID";
        return $this->getData($sql);
    }

    public function getUserById($id)
    {
        $sql = "SELECT u.*, p.PositionName, d.DepartmentName FROM Users u LEFT JOIN Positions p ON u.PositionID = p.PositionID LEFT JOIN Departments d ON u.DepartmentID = d.DepartmentID WHERE UserID = {$id} GROUP BY u.UserID";
        return $this->getData($sql);
    }

    public function getUserByGmail($gmail)
    {
        $sql = "SELECT u.*, p.PositionName, d.DepartmentName FROM Users u LEFT JOIN Positions p ON u.PositionID = p.PositionID LEFT JOIN Departments d ON u.DepartmentID = d.DepartmentID WHERE u.Gmail = '{$gmail}' GROUP BY u.UserID";
        return $this->getData($sql);
    }

    public function getRoleByUserID($id)
    {
        $sql = "SELECT * FROM Permissions WHERE UserID = {$id}";
        return $this->getData($sql);
    }

    public function getUserByName($name)
    {
        $sql = "SELECT u.*, p.PositionName, d.DepartmentName FROM Users u LEFT JOIN Positions p ON u.PositionID = p.PositionID LEFT JOIN Departments d ON u.DepartmentID = d.DepartmentID WHERE UserID != {$_SESSION["UserInfo"][0]["UserID"]} AND FullName LIKE '%{$name}%'";
        return $this->getData($sql);
    }

    public function addUser($name, $position, $department, $gmail, $phone, $roles = [])
    {
        mysqli_begin_transaction($this->connect);
        try {
            $position = empty($position) ? "NULL" : "'" . $position . "'";
            $department = empty($department) ? "NULL" : "'" . $department . "'";

            $avatar = addslashes(file_get_contents(getWebRoot() . "/Public/Image/avatar-default.jpg"));
            $insert1 = $this->addData("Users", ["NULL", "'{$avatar}'", "'{$name}'", "'{$gmail}'", "NULL", "'{$phone}'", "'0'", "NULL", "current_timestamp()","{$position}", "{$department}"]);
            if ($insert1) {
                $userID = $this->connect->insert_id;
                foreach ($roles as $value) {
                    $insert2 = $this->addData("Permissions", ["'{$value}'", "'{$userID}'"]);
                    if (!$insert2) {
                        mysqli_rollback($this->connect);
                        return false;
                    }
                }

                mysqli_commit($this->connect);
                return $userID;
            } else {
                mysqli_rollback($this->connect);
                return false;
            }
        } catch (Exception $e) {
            mysqli_rollback($this->connect);
            return false;
        }
    }

    public function deleteUser($id)
    {
        mysqli_begin_transaction($this->connect);
        try {
            $delete1 = "DELETE FROM Permissions WHERE UserID = {$id}";
            $delete2 = "DELETE FROM Users WHERE UserID = {$id}";
            if ($this->_query($delete1) && $this->_query($delete2)) {
                mysqli_commit($this->connect);
                return true;
            } else {
                mysqli_rollback($this->connect);
                return false;
            }
        } catch (Exception $e) {
            mysqli_rollback($this->connect);
            return false;
        }
    }

    public function updateUser($id, $name, $position, $department, $phone, $roles = [])
    {
        mysqli_begin_transaction($this->connect);
        try {
            $position = empty($position) ? "NULL" : "'" . $position . "'";
            $department = empty($department) ? "NULL" : "'" . $department . "'";

            $updateUser = "UPDATE Users SET FullName = '{$name}', PhoneNumber = '{$phone}', PositionID = {$position}, DepartmentID = {$department} WHERE UserID = {$id}";

            if ($this->_query($updateUser)) {
                $permissionList = $this->getRoleByUserID($id);
                $permissions = [];
                foreach ($permissionList as $value) {
                    $permissions[] = $value['RoleID'];
                }

                $permissions_to_delete = array_diff($permissions, $roles);
                foreach ($permissions_to_delete as $value) {
                    $deletePermission = "DELETE FROM Permissions WHERE UserID = '{$id}' AND RoleID = '{$value}'";
                    if (!$this->_query($deletePermission)) {
                        mysqli_rollback($this->connect);
                        return false;
                    }
                }

                $permissions_to_add = array_diff($roles, $permissions);
                foreach ($permissions_to_add as $value) {
                    $addPermission = $this->addData("Permissions", ["'{$value}'", "'{$id}'"]);
                    if (!$addPermission) {
                        mysqli_rollback($this->connect);
                        return false;
                    }
                }
                mysqli_commit($this->connect);
                return true;
            } else {
                return false;
            }
        } catch (Exception $e) {
            mysqli_rollback($this->connect);
            return false;
        }
    }
}
