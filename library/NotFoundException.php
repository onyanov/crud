<?php
require_once 'CustomException.php';
/**
 * Исключение, связанное с некорректностью запросов к API
 */
class NotFoundException extends CustomException {
    const CODE = 404;
    
    const MESSAGE = "Некорректные параметры запроса";
    
    public function __construct($message = null) {
        $usedMessage = $message ?: self::MESSAGE;
        parent::__construct($usedMessage, self::CODE, null);
    }
    
}