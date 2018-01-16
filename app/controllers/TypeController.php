<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of RealtyTypeController
 *
 * @author danilonanov
 */
class TypeController extends Controller {
    public function index() {
        $data = $this->model()->fetchAll('name');
        return $this->render('type/index.phtml', array('data' => $data));
    }

    public function add() {
        $result = null;
        $name = $this->request()->post('name');
        if ($name) {
            $result = $this->model()->create($name);
        }
        return $this->render('type/add.phtml', array(
            'result' => $result,
            'name' => $name
        ));
    }

    public function edit() {
        $id = $this->request()->params("id");
        $name = $this->request()->post('name');
        $result = null;
        if ($name) {
            $result = $this->model()->update(array('name' => $name), $id);
        }
        $type = $this->model()->fetchById($id);
        return $this->render('type/edit.phtml', array(
            'id' => $id,
            'result' => $result,
            'data' => $type
        ));
    }

    public function remove() {
        $id = $this->request()->params("id");
        $this->model()->delete($id);
        header('Location: /type');
        exit;
    }
}
