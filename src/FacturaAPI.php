<?php
class FacturaAPI {
    public $con;
    public function __construct($con)
    {
        $this->con = $con;
    }
    public function getFacturas(){
        $stmt = $this->con->prepare('SELECT * FROM factura');
        try{
            $stmt->setFetchMode(PDO::FETCH_ASSOC);
            $stmt->execute();
            while($row = $stmt->fetchAll()){
                return json_encode($row,JSON_PRETTY_PRINT);
            }
        }catch(PDOException $e){
            return json_encode($e->getMessage(),JSON_PRETTY_PRINT);
        }
    }
    public function getFacturasID($id){
        $stmt = $this->con->prepare('SELECT * FROM factura WHERE id = ' . $id);
        try{
            $stmt->setFetchMode(PDO::FETCH_ASSOC);
            $stmt->execute();
            while($row = $stmt->fetchAll()){
                return json_encode($row,JSON_PRETTY_PRINT);
            }
        }catch(PDOException $e){
            return json_encode($e->getMessage(),JSON_PRETTY_PRINT);
        }
    }
    public function postFacturas($cliente,$monto){
        $stmt = $this->con->prepare('INSERT INTO factura (cliente,monto) VALUES (:cliente,:monto)');
        try{
            $stmt->bindValue(':cliente', $cliente);
            $stmt->bindValue(':monto', $monto);
            $stmt->execute();
            return json_encode(['message' => 'Factura creada con exito'],JSON_PRETTY_PRINT);
        }catch (PDOException $e){
            return json_encode($e->getMessage(),JSON_PRETTY_PRINT);
        } 
    }
    public function putFacturas($id,$cliente,$monto){
        $stmt = $this->con->prepare('UPDATE factura SET cliente = :cliente, monto = :monto WHERE id ='. $id);
        try{
            $stmt->bindValue (':cliente', $cliente);
            $stmt->bindValue (':monto', $monto);
            $stmt->execute();
            return json_encode(['message' => 'Factura actualizada con exito', 'id' => $id],JSON_PRETTY_PRINT);
        }catch(PDOException $e){
            return json_encode($e->getMessage(),JSON_PRETTY_PRINT);
        }
    }
    public function deleteFacturas($id){
        try{
            $stmt = $this->con->prepare('DELETE FROM factura WHERE id ='. $id);
            $stmt->execute();
            return json_encode(['message' => 'Factura eliminada'],JSON_PRETTY_PRINT);
        }catch(PDOException $e){
            return json_encode($e->getMessage(),JSON_PRETTY_PRINT);
        }
    }
}
?>