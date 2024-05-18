<?php
class TaskModel extends BaseModel {
    const TABLE = 'statistical';

    public function getAll($table, $select = ['*'], $orderBys = [], $limit = -1) {
        return $this->all($table, $select, $orderBys, $limit);
    }

    public function findById($table, $id) {
        $sql = "SELECT * FROM ${table} WHERE id = ${id} LIMIT 1";
    }

    public function delete() {
        return __METHOD__;
    }
}