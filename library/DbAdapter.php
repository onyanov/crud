<?php

class DbAdapter {
    const CON_TPL = "host=%s dbname=%s user=%s password=%s";

    private $connection;
    
    private static $_instance = null;
    private function __construct() {}
    
    protected function __clone() {}

    static public function getInstance() {
        if (is_null(self::$_instance)) {
            self::$_instance = new self();
        }
        return self::$_instance;
    }
    
    public function connect() {
        $dbConfig = sprintf(self::CON_TPL, DB_HOST, DB_NAME, DB_NAME, DB_PASSWORD);
        $this->connection = pg_connect($dbConfig) 
                or die('Could not connect: ' . pg_last_error());
    }
    
    public function disconnect() {
        pg_close($this->connection);
    }
}