<?php

function conectarBD() : mysqli {
    // $db = mysqli_connect("localhost", "root", "", "bienesraices_crud");
    // Servidor remoto
    // $db = new mysqli("34.30.229.99", "administrador", "root151416", "bienesraices_crud");
    // Servidor local
    $db = new mysqli("localhost", "root", "", "bienesraices_crud");

    if(!$db) {
        echo "Error no se pudo conectar";
        exit;
    }
    
    return $db;
}