<?php 

require '../../includes/app.php';

use App\Vendedor;

estaAutenticado();

$vendedor = new Vendedor();

$errores = Vendedor::getErrores();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $vendedor->sincronizar($_POST);

    $errores = $vendedor->validar();

    if(empty($errores)) {
        $resultado = $vendedor->guardar();

        if ($resultado) {
            header("Location: /admin?resultado=4");
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

        <input type="submit" class="boton boton-verde" value="Registrar vendedor">
    </form>
</main>

<?php
    incluirTemplate("footer");
?>