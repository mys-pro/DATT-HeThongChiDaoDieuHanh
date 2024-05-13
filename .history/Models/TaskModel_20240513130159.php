<?php
class TaskModel extends BaseModel
{
    // const TABLE = 'statistical';

    public function getAll($table, $select = ['*'], $orderBys = [], $limit = -1)
    {
        return $this->all($table, $select, $orderBys, $limit);
    }

    public function statistical($priority = 0, $date = 'YEAR', $dateStart = 0, $dateEnd = 0)
    {
        $sql = "SELECT d.DepartmentName, COUNT(tp.TaskID) AS 'Tổng công việc',
            SUM(CASE WHEN tp.Status = 'Hoàn thành trước hạn' THEN 1 ELSE 0 END) AS 'Hoàn thành trước hạn',
            SUM(CASE WHEN tp.Status = 'Hoàn thành' THEN 1 ELSE 0 END) AS 'Hoàn thành đúng hạn',
            SUM(CASE WHEN tp.Status = 'Hoàn thành trễ hạn' THEN 1 ELSE 0 END) AS 'Hoàn thành trễ hạn',
            SUM(CASE WHEN tp.Status = 'Chờ duyệt' THEN 1 ELSE 0 END) AS 'Chờ duyệt',
            SUM(CASE WHEN tp.Status NOT IN ('Hoàn thành trước hạn', 'Hoàn thành', 'Hoàn thành trễ hạn', 'Chờ duyệt') THEN 1 ELSE 0 END) AS 'Chưa hoàn thành'
            FROM Tasks t JOIN TaskPerformers tp ON t.TaskID = tp.TaskID JOIN Users u ON tp.UserID = u.UserID 
            RIGHT JOIN Departments d ON u.DepartmentID = d.DepartmentID";

        switch ($date) {
            case "YEAR": {
                    $sql .= " AND YEAR(tp.DateStart) = YEAR(CURRENT_DATE)";
                    break;
                }

            case "MONTH": {
                    $sql .= " AND MONTH(tp.DateStart) = MONTH(CURRENT_DATE)";
                    break;
                }

            case "DATE": {
                    if ($dateStart != 0 && $dateEnd == 0) {
                        $sql .= " AND tp.DateStart = '${dateStart}'";
                    } else if ($dateStart != 0 && $dateEnd != 0) {
                        $sql .= " AND tp.DateStart BETWEEN '${dateStart}' AND '${dateEnd}'";
                    }
                    break;
                }
        }

        if ($priority != 0 && $priority != null) {
            $sql .= " AND t.Priority = ${priority}";
        }

        $sql .= " GROUP BY d.DepartmentID";

        echo $sql;
        die();
        return $this->getData($sql);
    }

    public function report($departmentID = 0, $date = 'YEAR', $dateStart = 0, $dateEnd = 0)
    {
        $where = array();
        $sql = "SELECT t.TaskName, d.DepartmentName, tp.Reviewer, DATE_FORMAT(t.DateCreated, '%d-%m-%Y') AS DateCreated, DATE_FORMAT(DATE_ADD(t.DateCreated, INTERVAL t.Deadline DAY), '%d-%m-%Y') AS ExpectedDate, t.Status
            FROM Tasks t JOIN TaskPerformers tp ON t.TaskID = tp.TaskID JOIN Users u ON tp.UserID = u.UserID JOIN Departments d ON u.DepartmentID = d.DepartmentID";

        if ($departmentID != 0 && $departmentID != null) {
            array_push($where, "d.DepartmentID = ${departmentID}");
        }

        switch ($date) {
            case "YEAR": {
                    array_push($where, "YEAR(t.DateCreated) = YEAR(CURRENT_DATE)");
                    break;
                }

            case "MONTH": {
                    array_push($where, "MONTH(t.DateCreated) = MONTH(CURRENT_DATE)");
                    break;
                }

            case "DATE": {
                    if ($dateStart != 0 && $dateEnd == 0) {
                        array_push($where, "t.DateCreated = '${dateStart}'");
                    } else if ($dateStart != 0 && $dateEnd != 0) {
                        array_push($where, "t.DateCreated BETWEEN '${dateStart}' AND '${dateEnd}'");
                    }
                    break;
                }
        }

        if(!empty($where)) {
            foreach($where as $index => $value) {
                if($index == 0) {
                    $sql .= " WHERE ${value}";
                } else {
                    $sql .= " AND ${value}";
                }
            }
        }

        return $this->getData($sql);
    }

    public function getTaskByID($id = 0)
    {
        $sql = "SELECT * FROM Tasks WHERE AssignedBy = ${id}";
        return $this->getData($sql);
    }

    public function getTaskPerformers($TaskID = 0, $UserID = 0)
    {
        $sql = "SELECT t.TaskName, tp.* FROM Tasks t JOIN TaskPerformers tp ON t.TaskID = tp.TaskID WHERE tp.TaskID = ${TaskID} AND UserID = ${UserID}";
        return $this->getData($sql);
    }

    public function getUserByID($UserID = 0)
    {
        $sql = "SELECT * FROM Users WHERE UserID = ${UserID}";
        return $this->getData($sql);
    }

    public function getPositionByID($id = 0)
    {
        $sql = "SELECT * FROM Positions WHERE PositionID = ${id}";
        return $this->getData($sql);
    }

    public function getDepartmentByID($id)
    {
        $id = isset($id) ? $id : 0;
        $sql = "SELECT * FROM Departments WHERE DepartmentID = ${id}";
        return $this->getData($sql);
    }
}
