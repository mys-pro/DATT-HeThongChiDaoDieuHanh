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
        $sql = "SELECT t.TaskName, d.DepartmentName, tp.Reviewer, DATE_FORMAT(t.DateStart, '%d-%m-%Y') AS DateStart, DATE_FORMAT(DATE_ADD(t.DateStart, INTERVAL t.Deadline DAY) - 1, '%d-%m-%Y') AS ExpectedDate, t.Status
            FROM Tasks t JOIN TaskPerformers tp ON t.TaskID = tp.TaskID JOIN Users u ON tp.UserID = u.UserID JOIN Departments d ON u.DepartmentID = d.DepartmentID";

        if ($departmentID != 0 && $departmentID != null) {
            array_push($where, "d.DepartmentID = ${departmentID}");
        }

        switch ($date) {
            case "YEAR": {
                    array_push($where, "YEAR(t.DateStart) = YEAR(CURRENT_DATE)");
                    break;
                }

            case "MONTH": {
                    array_push($where, "MONTH(t.DateStart) = MONTH(CURRENT_DATE)");
                    break;
                }

            case "DATE": {
                    if ($dateStart != 0 && $dateEnd == 0) {
                        array_push($where, "t.DateStart = '${dateStart}'");
                    } else if ($dateStart != 0 && $dateEnd != 0) {
                        array_push($where, "t.DateStart BETWEEN '${dateStart}' AND '${dateEnd}'");
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
            WHEN DATE_ADD(DateStart, INTERVAL Deadline DAY) < NOW() AND Status NOT LIKE 'Hoàn thành%' AND Status NOT LIKE 'Dự thảo' THEN 'Quá hạn' 
            ELSE Status 
        END AS StatusTask
        FROM Tasks";
        return $this->getData($sql);
    }

    public function getNotifyByID($id)
    {
        $sql = "SELECT u.Avatar, u.FullName, n.* FROM Notifies n JOIN Users u ON n.UserBy = u.UserID WHERE n.UserID = ${id} ORDER BY n.Watched ASC, n.NotifyId DESC";

        return $this->getData($sql);
    }

    public function getTaskByID($id = 0)
    {
        $sql = "SELECT *, 
        CASE 
            WHEN DATE_ADD(DateStart, INTERVAL Deadline DAY) < NOW() AND Status NOT LIKE 'Hoàn thành%' AND Status NOT LIKE 'Dự thảo' THEN 'Quá hạn' 
            ELSE Status 
        END AS StatusTask
        FROM Tasks
        WHERE AssignedBy = ${id}";
        return $this->getData($sql);
    }

    public function getTaskByIdTask($id = 0)
    {
        $sql = "SELECT *, 
        CASE 
            WHEN DATE_ADD(DateStart, INTERVAL Deadline DAY) < NOW() AND Status NOT LIKE 'Hoàn thành%' AND Status NOT LIKE 'Dự thảo' THEN 'Quá hạn' 
            ELSE Status 
        END AS StatusTask
        FROM Tasks
        WHERE TaskID = ${id}";
        return $this->getData($sql);
    }

    public function getTaskByParentTask($id = 0)
    {
        $sql = "SELECT *, 
        CASE 
            WHEN DATE_ADD(DateStart, INTERVAL Deadline DAY) < NOW() AND Status NOT LIKE 'Hoàn thành%' AND Status NOT LIKE 'Dự thảo' THEN 'Quá hạn' 
            ELSE Status 
        END AS StatusTask
        FROM Tasks
        WHERE ParentTaskID = ${id}";
        return $this->getData($sql);
    }

    public function getTaskByName($name = null)
    {
        $sql = "SELECT *, 
        CASE 
            WHEN DATE_ADD(DateStart, INTERVAL Deadline DAY) < NOW() AND Status NOT LIKE 'Hoàn thành%' AND Status NOT LIKE 'Dự thảo' THEN 'Quá hạn' 
            ELSE Status 
        END AS StatusTask
        FROM Tasks WHERE ParentTaskID IS NULL";
        if ($name != null && $name != "") {
            $sql .= " AND TaskName LIKE '%${name}%'";
        }

        return $this->getData($sql);
    }

    public function getSubTask()
    {
        $sql = "SELECT *, 
        CASE 
            WHEN DATE_ADD(DateStart, INTERVAL Deadline DAY) < NOW() AND Status NOT LIKE 'Hoàn thành%' AND Status NOT LIKE 'Dự thảo' THEN 'Quá hạn' 
            ELSE Status 
        END AS StatusTask
        FROM Tasks
        WHERE ParentTaskID IS NOT NULL";
        return $this->getData($sql);
    }

    public function getTaskPerformers($TaskID = 0, $UserID = 0)
    {
        $sql = "SELECT t.TaskName, tp.*, 
        CASE 
            WHEN DATE_ADD(tp.DateStart, INTERVAL tp.Deadline DAY) < NOW() AND tp.Status NOT LIKE 'Hoàn thành%' AND tp.Status NOT LIKE 'Dự thảo' AND tp.Status != 'Chờ duyệt' AND tp.Status != 'Từ chối phê duyệt' THEN 'Quá hạn' 
            ELSE tp.Status 
        END AS StatusPerformer
        FROM Tasks t JOIN TaskPerformers tp ON t.TaskID = tp.TaskID 
        WHERE tp.TaskID = ${TaskID} AND UserID = ${UserID}";
        return $this->getData($sql);
    }

    public function getTaskPerformersByTaskId($TaskID = 0)
    {
        $sql = "SELECT *,  
        CASE 
            WHEN DATE_ADD(DateStart, INTERVAL Deadline DAY) < NOW() AND Status NOT LIKE 'Hoàn thành%' AND Status NOT LIKE 'Dự thảo' AND Status != 'Chờ duyệt' AND Status != 'Từ chối phê duyệt' THEN 'Quá hạn' 
            ELSE Status 
        END AS StatusPerformer 
        FROM TaskPerformers WHERE TaskID = {$TaskID}";
        return $this->getData($sql);
    }

    public function getTaskPerformersByReviewer($TaskID = 0, $Reviewer)
    {
        $sql = "SELECT * FROM TaskPerformers WHERE TaskID = ${TaskID} AND Reviewer = {$Reviewer}";
        return $this->getData($sql);
    }

    public function getSignatureTaskById($taskID)
    {
        $sql = "
            SELECT t.* 
            FROM Tasks t 
            JOIN TaskPerformers tp ON t.TaskID = tp.TaskID 
            WHERE tp.taskID = '{$taskID}' AND tp.Status = 'Chờ duyệt' AND tp.Reviewer = '1';
        ";
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

    public function updateNotify($id)
    {
        $sql = "UPDATE Notifies SET Watched = 1 WHERE NotifyId = ${id}";
        return $this->_query($sql);
    }

    public function deleteNotify($id)
    {
        $sql = "DELETE FROM Notifies WHERE NotifyId = ${id}";
        return $this->_query($sql);
    }

    public function readNotify($id)
    {
        $sql = "UPDATE Notifies SET Watched = 1 WHERE NotifyId = ${id}";
        return $this->_query($sql);
    }

    public function insertData($table, $data = [])
    {
        if ($this->addData($table, $data)) {
            return $this->connect->insert_id;
        }
        return false;
    }

    public function viewTask($id)
    {
        $sql = "SELECT t.TaskID, 
        t.TaskName, 
        t.Description, 
        t.Priority, 
        t.Progress AS ProgressTask, 
        CASE 
            WHEN DATE_ADD(t.DateStart, INTERVAL t.Deadline DAY) < NOW() AND t.Status NOT LIKE 'Hoàn thành' AND t.Status NOT LIKE 'Dự thảo'
            THEN 'Quá hạn' 
        ELSE t.Status END AS StatusTask, 
        t.Deadline AS DeadlineTask,
        t.AssignedBy,
        u.Avatar, u.FullName, 
        p.PositionName, 
        d.DepartmentName, 
        tp.UserID, 
        tp.Deadline AS DeadlineTaskPerformers, 
        tp.Progress AS ProgressTaskPerformers, 
        tp.Reviewer, 
        CASE 
            WHEN (tp.DateStart IS NULL AND DATE_ADD(t.DateStart, INTERVAL t.Deadline DAY) < NOW() AND tp.Status NOT LIKE 'Hoàn thành%' AND tp.Status NOT LIKE 'Dự thảo') AND tp.Status != 'Chờ duyệt'
            OR (tp.DateStart IS NOT NULL AND DATE_ADD(tp.DateStart, INTERVAL tp.Deadline DAY) < NOW() AND tp.Status NOT LIKE 'Hoàn thành%' AND tp.Status NOT LIKE 'Dự thảo') AND tp.Status != 'Chờ duyệt' AND tp.Status != 'Từ chối phê duyệt'
               THEN 'Quá hạn'
            ELSE tp.Status 
        END AS StatusTaskPerformers,
        tp.Comment 
        FROM Tasks t JOIN Users u ON t.AssignedBy = u.UserID JOIN Positions p ON u.PositionID = p.PositionID LEFT JOIN Departments d ON u.DepartmentID = d.DepartmentID LEFT JOIN TaskPerformers tp ON t.TaskID = tp.TaskID WHERE t.TaskID = ${id}";
        return $this->getData($sql);
    }

    public function deleteTask($id, $idPerformers = NULL, $idReviewer = NULL)
    {
        mysqli_begin_transaction($this->connect);
        try {
            $task = $this->getTaskByIdTask($id);
            $nameTask = $task[0]["TaskName"];
            $link = "/ac/cong-viec";

            $childTasks = $this->getTaskByParentTask($id);
            $countChildTask = count($childTasks);
            $countTrue = 0;

            $sql1 = "DELETE FROM TaskPerformers WHERE TaskID = ${id}";
            $sql2 = "DELETE FROM Documents WHERE TaskID = ${id}";
            $sql3 = "DELETE FROM Comments WHERE TaskID = ${id}";
            $sql4 = "DELETE FROM Tasks WHERE TaskID = ${id}";

            if ($idPerformers != NULL && $idReviewer != NULL) {
                $notifyPerformers = $this->addData("Notifies", ["NULL", "'đã xóa công việc <span class=\"fw-semibold\">{$nameTask}</span>'", "'{$link}'", "'0'", "current_timestamp()", "'{$idPerformers}'", "'{$_SESSION["UserInfo"][0]["UserID"]}'"]);

                $notifyReview = $this->addData("Notifies", ["NULL", "'đã xóa công việc <span class=\"fw-semibold\">{$nameTask}</span>'", "'{$link}'", "'0'", "current_timestamp()", "'{$idReviewer}'", "'{$_SESSION["UserInfo"][0]["UserID"]}'"]);

                if ($notifyPerformers && $notifyReview && $this->_query($sql1) && $this->_query($sql2) && $this->_query($sql3) && $this->_query($sql4)) {
                    if (!empty($childTasks)) {
                        foreach ($childTasks as $value) {
                            $sql1 = "DELETE FROM TaskPerformers WHERE TaskID = {$value["TaskID"]}";
                            $sql2 = "DELETE FROM Documents WHERE TaskID = {$value["TaskID"]}";
                            $sql3 = "DELETE FROM Comments WHERE TaskID = {$value["TaskID"]}";
                            $sql4 = "DELETE FROM Tasks WHERE TaskID = {$value["TaskID"]}";

                            if ($this->_query($sql1) && $this->_query($sql2) && $this->_query($sql3) && $this->_query($sql4)) {
                                $countTrue++;
                            }
                        }
                    }
                    if ($countTrue == $countChildTask) {
                        mysqli_commit($this->connect);
                        $countTrue = 0;
                        return true;
                    } else {
                        mysqli_rollback($this->connect);
                        return false;
                    }
                } else {
                    mysqli_rollback($this->connect);
                    return false;
                }
            } else if ($idPerformers != NULL && $idReviewer == NULL) {
                $notifyPerformers = $this->addData("Notifies", ["NULL", "'đã xóa công việc <span class=\"fw-semibold\">{$nameTask}</span>'", "'{$link}'", "'0'", "current_timestamp()", "'{$idPerformers}'", "'{$_SESSION["UserInfo"][0]["UserID"]}'"]);

                if ($notifyPerformers && $this->_query($sql1) && $this->_query($sql2) && $this->_query($sql3) && $this->_query($sql4)) {
                    if (!empty($childTasks)) {
                        foreach ($childTasks as $value) {
                            $sql1 = "DELETE FROM TaskPerformers WHERE TaskID = {$value["TaskID"]}";
                            $sql2 = "DELETE FROM Documents WHERE TaskID = {$value["TaskID"]}";
                            $sql3 = "DELETE FROM Comments WHERE TaskID = {$value["TaskID"]}";
                            $sql4 = "DELETE FROM Tasks WHERE TaskID = {$value["TaskID"]}";

                            if ($this->_query($sql1) && $this->_query($sql2) && $this->_query($sql3) && $this->_query($sql4)) {
                                $countTrue++;
                            }
                        }
                    }
                    if ($countTrue == $countChildTask) {
                        mysqli_commit($this->connect);
                        $countTrue = 0;
                        return true;
                    } else {
                        mysqli_rollback($this->connect);
                        return false;
                    }
                } else {
                    mysqli_rollback($this->connect);
                    return false;
                }
            } else {
                if ($this->_query($sql1) && $this->_query($sql2) && $this->_query($sql3) && $this->_query($sql4)) {
                    if (!empty($childTasks)) {
                        foreach ($childTasks as $value) {
                            $sql1 = "DELETE FROM TaskPerformers WHERE TaskID = {$value["TaskID"]}";
                            $sql2 = "DELETE FROM Documents WHERE TaskID = {$value["TaskID"]}";
                            $sql3 = "DELETE FROM Comments WHERE TaskID = {$value["TaskID"]}";
                            $sql4 = "DELETE FROM Tasks WHERE TaskID = {$value["TaskID"]}";

                            if ($this->_query($sql1) && $this->_query($sql2) && $this->_query($sql3) && $this->_query($sql4)) {
                                $countTrue++;
                            }
                        }
                    }
                    if ($countTrue == $countChildTask) {
                        mysqli_commit($this->connect);
                        $countTrue = 0;
                        return true;
                    } else {
                        mysqli_rollback($this->connect);
                        return false;
                    }
                } else {
                    mysqli_rollback($this->connect);
                    return false;
                }
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
                } else {
                    mysqli_rollback($this->connect);
                    return false;
                }
            }

            if ($update1 && $update2 && $update3) {
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

    public function updateChildTask($data = [])
    {
        mysqli_begin_transaction($this->connect);
        try {
            $sql1 = "UPDATE Tasks SET TaskName='{$data["name"]}', Description='{$data["description"]}', Priority='{$data["priority"]}', Deadline='{$data["deadlineTask"]}' WHERE TaskID = {$data["taskID"]}";
            $sql2 = "UPDATE TaskPerformers SET Deadline='{$data["deadlinePerformer"]}' WHERE TaskID='{$data["taskID"]}' AND Reviewer='0'";

            $update1 = $this->_query($sql1);
            $update2 = $this->_query($sql2);

            $taskPerformers = $this->getTaskPerformers($data["taskID"], $_SESSION["UserInfo"][0]["UserID"]);
            if (count($taskPerformers) > 0) {
                $sql3 = "UPDATE TaskPerformers SET Progress='{$data["progress"]}' WHERE TaskID='{$data["taskID"]}' AND UserID='{$_SESSION["UserInfo"][0]["UserID"]}'";
                $update3 = $this->_query($sql3);

                if ($update1 && $update2 && $update3) {
                    mysqli_commit($this->connect);
                    return true;
                } else {
                    mysqli_rollback($this->connect);
                    return false;
                }
            }

            if ($update1 && $update2) {
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

    public function sendTask($data = [])
    {
        mysqli_begin_transaction($this->connect);
        try {
            $sql = "UPDATE Tasks SET TaskName='{$data["name"]}', Description='{$data["description"]}', Priority='{$data["priority"]}', Status='Đang thực hiện',DateStart=current_timestamp() , Deadline='{$data["deadlineTask"]}' WHERE TaskID = {$data["taskID"]}";
            $insert = $this->_query($sql);

            date_default_timezone_set('Asia/Ho_Chi_Minh');
            $currentDate = date('Y-m-d');
            $taskPerformers = $this->addData("TaskPerformers", ["'{$data["taskID"]}'", "'{$data["taskPerformers"]}'", "'{$currentDate}'", "'{$data["deadlineTaskPerformers"]}'", "NULL", "'0'", "'0'", "'Đang thực hiện'", "''"]);

            $taskReview = $this->addData("TaskPerformers", ["'{$data["taskID"]}'", "'{$data["taskReview"]}'", "NULL", "'{$data["deadlineReview"]}'", "NULL", "'0'", "'1'", "'Đang thực hiện'", "''"]);

            $link = "/ac/cong-viec?v=chua-hoan-thanh";

            $notifyPerformers = $this->addData("Notifies", ["NULL", "'đã tạo công việc <span class=\"fw-semibold\">{$data["name"]}</span>'", "'{$link}'", "'0'", "current_timestamp()", "'{$data["taskPerformers"]}'", "'{$_SESSION["UserInfo"][0]["UserID"]}'"]);

            $notifyReview = $this->addData("Notifies", ["NULL", "'đã tạo công việc <span class=\"fw-semibold\">{$data["name"]}</span>'", "'{$link}'", "'0'", "current_timestamp()", "'{$data["taskReview"]}'", "'{$_SESSION["UserInfo"][0]["UserID"]}'"]);

            if ($insert && $taskPerformers && $taskReview && $notifyPerformers && $notifyReview) {
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

    public function sendChildTask($data = [])
    {
        mysqli_begin_transaction($this->connect);
        try {
            $sql = "UPDATE Tasks SET TaskName='{$data["name"]}', Description='{$data["description"]}', Priority='{$data["priority"]}', Status='Đang thực hiện',DateStart=current_timestamp() , Deadline='{$data["deadlineTask"]}' WHERE TaskID = {$data["taskID"]}";
            $insert = $this->_query($sql);

            date_default_timezone_set('Asia/Ho_Chi_Minh');
            $currentDate = date('Y-m-d');
            $taskPerformers = $this->addData("TaskPerformers", ["'{$data["taskID"]}'", "'{$data["taskPerformers"]}'", "'{$currentDate}'", "'{$data["deadlineTaskPerformers"]}'", "NULL", "'0'", "'0'", "'Đang thực hiện'", "''"]);

            $link = "/ac/cong-viec?v=chua-hoan-thanh";

            $notifyPerformers = $this->addData("Notifies", ["NULL", "'đã tạo công việc <span class=\"fw-semibold\">{$data["name"]}</span>'", "'{$link}'", "'0'", "current_timestamp()", "'{$data["taskPerformers"]}'", "'{$_SESSION["UserInfo"][0]["UserID"]}'"]);

            if ($insert && $taskPerformers && $notifyPerformers) {
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
            $sql1 = "UPDATE TaskPerformers SET Status='Chờ duyệt', Progress='{$progress}', CompletionDate=current_timestamp() WHERE TaskID = '{$id}' AND UserID = '{$_SESSION["UserInfo"][0]["UserID"]}' AND Reviewer = '0'";

            $sql2 = "UPDATE TaskPerformers SET Status='Đang thực hiện', DateStart=current_timestamp() WHERE TaskID = '{$id}' AND UserID = '{$idReviewer}' AND Reviewer = '1'";

            $task = $this->getTaskByIdTask($id);
            $nameTask = $task[0]["TaskName"];
            $link = "/ac/cong-viec?v=chua-hoan-thanh";
            $sql3 = $this->addData("Notifies", ["NULL", "'cần bạn thẩm đinh công việc <span class=\"fw-semibold\">{$nameTask}</span>'", "'{$link}'", "'0'", "current_timestamp()", "'{$idReviewer}'", "'{$_SESSION["UserInfo"][0]["UserID"]}'"]);

            if ($this->_query($sql1) && $this->_query($sql2) && $sql3) {
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

    public function recallTask($id, $idReviewer)
    {
        mysqli_begin_transaction($this->connect);
        try {
            $task = $this->getTaskByIdTask($id);
            $nameTask = $task[0]["TaskName"];
            $link = "/ac/cong-viec";

            if ($_SESSION["UserInfo"][0]["UserID"] != $idReviewer) {
                $sql1 = "UPDATE TaskPerformers SET Status='Đang thực hiện', CompletionDate=NULL WHERE TaskID = '{$id}' AND UserID = '{$_SESSION["UserInfo"][0]["UserID"]}' AND Reviewer = '0'";

                $sql2 = "UPDATE TaskPerformers SET DateStart=NULL, Progress=0 WHERE TaskID = '{$id}' AND UserID = '{$idReviewer}' AND Reviewer = '1'";

                $sql3 = $this->addData("Notifies", ["NULL", "'đã thu hồi công việc <span class=\"fw-semibold\">{$nameTask}</span>'", "'{$link}'", "'0'", "current_timestamp()", "'{$idReviewer}'", "'{$_SESSION["UserInfo"][0]["UserID"]}'"]);

                if ($this->_query($sql1) && $this->_query($sql2) && $sql3) {
                    mysqli_commit($this->connect);
                    return true;
                } else {
                    mysqli_rollback($this->connect);
                    return false;
                }
            } else {
                $sql1 = "UPDATE TaskPerformers SET Status='Đang thực hiện', CompletionDate=NULL WHERE TaskID = '{$id}' AND UserID = '{$_SESSION["UserInfo"][0]["UserID"]}' AND Reviewer = '1'";

                $sql2 = $this->addData("Notifies", ["NULL", "'đã thu hồi công việc <span class=\"fw-semibold\">{$nameTask}</span>'", "'{$link}'", "'0'", "current_timestamp()", "'{$task[0]["AssignedBy"]}'", "'{$_SESSION["UserInfo"][0]["UserID"]}'"]);

                if ($this->_query($sql1) && $sql2) {
                    mysqli_commit($this->connect);
                    return true;
                } else {
                    mysqli_rollback($this->connect);
                    return false;
                }
            }
        } catch (Exception $e) {
            mysqli_rollback($this->connect);
            return false;
        }
    }

    public function recallChildTask($id)
    {
        mysqli_begin_transaction($this->connect);
        try {
            $task = $this->getTaskByIdTask($id);
            $nameTask = $task[0]["TaskName"];
            $link = "/ac/cong-viec";
            $sql1 = "UPDATE TaskPerformers SET Status='Đang thực hiện', CompletionDate=NULL WHERE TaskID = '{$id}' AND UserID = '{$_SESSION["UserInfo"][0]["UserID"]}' AND Reviewer = '0'";

            $sql2 = $this->addData("Notifies", ["NULL", "'đã thu hồi công việc <span class=\"fw-semibold\">{$nameTask}</span>'", "'{$link}'", "'0'", "current_timestamp()", "'{$task[0]["AssignedBy"]}'", "'{$_SESSION["UserInfo"][0]["UserID"]}'"]);

            if ($this->_query($sql1) && $sql2) {
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

    public function refuseTask($id, $idPerformers, $idReviewer, $comment)
    {
        mysqli_begin_transaction($this->connect);
        try {
            $task = $this->getTaskByIdTask($id);
            if ($task[0]["AssignedBy"] != $_SESSION["UserInfo"][0]["UserID"]) {
                $sql1 = "UPDATE TaskPerformers SET Status='Từ chối phê duyệt', Comment='{$comment}' WHERE TaskID = '{$id}' AND UserID = '{$idPerformers}' AND Reviewer = '0'";
                $sql2 = "UPDATE TaskPerformers SET DateStart=NULL, Progress=0 WHERE TaskID = '{$id}' AND UserID = '{$idReviewer}' AND Reviewer = '1'";

                $nameTask = $task[0]["TaskName"];
                $link = "/ac/cong-viec?v=tu-choi-phe-duyet";
                $sql3 = $this->addData("Notifies", ["NULL", "'đã từ chối thẩm định công việc <span class=\"fw-semibold\">{$nameTask}</span>'", "'{$link}'", "'0'", "current_timestamp()", "'{$idPerformers}'", "'{$_SESSION["UserInfo"][0]["UserID"]}'"]);
                if ($this->_query($sql1) && $this->_query($sql2) && $sql3) {
                    mysqli_commit($this->connect);
                    return true;
                } else {
                    mysqli_rollback($this->connect);
                    return false;
                }
            } else {
                $sql1 = "UPDATE TaskPerformers SET Status='Từ chối phê duyệt', Comment='{$comment}' WHERE TaskID = '{$id}' AND UserID = '{$idReviewer}' AND Reviewer = '1'";

                $nameTask = $task[0]["TaskName"];
                $link = "/ac/cong-viec?v=tu-choi-phe-duyet";
                $sql2 = $this->addData("Notifies", ["NULL", "'đã từ chối thẩm định công việc <span class=\"fw-semibold\">{$nameTask}</span>'", "'{$link}'", "'0'", "current_timestamp()", "'{$idReviewer}'", "'{$_SESSION["UserInfo"][0]["UserID"]}'"]);

                if ($this->_query($sql1) && $sql2) {
                    mysqli_commit($this->connect);
                    return true;
                } else {
                    mysqli_rollback($this->connect);
                    return false;
                }
            }
        } catch (Exception $e) {
            mysqli_rollback($this->connect);
            return false;
        }
    }

    public function refuseChildTask($id, $idPerformers, $comment)
    {
        mysqli_begin_transaction($this->connect);
        try {
            $task = $this->getTaskByIdTask($id);
            $sql1 = "UPDATE TaskPerformers SET Status='Từ chối phê duyệt', Comment='{$comment}' WHERE TaskID = '{$id}' AND UserID = '{$idPerformers}' AND Reviewer = '0'";

            $nameTask = $task[0]["TaskName"];
            $link = "/ac/cong-viec?v=tu-choi-phe-duyet";
            $sql2 = $this->addData("Notifies", ["NULL", "'đã từ chối thẩm định công việc <span class=\"fw-semibold\">{$nameTask}</span>'", "'{$link}'", "'0'", "current_timestamp()", "'{$idPerformers}'", "'{$_SESSION["UserInfo"][0]["UserID"]}'"]);
            if ($this->_query($sql1) && $sql2) {
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

    public function sendSignatureTask($id, $progress, $idPerformers)
    {
        date_default_timezone_set('Asia/Ho_Chi_Minh');
        mysqli_begin_transaction($this->connect);
        try {
            $sql1 = "UPDATE TaskPerformers SET Status='Chờ duyệt', CompletionDate=current_timestamp(), Progress='{$progress}' WHERE TaskID = '{$id}' AND UserID = '{$_SESSION["UserInfo"][0]["UserID"]}' AND Reviewer = '1'";

            $task = $this->getTaskByIdTask($id);
            $nameTask = $task[0]["TaskName"];
            $link = "/ac/xet-duyet";
            $sql2 = $this->addData("Notifies", ["NULL", "'cần bạn xét duyệt công việc <span class=\"fw-semibold\">{$nameTask}</span>'", "'{$link}'", "'0'", "current_timestamp()", "'{$task[0]["AssignedBy"]}'", "'{$_SESSION["UserInfo"][0]["UserID"]}'"]);

            $link = "/ac/cong-viec?v=cho-phe-duyet";
            $sql3 = $this->addData("Notifies", ["NULL", "'đã trình ký công việc <span class=\"fw-semibold\">{$nameTask}</span>'", "'{$link}'", "'0'", "current_timestamp()", "'{$idPerformers}'", "'{$_SESSION["UserInfo"][0]["UserID"]}'"]);

            if ($this->_query($sql1) && $sql2 && $sql3) {
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

    public function sendSignatureChildTask($id, $progress)
    {
        date_default_timezone_set('Asia/Ho_Chi_Minh');
        mysqli_begin_transaction($this->connect);
        try {
            $sql1 = "UPDATE TaskPerformers SET Status='Chờ duyệt', CompletionDate=current_timestamp(), Progress='{$progress}' WHERE TaskID = '{$id}' AND UserID = '{$_SESSION["UserInfo"][0]["UserID"]}' AND Reviewer = '0'";

            $task = $this->getTaskByIdTask($id);
            $nameTask = $task[0]["TaskName"];
            $link = "/ac/xet-duyet";
            $sql2 = $this->addData("Notifies", ["NULL", "'cần bạn xét duyệt công việc <span class=\"fw-semibold\">{$nameTask}</span>'", "'{$link}'", "'0'", "current_timestamp()", "'{$task[0]["AssignedBy"]}'", "'{$_SESSION["UserInfo"][0]["UserID"]}'"]);

            if ($this->_query($sql1) && $sql2) {
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

    public function signatureTask($idTask, $idPerformer, $idReviewer, $comment)
    {
        date_default_timezone_set('Asia/Ho_Chi_Minh');
        mysqli_begin_transaction($this->connect);
        try {
            $task = $this->getTaskByIdTask($idTask);
            $completeDate = new DateTime();
            $DateStart = new DateTime($task[0]["DateStart"]);
            $deadline = $DateStart->add(new DateInterval("P" . ($task[0]["Deadline"] - 1) . "D"));
            $status = "Hoàn thành";
            if ($completeDate < $deadline) {
                $status = "Hoàn thành trước hạn";
            } else if ($completeDate > $deadline) {
                $status = "Hoàn thành trễ hạn";
            }

            $performer = $this->getTaskPerformers($idTask, $idPerformer);
            $completeDate = new DateTime($performer[0]["CompletionDate"]);
            $DateStart = new DateTime($performer[0]["DateStart"]);
            $deadline = $DateStart->add(new DateInterval("P" . ($performer[0]["Deadline"] - 1) . "D"));
            $statusPerformer = "Hoàn thành";
            if ($completeDate < $deadline) {
                $statusPerformer = "Hoàn thành trước hạn";
            } else if ($completeDate > $deadline) {
                $statusPerformer = "Hoàn thành trễ hạn";
            }

            $reviewer = $this->getTaskPerformers($idTask, $idReviewer);
            $completeDate = new DateTime($reviewer[0]["CompletionDate"]);
            $DateStart = new DateTime($reviewer[0]["DateStart"]);
            $deadline = $DateStart->add(new DateInterval("P" . ($reviewer[0]["Deadline"] - 1) . "D"));
            $statusReviewer = "Hoàn thành";
            if ($completeDate < $deadline) {
                $statusReviewer = "Hoàn thành trước hạn";
            } else if ($completeDate > $deadline) {
                $statusReviewer = "Hoàn thành trễ hạn";
            }

            $sql1 = "UPDATE Tasks SET Status='{$status}', CompletionDate=current_timestamp() WHERE TaskID = '{$idTask}' AND 	AssignedBy = '{$_SESSION["UserInfo"][0]["UserID"]}'";

            $sql2 = "UPDATE TaskPerformers SET Comment = '{$comment}', Status='{$statusPerformer}' WHERE TaskID = '{$idTask}' AND UserID = '{$idPerformer}' AND Reviewer = '0'";

            $sql3 = "UPDATE TaskPerformers SET Comment = '{$comment}', Status='{$statusReviewer}' WHERE TaskID = '{$idTask}' AND UserID = '{$idReviewer}' AND Reviewer = '1'";

            $task = $this->getTaskByIdTask($idTask);
            $nameTask = $task[0]["TaskName"];
            $link = "/ac/cong-viec?v=hoan-tat";

            $sql4 = $this->addData("Notifies", ["NULL", "'đã duyệt công việc <span class=\"fw-semibold\">{$nameTask}</span>'", "'{$link}'", "'0'", "current_timestamp()", "'{$idPerformer}'", "'{$_SESSION["UserInfo"][0]["UserID"]}'"]);

            $sql5 = $this->addData("Notifies", ["NULL", "'đã duyệt công việc <span class=\"fw-semibold\">{$nameTask}</span>'", "'{$link}'", "'0'", "current_timestamp()", "'{$idReviewer}'", "'{$_SESSION["UserInfo"][0]["UserID"]}'"]);


            if ($this->_query($sql1) && $this->_query($sql2) && $this->_query($sql3) && $sql4 && $sql5) {
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

    public function signatureChildTask($idTask, $idPerformer, $comment)
    {
        date_default_timezone_set('Asia/Ho_Chi_Minh');
        mysqli_begin_transaction($this->connect);
        try {
            $task = $this->getTaskByIdTask($idTask);
            $completeDate = new DateTime();
            $DateStart = new DateTime($task[0]["DateStart"]);
            $deadline = $DateStart->add(new DateInterval("P" . ($task[0]["Deadline"] - 1) . "D"));
            $status = "Hoàn thành";
            if ($completeDate < $deadline) {
                $status = "Hoàn thành trước hạn";
            } else if ($completeDate > $deadline) {
                $status = "Hoàn thành trễ hạn";
            }

            $performer = $this->getTaskPerformers($idTask, $idPerformer);
            $completeDate = new DateTime($performer[0]["CompletionDate"]);
            $DateStart = new DateTime($performer[0]["DateStart"]);
            $deadline = $DateStart->add(new DateInterval("P" . ($performer[0]["Deadline"] - 1) . "D"));
            $statusPerformer = "Hoàn thành";
            if ($completeDate < $deadline) {
                $statusPerformer = "Hoàn thành trước hạn";
            } else if ($completeDate > $deadline) {
                $statusPerformer = "Hoàn thành trễ hạn";
            }

            $sql1 = "UPDATE Tasks SET Status='{$status}', CompletionDate=current_timestamp() WHERE TaskID = '{$idTask}' AND 	AssignedBy = '{$_SESSION["UserInfo"][0]["UserID"]}'";

            $sql2 = "UPDATE TaskPerformers SET Comment = '{$comment}', Status='{$statusPerformer}' WHERE TaskID = '{$idTask}' AND UserID = '{$idPerformer}' AND Reviewer = '0'";


            $task = $this->getTaskByIdTask($idTask);
            $nameTask = $task[0]["TaskName"];
            $link = "/ac/cong-viec?v=hoan-tat";

            $sql3 = $this->addData("Notifies", ["NULL", "'đã duyệt công việc <span class=\"fw-semibold\">{$nameTask}</span>'", "'{$link}'", "'0'", "current_timestamp()", "'{$idPerformer}'", "'{$_SESSION["UserInfo"][0]["UserID"]}'"]);

            if ($this->_query($sql1) && $this->_query($sql2) && $sql3) {
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
