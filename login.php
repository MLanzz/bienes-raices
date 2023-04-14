<?php
    // Base de datos
    require "includes/app.php";
    $db = conectarBD();

    $errores = array();

    // Autenticar usuario
    if ($_SERVER["REQUEST_METHOD"] === "POST") {
        // echo"<pre>";
        // var_dump($_POST);
        // echo"</pre>";

        $email = mysqli_real_escape_string($db, filter_var($_POST["email"], FILTER_VALIDATE_EMAIL)) ;
        $password = mysqli_real_escape_string($db, $_POST["password"]);

        if (!$email) {
            $errores[] = "El email es obligatorio o no es valido";
        }

        if (!$password) {
            $errores[] = "El password es obligatorio";
        }

        if (empty($errores)) {
            $query = "SELECT * FROM usuarios WHERE email = '{$email}'";
            $resultado = mysqli_query($db, $query);
            $usuario = mysqli_fetch_assoc($resultado);

            if ($usuario) {
                // Verificar si el passwrod es correcto
                $auth = password_verify($password, $usuario["password"]);

                if($auth) {
                    // El usuario esta autenticado
                    // Iniciamos la sesion de PHP
                    session_start();
                    // Agregamos información a la variable global de PHP $_SESSION
                    $_SESSION["email"] = $usuario["email"];

                    header("Location: /admin");


                } else {
                    $errores[] = "El password es incorrecto";
                }

            } else {
                $errores[] = "El usuario no existe";
            }
        }
    }

    incluirTemplate("header");
?>

<main class="contenedor seccion contenido-centrado">
    <h1>Iniciar sesión</h1>

    <?php foreach ($errores as $error): ?>
        <div class="alerta error">
            <?php echo $error; ?>
        </div>
    <?php endforeach ?>

    <form class="formulario" method="POST">
        <fieldset>
            <legend>
                Email y Password
            </legend>

            <label for="email">E-mail</label>
            <input type="email" name="email" value="" id="email" placeholder="Tu email" required>

            <label for="password">Password:</label>
            <input type="password" name="password" id="password" placeholder="Tu password" required>
        </fieldset>

        <input type="submit" class="boton-verde" value="Iniciar sesión">
    </form>

</main>

<?php
    incluirTemplate("footer");
?>