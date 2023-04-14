<?php 

// Archivo para la creación de usuarios

require "includes/app.php";
$db = conectarBD();

$email = "correo@correo.com";
$password = "123456";
$passwordHash = password_hash($password, PASSWORD_DEFAULT);

$query = "INSERT INTO usuarios (email, password) VALUES ('{$email}', '{$passwordHash}')";

mysqli_query($db, $query);

?>