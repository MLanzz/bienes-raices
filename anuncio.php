<?php
    require "includes/app.php";
    
    use App\Propiedad;

    $id = $_GET["id"];
    $id = filter_var($id, FILTER_VALIDATE_INT);

    if (!$id) {
        header("Location: index.php");
    }

    $propiedad = Propiedad::findRecord($id);

    if (!$propiedad) {
        header("Location: index.php");
    }

    incluirTemplate("header");
?>

<main class="contenedor seccion contenido-centrado">
    <h1><?php echo $propiedad->titulo; ?></h1>

    <img loading="lazy" width="200" height="300" src="/imagenes/<?php echo $propiedad->imagen; ?>" alt="imagen destacada">


    <div class="resumen-propiedad">
        <p class="precio">$<?php echo $propiedad->precio; ?></p>
        <ul class="iconos-caracteristicas">
            <li>
                <img src="build/img/icono_wc.svg" alt="" loading="lazy">
                <p><?php echo $propiedad->wc; ?></p>
            </li>
            <li>
                <img src="build/img/icono_estacionamiento.svg" alt="" loading="lazy">
                <p><?php echo $propiedad->estacionamiento; ?></p>
            </li>
            <li>
                <img src="build/img/icono_dormitorio.svg" alt="" loading="lazy">
                <p><?php echo $propiedad->habitaciones; ?></p>
            </li>
        </ul>
        <p><?php echo $propiedad->descripcion; ?></p>
    </div>
</main>

<?php
    incluirTemplate("footer");
?>