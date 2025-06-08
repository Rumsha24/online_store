<?php

class Model
{
    protected $db;

    public function __construct()
    {
        $this->db = Database::getInstance()->getConnection();
    }

    // Fetch all rows from a table
    public function getAll($table)
    {
        $stmt = $this->db->prepare("SELECT * FROM `$table`");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Fetch one row by ID
    public function getById($table, $id)
    {
        $stmt = $this->db->prepare("SELECT * FROM `$table` WHERE id = :id");
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // Delete row by ID
    public function deleteById($table, $id)
    {
        $stmt = $this->db->prepare("DELETE FROM `$table` WHERE id = :id");
        $stmt->bindParam(':id', $id);
        return $stmt->execute();
    }

    // Insert a new record (dynamic insert)
    public function insert($table, $data)
    {
        $columns = implode(',', array_keys($data));
        $placeholders = ':' . implode(', :', array_keys($data));

        $stmt = $this->db->prepare("INSERT INTO `$table` ($columns) VALUES ($placeholders)");
        foreach ($data as $key => &$val) {
            $stmt->bindParam(":$key", $val);
        }
        return $stmt->execute();
    }

    // Update record by ID
    public function update($table, $id, $data)
    {
        $fields = '';
        foreach ($data as $key => $val) {
            $fields .= "$key = :$key, ";
        }
        $fields = rtrim($fields, ', ');

        $data['id'] = $id;
        $stmt = $this->db->prepare("UPDATE `$table` SET $fields WHERE id = :id");
        foreach ($data as $key => &$val) {
            $stmt->bindParam(":$key", $val);
        }
        return $stmt->execute();
    }
}
