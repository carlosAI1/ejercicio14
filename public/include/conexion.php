<?php 
include (__DIR__ . '/../../src/db_lib.php');
$lib = new db_lib();
try{
    $dsn = 'mysql:host=localhost;dbname=restdb';
    $user = 'root';
    $pass = '';
    $con = $lib->openCon($dsn, $user, $pass);
}catch(PDOException $e){
    ECHO $e->getMessage();
}
?>