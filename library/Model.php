<?php

abstract class Model {
    
    protected $tableName;
    
    public function fetchAll($field, $sql = null) {
        if (!$sql) $sql = 'SELECT * FROM ' . $this->tableName . ' ORDER BY ' . $field;
        $result = pg_query($sql) or die('Ошибка запроса: ' . pg_last_error());
        $data = array();
        if (pg_num_rows($result) > 0) {
            while ($row = pg_fetch_array($result, null, PGSQL_ASSOC)) {
                $data[] = $row;
            }
        }
        pg_free_result($result);
        return $data;
    }
    
    public function fetchPairs($keyField, $valueField) {
        $sql = 'SELECT ' . $keyField . ', ' . $valueField . ' FROM ' . $this->tableName . ' ORDER BY ' . $valueField;
        $result = pg_query($sql) or die('Ошибка запроса: ' . pg_last_error());
        $data = array();
        if (pg_num_rows($result) > 0) {
            while ($row = pg_fetch_array($result, null, PGSQL_ASSOC)) {
                $data[$row[$keyField]] = $row[$valueField];
            }
        }
        pg_free_result($result);
        return $data;
    }
    
    public function fetchById($id) {
        $sql = 'SELECT * FROM ' . $this->tableName . ' WHERE id = ' . (int) $id;
        $result = pg_query($sql) or die('Ошибка запроса: ' . pg_last_error());
        $data = null;
        if (pg_num_rows($result) > 0) {
            $data = pg_fetch_array($result, null, PGSQL_ASSOC);
        }
        pg_free_result($result);
        return $data;
    }
    
    protected function query($sql) {
        $result = pg_query($sql) or die('Ошибка запроса: ' . pg_last_error());
        $data = null;
        if (pg_num_rows($result) > 0) {
            $data = pg_fetch_array($result, null, PGSQL_ASSOC);
        }
        pg_free_result($result);
        return $data;
    }
    
    protected function insert($data) {
        $sql = "INSERT INTO " . $this->tableName . 
                " (".  implode(', ', array_keys($data)).") "
                . "VALUES ('".  implode("', '", $data)."') "
                . "RETURNING id";
        $result = @pg_query($sql);
        
        if (!$result) {
            return 'Ошибка запроса: ' . pg_last_error();
        }
        
        if (pg_num_rows($result) > 0) {
            $row = pg_fetch_array($result, null, PGSQL_ASSOC);
            pg_free_result($result);
            return $row['id'];
        }
    }
    
    public function update($data, $id) {
        $sql = "UPDATE " . $this->tableName . 
                " SET (".  implode(', ', array_keys($data)).") = "
                . "('".  implode("', '", $data)."') "
                . "WHERE id = " . (int)$id
                . " RETURNING id";
        $result = @pg_query($sql);
        
        if (!$result) {
            return 'Ошибка запроса: ' . pg_last_error();
        }
        
        if (pg_num_rows($result) > 0) {
            $row = pg_fetch_array($result, null, PGSQL_ASSOC);
            pg_free_result($result);
            return $row['id'];
        }
    }
    
    public function delete($id) {
        $sql = "DELETE FROM " . $this->tableName
                . " WHERE id = " . (int)$id;
        $result = @pg_query($sql);
        
        if (!$result) {
            return 'Ошибка запроса: ' . pg_last_error();
        }
        return true;
    }
}

