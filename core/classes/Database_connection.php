<?php 
// make connection with database

class Database_connection {
    function connect() {
        $dsn = 'mysql:host=localhost;dbname=tchat';
        $user = 'root';
        $pass = '';
        $option = array(
            PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8',
        );    
        try{
            $con = new PDO($dsn, $user, $pass, $option);
            $con->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            return $con;
        }
        catch(PDOException $e) {
            return false;
        }
    } 
}
?>