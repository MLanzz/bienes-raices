<?php
    // Incluir funciones
    require "../../includes/app.php";
    use App\Propiedad;
    use App\Vendedor;
    use Intervention\Image\ImageManagerStatic as Image;

    // Si no se esta autenticado, se redireccionara al index
    estaAutenticado();

    // Consulta para obtener los vendedores
    $vendedores = Vendedor::getAll();

    // Arreglo con mensajes de errores
    $errores = Propiedad::getErrores();

    $propiedad = new Propiedad();

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

            if (!is_dir(CARPETA_IMAGENES)) {
                mkdir(CARPETA_IMAGENES);
            }

            // Guardamos la imagen en el servidor
            $imagen->save(CARPETA_IMAGENES . $nombreImagen);
    
            // Guardamos en la base de datos
            $resultado = $propiedad->guardar();

            if ($resultado) {
                // Redireccionamos
                header("Location: /admin?resultado=1");
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

        <input type="submit" class="boton boton-verde" value="Crear propiedad">
    </form>
</main>

<?php
    incluirTemplate("footer");
?>