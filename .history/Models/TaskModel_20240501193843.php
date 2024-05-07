<?php
class TaskModel extends BaseModel
{
    const TABLE = 'statistical';

    public function getAll($table, $select = ['*'], $orderBys = [], $limit = -1)
    {
        return $this->all($table, $select, $orderBys, $limit);
    }

    public function statisticalByYear($priority = 0)
    {
        if ($priority > 0) {
            $sql = "SELECT d.DepartmentName, COUNT(tp.TaskID) AS 'Tổng công việc',
                    SUM(CASE WHEN tp.Status = 'Hoàn thành trước hạn' THEN 1 ELSE 0 END) AS 'Hoàn thành trước hạn',
                    SUM(CASE WHEN tp.Status = 'Hoàn thành' THEN 1 ELSE 0 END) AS 'Hoàn thành đúng hạn',
                    SUM(CASE WHEN tp.Status = 'Hoàn thành trễ hạn' THEN 1 ELSE 0 END) AS 'Hoàn thành trễ hạn',
                    SUM(CASE WHEN tp.Status = 'Chờ duyệt' THEN 1 ELSE 0 END) AS 'Chờ duyệt',
                    SUM(CASE WHEN tp.Status = 'Chưa hoàn thành' THEN 1 ELSE 0 END) AS 'Chưa hoàn thành',
                    SUM(CASE WHEN tp.Status = 'Quá hạn' THEN 1 ELSE 0 END) AS 'Quá hạn' 
                    FROM Tasks t JOIN TaskPerformers tp ON t.TaskID = tp.TaskID JOIN Users u ON tp.UserID = u.UserID 
                    RIGHT JOIN Departments d ON u.DepartmentID = d.DepartmentID 
                    AND YEAR(tp.DateStart) = YEAR(CURRENT_DATE) 
                    AND t.Priority = ${priority}
                    GROUP BY d.DepartmentID";
        } else {
            $sql = "SELECT d.DepartmentName, COUNT(tp.TaskID) AS 'Tổng công việc',
                    SUM(CASE WHEN tp.Status = 'Hoàn thành trước hạn' THEN 1 ELSE 0 END) AS 'Hoàn thành trước hạn',
                    SUM(CASE WHEN tp.Status = 'Hoàn thành' THEN 1 ELSE 0 END) AS 'Hoàn thành đúng hạn',
                    SUM(CASE WHEN tp.Status = 'Hoàn thành trễ hạn' THEN 1 ELSE 0 END) AS 'Hoàn thành trễ hạn',
                    SUM(CASE WHEN tp.Status = 'Chờ duyệt' THEN 1 ELSE 0 END) AS 'Chờ duyệt',
                    SUM(CASE WHEN tp.Status = 'Chưa hoàn thành' THEN 1 ELSE 0 END) AS 'Chưa hoàn thành',
                    SUM(CASE WHEN tp.Status = 'Quá hạn' THEN 1 ELSE 0 END) AS 'Quá hạn' 
                    FROM Tasks t JOIN TaskPerformers tp ON t.TaskID = tp.TaskID JOIN Users u ON tp.UserID = u.UserID 
                    RIGHT JOIN Departments d ON u.DepartmentID = d.DepartmentID 
                    AND YEAR(tp.DateStart) = YEAR(CURRENT_DATE)
                    GROUP BY d.DepartmentID";
        }
        return $this->getData($sql);
    }

    public function statisticalByMonth($priority = 0)
    {
        if ($priority > 0) {
            $sql = "SELECT d.DepartmentName, COUNT(tp.TaskID) AS 'Tổng công việc',
                    SUM(CASE WHEN tp.Status = 'Hoàn thành trước hạn' THEN 1 ELSE 0 END) AS 'Hoàn thành trước hạn',
                    SUM(CASE WHEN tp.Status = 'Hoàn thành' THEN 1 ELSE 0 END) AS 'Hoàn thành đúng hạn',
                    SUM(CASE WHEN tp.Status = 'Hoàn thành trễ hạn' THEN 1 ELSE 0 END) AS 'Hoàn thành trễ hạn',
                    SUM(CASE WHEN tp.Status = 'Chờ duyệt' THEN 1 ELSE 0 END) AS 'Chờ duyệt',
                    SUM(CASE WHEN tp.Status = 'Chưa hoàn thành' THEN 1 ELSE 0 END) AS 'Chưa hoàn thành',
                    SUM(CASE WHEN tp.Status = 'Quá hạn' THEN 1 ELSE 0 END) AS 'Quá hạn' 
                    FROM Tasks t JOIN TaskPerformers tp ON t.TaskID = tp.TaskID JOIN Users u ON tp.UserID = u.UserID 
                    RIGHT JOIN Departments d ON u.DepartmentID = d.DepartmentID 
                    AND MONTH(tp.DateStart) = MONTH(CURRENT_DATE) 
                    AND t.Priority = ${priority}
                    GROUP BY d.DepartmentID";
        } else {
            $sql = "SELECT d.DepartmentName, COUNT(tp.TaskID) AS 'Tổng công việc',
                    SUM(CASE WHEN tp.Status = 'Hoàn thành trước hạn' THEN 1 ELSE 0 END) AS 'Hoàn thành trước hạn',
                    SUM(CASE WHEN tp.Status = 'Hoàn thành' THEN 1 ELSE 0 END) AS 'Hoàn thành đúng hạn',
                    SUM(CASE WHEN tp.Status = 'Hoàn thành trễ hạn' THEN 1 ELSE 0 END) AS 'Hoàn thành trễ hạn',
                    SUM(CASE WHEN tp.Status = 'Chờ duyệt' THEN 1 ELSE 0 END) AS 'Chờ duyệt',
                    SUM(CASE WHEN tp.Status = 'Chưa hoàn thành' THEN 1 ELSE 0 END) AS 'Chưa hoàn thành',
                    SUM(CASE WHEN tp.Status = 'Quá hạn' THEN 1 ELSE 0 END) AS 'Quá hạn' 
                    FROM Tasks t JOIN TaskPerformers tp ON t.TaskID = tp.TaskID JOIN Users u ON tp.UserID = u.UserID 
                    RIGHT JOIN Departments d ON u.DepartmentID = d.DepartmentID 
                    AND MONTH(tp.DateStart) = MONTH(CURRENT_DATE)
                    GROUP BY d.DepartmentID";
        }
        return $this->getData($sql);
    }

    public function statistical($priority, $data) {

    }
}
