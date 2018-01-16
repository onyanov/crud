<?php
/**
 * Абстрактный класс исключения
 */
abstract class CustomException extends Exception {
    public function __toString() {
        return __CLASS__ . ": [{$this->code}]: {$this->message}\n";
    }
    /**
     * 
     * @param type $message
     */
    public function show() {
        header('HTTP/1.0 ' . $this->code);
        die($this->message);
    }
}