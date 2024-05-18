<?php
class TaskModel extends BaseModel {
    const TABLE = 'statistical';

    public function getAll($table, $select = ['*'], $limit = 0) {
        return $this->all($table, $select);
    }

    public function findById($id) {
        return __METHOD__;
    }

    public function delete() {
        return __METHOD__;
    }
}