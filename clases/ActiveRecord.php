<?php

namespace App;

class ActiveRecord {
    // Base de datos
    protected static $db;

    // Definir la conexión a la base de datos
    public static function setDB($database) {
        self::$db = $database;
    }

    protected static $columnasDB = [];

    protected static $tabla = '';

    //Errores
    protected static $errores = [];

    public function guardar() {
        // Sanitizamos los parametros enviados antes de hacer el INSERT
        $atributos = $this->sanitizarAtributos();

        // Si tenemos un id es porque estamos actualizando
        if (!is_null($this->id)){

            $valoresUpdate = [];

            // Armamos un array con los campos para el UPDATE
            foreach($atributos as $key => $value) {
                $valoresUpdate[] = "{$key} = '{$value}'";
            }
            
            $query = "UPDATE " . static::$tabla . " SET ";
            $query .= join(', ', $valoresUpdate);
            $query .= " WHERE id = " . self::$db->escape_string($this->id);
            
        } else {
            // La función join() lo que nos permite es crear un string a partir de un array
            // Le pasamos como primer parametro un separador para, valga la redundancia, separar los elementos del array en el string
            $query = "INSERT INTO " . static::$tabla . " ( " . join(", ", array_keys($atributos)) . " ) VALUES ('" . join("', '", array_values($atributos)) . "')";
        }

        $resultado = self::$db->query($query);

        return $resultado;
    }

    // Eliminar propiedad
    public function eliminar() {

        $query = "DELETE FROM " . static::$tabla . " WHERE id = " . self::$db->escape_string($this->id) . " LIMIT 1";

        $this->borrarImagen();
        
        $resultado = self::$db->query($query);


        return $resultado;

    }

    public function sanitizarAtributos() {
        $atributosSanitizados = [];

        // Recorremos el array columnasDB que tiene la estructura de la tabla de propiedades en la BD
        // con el metodo escape_string() del objeto de mysqli $db sanitizamos cada atributo de la clase
        // y devolvemos un array con los datos sanitizados para evitar inyección SQL

        foreach (static::$columnasDB as $columna) {
            if ($columna == 'id') continue;
            $atributosSanitizados[$columna] = self::$db->escape_string($this->$columna);
        }

        return $atributosSanitizados;
    }

    // Subida de la imgen
    public function setImagen($imagen) {
        
        // Eliminamos la imagen previa en caso de que exista
        // Si tenemos un id es porque estamos editando, por lo tanto deberiamos tener una imagen
        if (!is_null($this->id)) {
            $this->borrarImagen();
        }


        //Asignar al atributo de imagen el nombre de la imagen
        if ($imagen) {
            $this->imagen = $imagen;
        }

    }

    // Eliminar archivo
    public function borrarImagen() {
        $existeArchivo = file_exists(CARPETA_IMAGENES . $this->imagen);

        if ($existeArchivo) {
            unlink(CARPETA_IMAGENES . $this->imagen);
        }

    }

    public static function getErrores() {
        return static::$errores;
    }

    public function validar() {

        static::$errores = [];
        return static::$errores;
    }

    // Obtener todas los registros
    public static function getAll() {
        $query = "SELECT * FROM " . static::$tabla;

        return self::consultarSQL($query);

    }

    // Obtener una cantidad determinada de registros
    public static function get($limite) {
        $query = "SELECT * FROM " . static::$tabla . " LIMIT " . $limite;

        return self::consultarSQL($query);

    }

    // Buscamos un registro por el id
    public static function findRecord($id) {
        $query = "SELECT * FROM " . static::$tabla . " WHERE id = {$id}";

        $resultado = self::consultarSQL($query);

        return array_shift($resultado); 

    }

    public static function consultarSQL ($query) {
        // 1. Consultamos la base de datos
        $resultado = self::$db->query($query);

        // 2. Iteramos los resultados
        $array = [];

        /* Lo que estamos haciendo acá es crear un array con los registros en la base de datos en forma de objetos */
        while ($registro = $resultado->fetch_assoc()) {
            $array[] = static::crearObjeto($registro) ;
        }

        // 3. Liberamos memoria
        $resultado->free();

        // 4. Retornamos los resultados
        return $array;

    }

    protected static function crearObjeto($array) {
        // Lo que hacemos acá es crear una nueva instacia de la misma clase en la que estamos
        // Usamos static para hacer referencia a la clase que hereda a ActiveRecord y no a ActiveRecord como tal
        $objeto = new static;

        /* Recorremos el $array y si existe el atributo en la instancia que creamos anteriormente, lo mapeamos con el valor del
        array que se corresponda */ 
        foreach ($array as $key => $value) {
            if ( property_exists($objeto, $key) ) {
                $objeto->$key = $value;
            }
        }

        return $objeto;
    }

    public function sincronizar($args = []) {
        foreach ($args as $key => $value) {
            if (property_exists($this, $key) && !is_null($value)) {
                $this->$key = $value;
            }
        }
    }
}