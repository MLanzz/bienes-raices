<?php

require "funciones.php";
require "config/database.php";
require __DIR__ . "/../vendor/autoload.php";

use App\ActiveRecord;

// Nos conectamos a la base de datos
$db = conectarBD();

ActiveRecord::setDB($db);