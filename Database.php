<?php

class Database {

    private static $db;
    private $connection;

    private function __construct() {
        $this->connection = new mysqli("localhost", "root", "", "tickets");
        //$this->connection = new mysqli("localhost", "ticketsApi", "IceCold123!", "ticketsApi");
    }

    function __destruct() {
        $this->connection->close();
    }

    public static function getConnection() {
        if (self::$db == null) {
            self::$db = new Database();
        }
        return self::$db->connection;
    }
}

?>