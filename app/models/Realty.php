<?php

require_once APPLICATION_PATH . "/models/ParamValue.php";


class Realty extends Model {
    
    protected $tableName = 'realty';
    
    public function fetchList() {
        $sql = "SELECT r.*, t.name as type_name"
                . " FROM $this->tableName AS r"
                . " LEFT JOIN type AS t ON r.type = t.id"
                . " ORDER BY r.id";
        return $this->fetchAll(null, $sql);
    }
    
    public function create($post) {
        if (!isset($post['address']) || strlen($post['address']) <= 2) {
            return 'Не указан адрес';
        }
        return $this->insert(array(
            'address' => $post['address'],
            'type' => (int) $post['type'],
            'price' => (float) $post['price']
        ));
    }
    
    public function change($post, $id) {
        if (!isset($post['address']) || strlen($post['address']) <= 2) {
            return 'Не указан адрес';
        }
        if (isset($post['params']) && is_array($post['params'])) {
            $paramValueModel = new ParamValue();
            foreach ($post['params'] as $paramId => $paramValue) {
                $paramValueModel->updateOrInsert($id, $paramId, $paramValue);
            }
        }
        
        return $this->update(array(
            'address' => $post['address'],
            'type' => (int) $post['type'],
            'price' => (float) $post['price']
        ), $id);
    }
    
    public function addParams($realty) {
        $paramValueModel = new ParamValue();
        $paramValues = $paramValueModel->fetchList($realty['id']);
        
        foreach ($paramValues as $item) {
            $realty['params'][$item['id']] = $item['value'];
        }
        return $realty;
    }
}
