<?php
class TaskModel extends BaseModel {
    const TABLE = 'statistical';

    public function getAll($table, $select = ['*']) {
        return $this->all($table);
    }

    public function findById($id) {
        return __METHOD__;
    }

    public function delete() {
        return __METHOD__;
    }
}