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
            SUM(CASE WHEN tp.Status NOT IN ('Hoàn thành trước hạn', 'Hoàn thành', 'Hoàn thành trễ hạn', 'Chờ duyệt') THEN 1 ELSE 0 END) AS 'Chưa hoàn thành',
            SUM(CASE WHEN DATE_ADD(tp.DateStart, INTERVAL tp.Deadline DAY) < NOW() AND tp.Status NOT LIKE 'Hoàn thành%' THEN 1 ELSE 0 END) AS 'Quá hạn'
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

        if (!empty($where)) {
            foreach ($where as $index => $value) {
                if ($index == 0) {
                    $sql .= " WHERE ${value}";
                } else {
                    $sql .= " AND ${value}";
                }
            }
        }

        return $this->getData($sql);
    }

    public function getTask()
    {
        $sql = "SELECT *, 
        CASE 
            WHEN DATE_ADD(DateCreated, INTERVAL Deadline DAY) < NOW() AND Status NOT LIKE 'Hoàn thành%' THEN 'Quá hạn' 
            ELSE Status 
        END AS StatusTask
        FROM Tasks";
        return $this->getData($sql);
    }

    public function getTaskByID($id = 0)
    {
        $sql = "SELECT *, 
        CASE 
            WHEN DATE_ADD(DateCreated, INTERVAL Deadline DAY) < NOW() AND Status NOT LIKE 'Hoàn thành%' THEN 'Quá hạn' 
            ELSE Status 
        END AS StatusTask
        FROM Tasks
        WHERE AssignedBy = ${id}";
        return $this->getData($sql);
    }

    public function getTaskByName($name = null)
    {
        $sql = "SELECT *, 
        CASE 
            WHEN DATE_ADD(DateCreated, INTERVAL Deadline DAY) < NOW() AND Status NOT LIKE 'Hoàn thành%' THEN 'Quá hạn' 
            ELSE Status 
        END AS StatusTask
        FROM Tasks";
        if ($name != null && $name != "") {
            $sql .= " WHERE TaskName LIKE '%${name}%'";
        }

        return $this->getData($sql);
    }

    public function getTaskPerformers($TaskID = 0, $UserID = 0)
    {
        $sql = "SELECT t.TaskName, tp.*, 
        CASE 
            WHEN DATE_ADD(tp.DateStart, INTERVAL tp.Deadline DAY) < NOW() AND tp.Status NOT LIKE 'Hoàn thành%' AND tp.Status != 'Chờ duyệt' THEN 'Quá hạn' 
            ELSE tp.Status 
        END AS StatusPerformer
        FROM Tasks t JOIN TaskPerformers tp ON t.TaskID = tp.TaskID 
        WHERE tp.TaskID = ${TaskID} AND UserID = ${UserID}";
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

    public function getDocumentByTaskID($id)
    {
        $sql = "SELECT * FROM Documents WHERE TaskID = ${id} ORDER BY DocumentID desc";
        return $this->getData($sql);
    }

    public function getDocumentByID($id)
    {
        $sql = "SELECT * FROM Documents WHERE DocumentID = ${id}";
        return $this->getData($sql);
    }

    public function insertData($table, $data = [])
    {
        return $this->addData($table, $data);
    }

    public function viewTask($id)
    {
        $sql = "SELECT t.TaskID, 
        t.TaskName, 
        t.Description, 
        t.Priority, 
        t.Progress AS ProgressTask, 
        CASE 
            WHEN DATE_ADD(t.DateCreated, INTERVAL t.Deadline DAY) < NOW() AND t.Status NOT LIKE 'Hoàn thành'
            THEN 'Quá hạn' 
        ELSE t.Status END AS StatusTask, 
        t.Deadline AS DeadlineTask, 
        u.Avatar, u.FullName, 
        p.PositionName, 
        d.DepartmentName, 
        tp.UserID, 
        tp.Deadline AS DeadlineTaskPerformers, 
        tp.Progress AS ProgressTaskPerformers, 
        tp.Reviewer, 
        CASE 
            WHEN (tp.DateStart IS NULL AND DATE_ADD(t.DateCreated, INTERVAL t.Deadline DAY) < NOW() AND tp.Status NOT LIKE 'Hoàn thành%') AND tp.Status != 'Chờ duyệt'
            OR (tp.DateStart IS NOT NULL AND DATE_ADD(tp.DateStart, INTERVAL tp.Deadline DAY) < NOW() AND tp.Status NOT LIKE 'Hoàn thành%') AND tp.Status != 'Chờ duyệt'
               THEN 'Quá hạn'
            ELSE tp.Status 
        END AS StatusTaskPerformers,
        tp.Comment 
        FROM Tasks t JOIN Users u ON t.AssignedBy = u.UserID JOIN Positions p ON u.PositionID = p.PositionID LEFT JOIN Departments d ON u.DepartmentID = d.DepartmentID LEFT JOIN TaskPerformers tp ON t.TaskID = tp.TaskID WHERE t.TaskID = ${id}";
        return $this->getData($sql);
    }

    public function deleteTask($id)
    {
        mysqli_begin_transaction($this->connect);
        try {
            $sql1 = "DELETE FROM TaskPerformers WHERE TaskID = ${id}";
            $sql2 = "DELETE FROM Documents WHERE TaskID = ${id}";
            $sql3 = "DELETE FROM Comments WHERE TaskID = ${id}";
            $sql4 = "DELETE FROM Tasks WHERE TaskID = ${id}";

            if ($this->_query($sql1) && $this->_query($sql2) && $this->_query($sql3) && $this->_query($sql4)) {
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

    public function updateTask($data = [])
    {
        mysqli_begin_transaction($this->connect);
        try {
            $sql1 = "UPDATE Tasks SET TaskName='{$data["name"]}', Description='{$data["description"]}', Priority='{$data["priority"]}', Deadline='{$data["deadlineTask"]}' WHERE TaskID = {$data["taskID"]}";
            $sql2 = "UPDATE TaskPerformers SET Deadline='{$data["deadlinePerformer"]}' WHERE TaskID='{$data["taskID"]}' AND Reviewer='0'";
            $sql3 = "UPDATE TaskPerformers SET Deadline='{$data["deadlineReview"]}' WHERE TaskID='{$data["taskID"]}' AND Reviewer='1'";

            $update1 = $this->_query($sql1);
            $update2 = $this->_query($sql2);
            $update3 = $this->_query($sql3);

            $taskPerformers = $this->getTaskPerformers($data["taskID"], $_SESSION["UserInfo"][0]["UserID"]);
            if (count($taskPerformers) > 0) {
                $sql4 = "UPDATE TaskPerformers SET Progress='{$data["progress"]}' WHERE TaskID='{$data["taskID"]}' AND UserID='{$_SESSION["UserInfo"][0]["UserID"]}'";
                $update4 = $this->_query($sql4);

                if ($update1 && $update2 && $update3 && $update4) {
                    mysqli_commit($this->connect);
                    return true;
                }
            }

            if ($update1 && $update2 && $update3) {
                mysqli_commit($this->connect);
                return true;
            }
        } catch (Exception $e) {
            mysqli_rollback($this->connect);
            return false;
        }
    }

    public function sendTask($data = [])
    {
        mysqli_begin_transaction($this->connect);
        try {
            $sql = "UPDATE Tasks SET TaskName='{$data["name"]}', Description='{$data["description"]}', Priority='{$data["priority"]}', Status='Đang thực hiện', Deadline='{$data["deadlineTask"]}' WHERE TaskID = {$data["taskID"]}";
            $insert = $this->_query($sql);

            date_default_timezone_set('Asia/Ho_Chi_Minh');
            $currentDate = date('Y-m-d');
            $taskPerformers = $this->addData("TaskPerformers", ["'{$data["taskID"]}'", "'{$data["taskPerformers"]}'", "'{$currentDate}'", "'{$data["deadlineTaskPerformers"]}'", "''", "'0'", "'0'", "'Đang thực hiện'", "''"]);
            $taskReview = $this->addData("TaskPerformers", ["'{$data["taskID"]}'", "'{$data["taskReview"]}'", "NULL", "'{$data["deadlineReview"]}'", "''", "'0'", "'1'", "'Đang thực hiện'", "''"]);

            if ($insert && $taskPerformers && $taskReview) {
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

    public function removeDocument($id)
    {
        $sql = "DELETE FROM Documents WHERE DocumentID = {$id}";
        return $this->_query($sql);
    }

    public function getCommentByTaskID($id)
    {
        $sql = "SELECT c.*, u.Avatar, u.FullName FROM Comments c JOIN Users u ON c.UserID = u.UserID JOIN Tasks t ON c.TaskID = t.TaskID WHERE t.TaskID = {$id} ORDER BY c.CommentID desc";
        return $this->getData($sql);
    }

    public function removeComment($id)
    {
        $sql = "DELETE FROM Comments WHERE CommentID = {$id}";
        return $this->_query($sql);
    }

    public function sendAppraisal($id, $progress, $idReviewer)
    {
        mysqli_begin_transaction($this->connect);
        try {
            $sql1 = "UPDATE TaskPerformers SET Status='Chờ duyệt', Progress='{$progress}' WHERE TaskID = '{$id}' AND UserID = '{$_SESSION["UserInfo"][0]["UserID"]}' AND Reviewer = '0'";

            $sql2 = "UPDATE TaskPerformers SET DateStart=current_timestamp() WHERE TaskID = '{$id}' AND UserID = '{$idReviewer}' AND Reviewer = '1'";

            if($this->_query($sql1) && $this->_query($sql2)) {
                mysqli_commit($this->connect);
                return true;
            }
        } catch (Exception $e) {
            mysqli_rollback($this->connect);
            return false;
        }
    }

    public function recallTask($id, $idReviewer)
    {
        mysqli_begin_transaction($this->connect);
        try {
            $sql1 = "UPDATE TaskPerformers SET Status='Đang thực hiện' WHERE TaskID = '{$id}' AND UserID = '{$_SESSION["UserInfo"][0]["UserID"]}' AND Reviewer = '0'";

            $sql2 = "UPDATE TaskPerformers SET DateStart=NULL WHERE TaskID = '{$id}' AND UserID = '{$idReviewer}' AND Reviewer = '1'";

            if($this->_query($sql1) && $this->_query($sql2)) {
                mysqli_commit($this->connect);
                return true;
            }
        } catch (Exception $e) {
            mysqli_rollback($this->connect);
            return false;
        }
    }
}
