<?php

require("config.php");

class Producto
{
    private $id;
    private $nombre;
    private $precio;
    private $agotado;
    private $comentario;
    private $imagen;

    public function __get($propiedad)
    {
        return $this->$propiedad;
    }

    public function __set($propiedad, $valor)
    {
        return $this->$propiedad = $valor;
    }

    public function obtenerTodo()
    {
        require("config.php");
        $query = "SELECT * FROM productos";
        $resultado = $mysqli->query($query);
        if($resultado)
        {
            $lista = array();
            while($fila = $resultado->fetch_assoc())
            {
                $obj = new Producto();
                $obj->id = $fila["id"];
                $obj->nombre = $fila["nombre"];
                $obj->precio = $fila["precio"];
                $obj->agotado = $fila["agotado"];
                $obj->comentario = $fila["comentario"];
                $obj->imagen = $fila["imagen"];
                $lista[] = $obj;
            }
            return $lista;
        }
        $mysqli->close();
    }

    public function nuevo() {
        require("config.php");
        $query = "INSERT INTO productos(nombre, precio, agotado, comentario, imagen)
        VALUES (
            '" . $this->nombre . "',
            '" . $this->precio . "',
            '" . $this->agotado . "',
            '" . $this->comentario . "',
            '" . $this->imagen . "'
        )";
        $mysqli->query($query);
        $this->id = $mysqli->insert_id;
        $mysqli->close();
    }

    public function obtenerPorId()
    {
        require("config.php");
        $query = "SELECT * FROM productos WHERE id =" . $this->id;
        $resultado = $mysqli->query($query);
        if($fila = $resultado->fetch_assoc())
        {
            $this->id = $fila["id"];
            $this->nombre = $fila["nombre"];
            $this->precio = $fila["precio"];
            $this->agotado = $fila["agotado"];
            $this->comentario = $fila["comentario"];
            $this->imagen = $fila["imagen"];
        }
        $mysqli->close();
    }

    public function editar()
    {
        require("config.php");
        $query = "UPDATE productos SET
        nombre = '" . $this->nombre . "',
        precio = '" . $this->precio . "',
        agotado = '" . $this->agotado . "',
        comentario = '" . $this->comentario . "',
        imagen = '" . $this->imagen . "' WHERE id =" . $this->id;
        $mysqli->query($query);
        $mysqli->close();
    }

    public function borrar()
    {
        require("config.php");
        $query = "DELETE FROM productos WHERE id =" . $this->id;
        $mysqli->query($query);
        $mysqli->close();
    }
}

?>