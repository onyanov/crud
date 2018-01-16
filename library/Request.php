<?php
class Request {
    private $controllerName;
    private $actionName;
    private $params;
    private $paramsGet;
    private $paramsPost;
    
    public function __construct() {
        $uriFull = trim(filter_input(INPUT_SERVER, 'REQUEST_URI', FILTER_SANITIZE_URL), "/");
        $uri = strtok($uriFull, '?');
        $uriParams = explode('/', $uri);
        
        if (isset($uriParams[0])) {
            $this->controllerName = $uriParams[0];
        }
        if (isset($uriParams[1])) {
            $this->actionName = $uriParams[1];
        }
       
        if (count($uriParams) > 3) {
            $this->params = array();
            for ($i = 2; $i < count($uriParams) - 1; $i += 2) {
                $this->params[$uriParams[$i]] = $uriParams[$i + 1];
            }
        }
        
        $this->paramsGet = filter_input_array(INPUT_GET, FILTER_SANITIZE_SPECIAL_CHARS);
        
        $this->paramsPost = filter_input_array(INPUT_POST, FILTER_SANITIZE_SPECIAL_CHARS);
        
        
        
    }
    public function getSName() {
        return $this->controllerName ?: CONTROLLER_DEFAULT;
    }
    public function getActionName() {
        return $this->actionName ?: ACTION_DEFAULT;
    }
    public function params($name) {
        if (isset($this->params[$name])) {
            return $this->params[$name];
        }
    }
    public function get($name) {
        if (isset($this->paramsGet[$name])) {
            return $this->paramsGet[$name];
        }
    }
    
    public function post($name) {
        if (isset($this->paramsPost[$name])) {
            return $this->paramsPost[$name];
        }
    }
    
    public function hasPost() {
        return $this->paramsPost != null 
                && is_array($this->paramsPost) 
                && count($this->paramsPost) > 0;
    }
}