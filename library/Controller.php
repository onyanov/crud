<?php
abstract class Controller {
    private $request;
    
    private $model;
    
    public function __construct($request) {
        $this->request = $request;
    }
    public function request() {
        return $this->request;
    }
    
    public function setModel(Model $model) {
        $this->model = $model;
    }
    
    protected function model() {
        return $this->model;
    }
    
    protected function render($template, $variables) {
        ob_start();
        $content = $this->renderView($template, $variables);
        include(APPLICATION_PATH . 'views/layout.phtml');
        $ret = ob_get_contents();
        ob_end_clean();
        return $ret;
    }  
    
    private function renderView($template, $variables) {
        ob_start();
        extract($variables);
        include(APPLICATION_PATH . 'views/' . $template);
        $ret = ob_get_contents();
        ob_end_clean();
        return $ret;
    }
}