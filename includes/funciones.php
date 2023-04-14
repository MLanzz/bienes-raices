<?php
define('TEMPLATES_URL', __DIR__ . '/templates');
define('FUNCIONES_URL', __DIR__ . 'funciones.php');
define('CARPETA_IMAGENES', __DIR__ . '/../imagenes/');

function incluirTemplate( string $nombre, bool $inicio = false ) {
    include __DIR__ . "/template/{$nombre}.php";
}

function estaAutenticado () {
    session_start();

    if (empty($_SESSION)) {
        header('Location: /');
    }
}

function debuguear($variable) {
    echo "<pre>";
    var_dump($variable);
    echo "</pre>";
    exit();
}

// Escapar / sanitizar HTML
function sanitizarHTML($html) : string {
    return htmlspecialchars($html);
}

// Validar tipo de dato procesado
function validarTipo($tipo) {
    $tipos = ["propiedad", "vendedor"];

    return in_array($tipo, $tipos);
}

// Mostrar mensajes de error
function mostrarMensajeError($codigo) : string{
    $mensaje = "";

    switch (intval($codigo)) {
        case 1: 
            $mensaje = "Anuncio creado correctamente";
            break;
        case 2: 
            $mensaje = "Anuncio actualizado correctamente";
            break;
        case 3: 
            $mensaje = "Anuncio eliminado correctamente";
            break;
        case 4: 
            $mensaje = "Vendedor creado correctamente";
            break;
        case 5: 
            $mensaje = "Vendedor actualizado correctamente";
            break;
        default:
            $mensaje = "";
            break;
        }
    
    return $mensaje;
}