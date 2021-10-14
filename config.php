<?php

$mysqli = new mysqli("localhost", "root", "", "productos");

if ($mysqli->connect_errno) {
    echo "Error al conectar con la base de datos: " . $mysqli->connect_error;
}

?>