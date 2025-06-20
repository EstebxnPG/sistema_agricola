<!-- Archivo -->
<?php

// Credenciales acceso (Usamos XAMP)
$host = 'localhost';
$user = 'root';
$pass = '';
$db = 'sistema_agricola';

// Conexión a la base de datos
$conn =  new mysqli($host, $user, $pass, $db);

// Verificamos si hubo error
if ($conn->connect_error){
    die("Error de conexión: ". $conn->connect_error); // Si tenemos un error este nos mostrara el mensaje.
}