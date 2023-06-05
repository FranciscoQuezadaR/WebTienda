<?php

class DB {
    private $host;
    private $db;
    private $user;

    public function __construct() {
        $this -> host       = 'localhost';
        $this -> db         = 'id19804793_fralu';
        $this -> user       = 'id19804793_fralul';
    }

    function connect() {
        try {
            $db = mysqli_connect($this -> host, $this -> user, 'Z7V5y+iq27=)ly9V', $this -> db);
            return $db;
        } catch (Exception $e) {
            print_r('Error connection: ' . $e -> getMessage());
        }
    }
}
?>