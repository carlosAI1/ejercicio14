<?php 
class db_lib{
    static function openCon($dsn, $user, $pass){
        try{
            $con = new PDO($dsn, $user, $pass,array(PDO::ATTR_PERSISTENT => true));
            $con->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); 
        }catch(PDOException $e){
            throw new RuntimeException('Error en la conexion a la base de datos, '.$e->getMessage());
        }finally{
            return $con;
        }  
    }
    static function closeCon($con){
        try{
            if($con != null){
                $con = null;
            }
        }catch(PDOException $e){
            throw new RuntimeException('Error' . $e->getMessage());
        }
    }
}
?>