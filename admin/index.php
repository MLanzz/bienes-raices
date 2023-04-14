<?php
    use App\Propiedad;
    use App\Vendedor;

    require "../includes/app.php";
    estaAutenticado();


    $propiedades = Propiedad::getAll();
    $vendedores = Vendedor::getAll();

    // Mensaje condicional
    $resultado = $_GET["resultado"] ?? null;

    
    if ($_SERVER["REQUEST_METHOD"] === "POST") {
        
        $id = $_POST["id"];

        $tipo = $_POST["tipo"];

        if (validarTipo($tipo)) {
            if ($tipo === "propiedad") {
                $propiedad = Propiedad::findRecord($id);
                $resultado = $propiedad->eliminar();
            } else if ($tipo === "vendedor") {
                $vendedor = Vendedor::findRecord($id);
                $resultado = $vendedor->eliminar();
            }
            
    
            if ($resultado) {
                header("Location: /admin?resultado=3");
            }

        }

    }

    incluirTemplate("header");
?>

<main class="contenedor seccion">

    <h1>Administrador de bienes raices</h1>

    <?php 
    $mensaje = mostrarMensajeError(intval($resultado));
    if ($mensaje): ?>
        <p class="alerta exito"><?php echo $mensaje ?></p>
    <?php endif; ?>
    
    <h2>Propiedades</h2>
    
    <a href="/admin/propiedades/crear.php" class="boton boton-verde">Nueva propiedad</a>


    <table class="propiedades">
        <thead>
            <tr>
                <th>ID</th>
                <th>Titulo</th>
                <th>Imagen</th>
                <th>Precio</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            <!-- Mostrar resultados de la consulta a la base de datos -->
            <?php foreach($propiedades as $propiedad): ?>
                <tr>
                    <td><?php echo $propiedad->id; ?></td>
                    <td><?php echo $propiedad->titulo; ?></td>
                    <td><img src="/imagenes/<?php echo $propiedad->imagen; ?>" class="imagen-tabla"></td>
                    <td>$<?php echo $propiedad->precio; ?></td>
                    <td>
                        <form method="POST" class="w-100">
                            <input type="hidden" name="id" value="<?php echo $propiedad->id; ?>">
                            <input type="hidden" name="tipo" value="propiedad">
                            <input type="submit" class="boton-rojo-block" value="Eliminar">
                        </form>
                        <a href="admin/propiedades/actualizar.php?id=<?php echo $propiedad->id; ?>" class="boton-amarillo-block">Actualizar</a>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>

    <h2>Vendedores</h2>

    <a href="/admin/vendedores/crear.php" class="boton boton-verde">Nuevo vendedor</a>

    <table class="propiedades">
        <thead>
            <tr>
                <th>ID</th>
                <th>Nombre</th>
                <th>Teléfono</th>
                <th>E-Mail</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            <!-- Mostrar resultados de la consulta a la base de datos -->
            <?php foreach($vendedores as $vendedor): ?>
                <tr>
                    <td><?php echo $vendedor->id; ?></td>
                    <td><?php echo $vendedor->nombre . " " . $vendedor->apellido; ?></td>
                    <td><?php echo $vendedor->telefono; ?></td>
                    <td><?php echo $vendedor->email; ?></td>
                    <td>
                        <form method="POST" class="w-100">
                            <input type="hidden" name="id" value="<?php echo $vendedor->id; ?>">
                            <input type="hidden" name="tipo" value="vendedor">
                            <input type="submit" class="boton-rojo-block" value="Eliminar">
                        </form>
                        <a href="admin/vendedores/actualizar.php?id=<?php echo $vendedor->id; ?>" class="boton-amarillo-block">Actualizar</a>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</main>

<?php
    incluirTemplate("footer");
?>