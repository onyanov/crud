<?php
require_once APPLICATION_PATH . "/models/Type.php";
require_once APPLICATION_PATH . "/models/Param.php";

class RealtyController extends Controller {

    public function index() {
        $data = $this->model()->fetchList();
        return $this->render('realty/index.phtml', array('data' => $data));
    }

    public function add() {
        $post = $this->getPost();
        
        $result = null;
        if ($post) {
            $result = $this->model()->create($post);
        }
        $typeModel = new Type();
        $types = $typeModel->fetchPairs('id', 'name');
        return $this->render('realty/add.phtml', array(
            'result' => $result,
            'post' => $post,
            'types' => $types
        ));
    }

    public function edit() {
        $id = $this->request()->params("id");
        
        $typeModel = new Type();
        $types = $typeModel->fetchPairs('id', 'name');
        
        $paramModel = new Param();
        $params = $paramModel->fetchPairs('id', 'name');
        
        $post = $this->getPost($params);
        
        $result = null;
        if ($post) {
            $result = $this->model()->change($post, $id);
        }
        $realty = $this->model()->fetchById($id);
        if (!$realty) {
            $result = "Объект не найден";
        }
        
        
        
        $realtyWithParams = $this->model()->addParams($realty);
        
        return $this->render('realty/edit.phtml', array(
            'id' => $id,
            'result' => $result,
            'realty' => $realtyWithParams,
            'types' => $types,
            'params' => $params
        ));
    }

    public function remove() {
        $id = $this->request()->params("id");
        $this->model()->delete($id);
        header('Location: /');
        exit;
    }

    public function card() {
        echo $this->request()->params("id");
        echo "<br />";
        echo $this->request()->get("ghg");
    }

    private function getPost($params = array()) {
        if ($this->request()->hasPost()) {
            $post = array(
                'address' => $this->request()->post('address'),
                'type' => $this->request()->post('type'),
                'price' => $this->request()->post('price')
            );
            foreach ($params as $paramId => $paramName) {
                $post['params'][$paramId] = $this->request()->post('param'.$paramId);
            }
            return $post;
        }
    }

}
