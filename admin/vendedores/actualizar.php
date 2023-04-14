<?php 

require '../../includes/app.php';

use App\Vendedor;

estaAutenticado();

$id = $_GET["id"];
// Sanitizamos el parametro de querystring
$id = filter_var($id, FILTER_VALIDATE_INT);

// Validamos que sea un id valido
if (!$id) {
    header("Location: /admin");
}

$vendedor = Vendedor::findRecord($id);

$errores = Vendedor::getErrores();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $vendedor->sincronizar($_POST);

    $errores = $vendedor->validar();

    if (empty($errores)) {
        // debuguear($vendedor);
        $resultado = $vendedor->guardar();

        if ($resultado) {
            header("Location: /admin?resultado=5");
        }
    }

}

incluirTemplate('header');


?>

<main class="contenedor seccion">
    <h1>Registrar vendedor</h1>
    <a href="/admin" class="boton boton-verde">Volver</a>

    <?php foreach($errores as $error): ?>
        <div class="alerta error">
            <?php echo $error; ?>
        </div>
    <?php endforeach ?>

    <form method="post" class="formulario">

        <?php include '../../includes/template/formulario_vendedores.php' ?>

        <input type="submit" class="boton boton-verde" value="Actualizar vendedor">
    </form>
</main>

<?php
    incluirTemplate("footer");
?>