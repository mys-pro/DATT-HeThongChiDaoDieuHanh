<?php
class TaskModel extends BaseModel {
    const TABLE = 'statistical';

    public function getAll($table, $select = ['*'], $orderBys = [], $limit = -1) {
        return $this->all($table, $select, $orderBys, $limit);
    }

    public function findById($table, $id) {
        return $this->find($table, $id);
    }

    public function delete() {
        return __METHOD__;
    }
}