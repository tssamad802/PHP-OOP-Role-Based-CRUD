<?php
class model
{
    public $conn;

    public function __construct($conn)
    {
        $this->conn = $conn;
    }
    public function check_record($table, $conditions = [])
    {
        $where = [];

        foreach ($conditions as $column => $value) {
            $where[] = "$column = ?";
        }

        $where_clause = $where ? implode(' AND ', $where) : '1';
        $sql = "SELECT * FROM $table WHERE $where_clause";

        $stmt = $this->conn->prepare($sql);

        if (!empty($conditions)) {
            $types = str_repeat("s", count($conditions)); // assuming all strings
            $values = array_values($conditions);
            $stmt->bind_param($types, ...$values);
        }

        $stmt->execute();
        $result = $stmt->get_result();

        $data = [];
        while ($row = $result->fetch_assoc()) {
            $data[] = $row;
        }

        return $data;
    }

    public function insert_record($table, $data = [])
    {
        $columns = implode(', ', array_keys($data));
        $placeholders = implode("','", $data);

        $sql = "INSERT INTO $table ($columns) VALUES ('$placeholders')";
        $this->conn->query($sql);

        return $this->conn->insert_id; // <-- yeh use karo
    }



    public function fetch_records($table, $conditions = [], $join = "")
    {
        $table = preg_replace('/[^a-zA-Z0-9_]/', '', $table);

        $where = [];

        $softDeleteTables = ['posts'];

        if (in_array($table, $softDeleteTables)) {
            $where[] = "($table.is_deleted IS NULL OR $table.is_deleted = 0)";
        }

        foreach ($conditions as $column => $value) {
            $where[] = "$column = ?";
        }

        $where_clause = !empty($where) ? implode(' AND ', $where) : '';

        $sql = "SELECT * FROM `$table`";

        if (!empty($join)) {
            $sql .= " $join";
        }

        if (!empty($where_clause)) {
            $sql .= " WHERE $where_clause";
        }

        $stmt = $this->conn->prepare($sql);

        if (!empty($conditions)) {
            $types = str_repeat("s", count($conditions)); // assuming all string
            $values = array_values($conditions);
            $stmt->bind_param($types, ...$values);
        }

        $stmt->execute();
        $result = $stmt->get_result();

        $data = [];
        while ($row = $result->fetch_assoc()) {
            $data[] = $row;
        }

        return $data;
    }





    public function get_record_by_id($table, $id)
    {
        $table = preg_replace('/[^a-zA-Z0-9_]/', '', $table);

        $stmt = $this->conn->prepare("SELECT * FROM $table WHERE id = ?");
        $stmt->bind_param("i", $id);
        $stmt->execute();

        $result = $stmt->get_result();
        return $result->fetch_assoc();
    }

    public function update($table, $id, $data = [])
    {
        $table = preg_replace('/[^a-zA-Z0-9_]/', '', $table);

        $fields = [];
        $types = "";
        $values = [];

        foreach ($data as $key => $value) {
            $fields[] = "`$key` = ?";
            $types .= "s";
            $values[] = $value;
        }

        $fields_sql = implode(', ', $fields);
        $sql = "UPDATE `$table` SET $fields_sql WHERE id = ?";

        $types .= "i";
        $values[] = $id;

        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param($types, ...$values);

        return $stmt->execute();
    }

    public function search($table, $column, $value)
    {
        $table = preg_replace('/[^a-zA-Z0-9_]/', '', $table);
        $column = preg_replace('/[^a-zA-Z0-9_]/', '', $column);

        $sql = "SELECT * FROM {$table} 
            WHERE {$column} LIKE ? 
            AND (is_deleted IS NULL OR is_deleted = 0)";

        $stmt = $this->conn->prepare($sql);

        $searchValue = "%{$value}%";
        $stmt->bind_param("s", $searchValue);
        $stmt->execute();

        $result = $stmt->get_result();
        return $result->fetch_all(MYSQLI_ASSOC);
    }



    public function delete_by_id($table, $id)
    {
        $table = preg_replace('/[^a-zA-Z0-9_]/', '', $table);

        $stmt = $this->conn->prepare("SELECT * FROM `$table` WHERE id = ?");
        $stmt->bind_param("i", $id);
        $stmt->execute();

        $result = $stmt->get_result();
        $row = $result->fetch_assoc();

        if ($row) {

            foreach ($row as $col => $value) {
                if (stripos($col, 'image') !== false && !empty($value)) {
                    $file_path = './upload/' . basename($value);
                    if (file_exists($file_path)) {
                        unlink($file_path);
                    }
                }
            }

            $stmt_check = $this->conn->prepare("SHOW COLUMNS FROM `$table` LIKE 'is_deleted'");
            $stmt_check->execute();
            $check_result = $stmt_check->get_result();

            $hasIsDeleted = $check_result->num_rows > 0;

            if ($hasIsDeleted) {
                $stmt_update = $this->conn->prepare("UPDATE `$table` SET is_deleted = 1 WHERE id = ?");
                $stmt_update->bind_param("i", $id);
                $stmt_update->execute();
            } else {
                $stmt_delete = $this->conn->prepare("DELETE FROM `$table` WHERE id = ?");
                $stmt_delete->bind_param("i", $id);
                $stmt_delete->execute();
            }

            return true;
        }

        return false;
    }

    public function delete_category_by_id($id)
    {
        $stmt_check = $this->conn->prepare("SELECT * FROM `category_post` WHERE category_id = ?");
        $stmt_check->bind_param("i", $id);
        $stmt_check->execute();

        $result = $stmt_check->get_result();
        $row = $result->fetch_assoc();

        if ($row) {

            $stmt_delete = $this->conn->prepare("DELETE FROM `category_post` WHERE category_id = ?");
            $stmt_delete->bind_param("i", $id);
            $stmt_delete->execute();

            return true;
        }

        return false;
    }




}
?>