<?php

/**
 *  Параметры объектов недвижимости
 *
 * @author danilonanov
 */
class ParamController extends Controller {
    public function index() {
        $data = $this->model()->fetchAll('name');
        return $this->render('param/index.phtml', array('data' => $data));
    }

    public function add() {
        $result = null;
        $name = $this->request()->post('name');
        if ($name) {
            $result = $this->model()->create($name);
        }
        return $this->render('param/add.phtml', array(
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
        $param = $this->model()->fetchById($id);
        return $this->render('param/edit.phtml', array(
            'id' => $id,
            'result' => $result,
            'param' => $param
        ));
    }

    public function remove() {
        $id = $this->request()->params("id");
        $this->model()->delete($id);
        header('Location: /param');
        exit;
    }
}
