<?php 
class ProductosAPI {
    public $con;
    public function __construct($con)
    {
        $this->con = $con;
    }
    public function getProductos(){
        $stmt = $this->con->prepare("SELECT * FROM productos");
        try{
            $stmt->setFetchMode(PDO::FETCH_ASSOC);
            $stmt->execute();
                return json_encode($stmt->fetchAll(), JSON_PRETTY_PRINT);
        }catch(PDOException $e){
            return json_encode("Error: " . $e->getMessage(), JSON_PRETTY_PRINT);
        }
    }
    public function getProducto($id){
        $stmt = $this->con->prepare("SELECT * FROM productos where id = :id ");
        try{
            if(isset($id)){
                $stmt->bindValue(':id',$id);
                $stmt->setFetchMode(PDO::FETCH_ASSOC);
                $stmt->execute();
                while ($row = $stmt->fetchAll()){
                    return json_encode($row, JSON_PRETTY_PRINT);
                }
            }else{
                return json_encode("Error, no such product found", JSON_PRETTY_PRINT);
            }
        }catch(PDOException $e){
            return json_encode("Error: " . $e->getMessage(), JSON_PRETTY_PRINT);
        }
    }
    public function mediaProductos(){
        $stmt = $this->con->prepare("SELECT count(id) AS productos, avg(precio) AS media FROM productos");
        try{
            $stmt->setFetchMode(PDO::FETCH_ASSOC);	
            $stmt->execute();
            while ($row = $stmt->fetch()){
                return json_encode($row, JSON_PRETTY_PRINT);
            }
        }catch (PDOException $e){
            return json_encode("Error: " . $e->getMessage(), JSON_PRETTY_PRINT);
        }
    }
    public function buscarProductos($producto){
        $stmt = $this->con->prepare("SELECT nombre FROM productos WHERE nombre LIKE '$producto%'");
        try{
            $stmt->setFetchMode(PDO::FETCH_ASSOC);
            $stmt->execute();
            while ($row = $stmt->fetchAll()){
                return json_encode($row, JSON_PRETTY_PRINT);
            }
        }catch (PDOException $e){
            return json_encode("Error: " .$e->getMessage());
        }
    }
    public function crearProducto($nombre,$precio){
        $stmt = $this->con->prepare("INSERT INTO productos (nombre,precio) VALUES (:NOMBRE,:PRECIO)");
        return "Creando producto";
        try{
            $stmt->bindValue(':NOMBRE',$nombre);
            $stmt->bindValue(':PRECIO',$precio);
            $stmt->execute();
            return json_encode("Producto creado con exito", JSON_PRETTY_PRINT);
        }catch(PDOException $e){
            return json_encode("Error: " . $e->getMessage(), JSON_PRETTY_PRINT);
        }
    }
    public function putProducto($id,$nombre,$precio){
        $stmt = $this->con->prepare("UPDATE productos SET nombre = :NOMBRE, precio = :PRECIO WHERE id=:id");
        try{
            if(isset($id)){
                $stmt->bindValue(':id',$id);
                $stmt->bindValue(':NOMBRE',$nombre);
                $stmt->bindValue(':PRECIO',$precio);
                $stmt->execute();
                return json_encode('producto actualizado con exito', JSON_PRETTY_PRINT);
            }
        }catch(PDOException $e){
            return json_encode("Error: " . $e->getMessage(), JSON_PRETTY_PRINT);
        }
    }
    public function deleteProducto($id){
        $stmt = $this->con->prepare("DELETE FROM productos WHERE id = :id");
        try{
            if(isset($id)){
                $stmt->bindValue(':id',$id);
                $stmt->execute();
                return json_encode("Producto eliminado con exito", JSON_PRETTY_PRINT);
            }
        }catch(PDOException $e){
            return json_encode("Error: " . $e->getMessage(), JSON_PRETTY_PRINT);
        }
    }
}?>