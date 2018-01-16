<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Param
 *
 * @author danilonanov
 */
class Param extends Model {
   
    protected $tableName = 'param';
    
    public function create($name) {
        if (!$name || strlen($name) < 2) {
            return 'Не указано название';
        }
        return $this->insert(array(
            'name' => $name
        ));
    }
}
