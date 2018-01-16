<?php

/**
 * Description of Value2Realty
 *
 * @author danilonanov
 */
class ParamValue extends Model {
    
    protected $tableName = 'param_value';
    
    public function fetchList($realtyId) {
        $sql = "SELECT p.id, p.name, pv.value 
            FROM param AS p
            LEFT JOIN " . $this->tableName . ' AS pv ON pv.param_id = p.id AND pv.realty_id = ' . (int) $realtyId;
        return $this->fetchAll(null, $sql);
    }
    
    public function updateOrInsert($realtyId, $paramId, $paramValue) {
        $sql = "UPDATE " . $this->tableName . " SET value='$paramValue' WHERE realty_id=$realtyId AND param_id=$paramId;
                INSERT INTO " . $this->tableName . " (realty_id, param_id, value) SELECT $realtyId, $paramId, '$paramValue'
                   WHERE NOT EXISTS (SELECT 1 FROM " . $this->tableName . " WHERE realty_id=$realtyId AND param_id=$paramId);";
        return $this->query($sql);
    }
}
