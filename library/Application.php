<?php

require_once 'Controller.php';
require_once 'Model.php';
require_once 'CustomException.php';
require_once 'DbAdapter.php';
require_once 'Decorator.php';
require_once 'NotFoundException.php';
require_once 'Request.php';

class Application {

    private $_request;
    private $_controller;
    private $paramsGet;
    private $uri;
    

    public function __construct() {
        
    }

    public function bootstrap() {
        $this->_request = new Request();
        $this->_controller = $this->buildController();
        $this->buildModel();

        return $this;
    }

    public function run() {
        DbAdapter::getInstance()->connect();
        try {
            $action = $this->_request->getActionName();
            if (!method_exists($this->_controller, $action)) {
                throw new NotFoundException("Не найден метод $action");
            }
            echo call_user_func(array($this->_controller, $action));
        } catch (NotFoundException $e) {
            error_log("NotFoundException at uri " 
                    . filter_input(INPUT_SERVER, 'REQUEST_URI', FILTER_SANITIZE_URL) 
                    . " : " . $e->getTraceAsString());
            $e->show();
        }
        DbAdapter::getInstance()->disconnect();
    }

    private function buildController() {
        try {
            $sName = $this->_request->getSName();
            $controllerName = ucfirst($sName) . 'Controller';
            $controllerPath = APPLICATION_PATH . "/controllers/$controllerName.php";

            if (!file_exists($controllerPath)) {
                throw new NotFoundException("Контроллер $sName не существует");
            }

            require_once $controllerPath;
            $controller = new $controllerName($this->_request);
            return $controller;
        } catch (NotFoundException $e) {
            error_log("NotFoundException at uri " . $_SERVER['REQUEST_URI'] . " : " . $e->getTraceAsString());
            $e->show();
        }
    }

    private function buildModel() {
        try {
            $sName = $this->_request->getSName();
            $modelName = ucfirst($sName);
            $modelPath = APPLICATION_PATH . "/models/$modelName.php";

            if (!file_exists($modelPath)) {
                throw new NotFoundException("Модель $sName не существует");
            }

            require_once $modelPath;
            $this->_controller->setModel(new $modelName());
            
        } catch (NotFoundException $e) {
            error_log("NotFoundException at uri " . $_SERVER['REQUEST_URI'] . " : " . $e->getTraceAsString());
            $e->show();
        }
    }

}
