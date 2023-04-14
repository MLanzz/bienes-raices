       
<?php

    // Incluir funciones
    require "../../includes/app.php";

    use App\Propiedad;
    use App\Vendedor;
    use Intervention\Image\ImageManagerStatic as Image;
    
    estaAutenticado();

    $id = $_GET["id"];
    // Sanitizamos el parametro de querystring
    $id = filter_var($id, FILTER_VALIDATE_INT);

    // Validamos que sea un id valido
    if (!$id) {
        header("Location: /admin");
    }

    $propiedad = Propiedad::findRecord($id);

    // Consulta vendedores
    $vendedores = Vendedor::getAll();

    // Arreglo con mensajes de errores
    $errores = Propiedad::getErrores();

    if ($_SERVER["REQUEST_METHOD"] === "POST") {

        $propiedad->sincronizar($_POST);

        if ($_FILES['imagen']['tmp_name']) {

            // Generar nombre único para el archivo a subir
            $nombreImagen = md5(uniqid(rand(), true)) . ".jpg";

            // Realiza un resize a la imagen con intevention
            $imagen = Image::make($_FILES['imagen']['tmp_name'])->fit(800, 600);
            $propiedad->setImagen($nombreImagen);
        }

        $errores = $propiedad->validar();

        if (empty($errores)){

            //-------------- Subida de archivos --------------
            if (isset($imagen)){
                $imagen->save(CARPETA_IMAGENES . $nombreImagen);
            }
            //-------------- /Subida de archivos -------------

            $resultado = $propiedad->guardar();

            if ($resultado) {
                // Redireccionamos
                header("Location: /admin?resultado=2");
            }

        }
    }

    incluirTemplate("header");
?>

<main class="contenedor seccion">
    <h1>Crear</h1>
    <a href="/admin" class="boton boton-verde">Volver</a>

    <?php foreach($errores as $error): ?>
        <div class="alerta error">
            <?php echo $error; ?>
        </div>
    <?php endforeach ?>

    <form method="post" class="formulario" enctype="multipart/form-data">
        
        <?php include '../../includes/template/formulario_propiedades.php' ?>

        <input type="submit" class="boton boton-verde" value="Actualizar propiedad">
    </form>
</main>

<?php
    incluirTemplate("footer");
?>