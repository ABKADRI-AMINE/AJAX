<?php
class db {
    private static $servername = "localhost";
    private static $username = "root";
    private static $pass = "";
    private static $dbname = "tppetition";
    private static $conn = null;

    public function __construct() {
        die('Connection failed');
    }

    public static function connect() {
        if (null == self::$conn) {
            try {
                self::$conn = new PDO("mysql:host=" . self::$servername . ";" . "dbname=" . self::$dbname, self::$username, self::$pass);
            } catch (PDOException $e) {
                echo "Connection failed: " . $e->getMessage();
            }
        }
        return self::$conn;
    }

    public static function disconnect() {
        self::$conn = null;
    }
}
?>
