<?php

namespace App;
use App\ActiveRecord;

class Vendedor extends ActiveRecord {
    protected static $columnasDB = ['id', 'nombre', 'apellido', 'telefono', 'email'];

    protected static $tabla = 'vendedores';
    
    public $id;
    public $nombre;
    public $apellido;
    public $telefono;
    public $email;

    public function __construct($args = []) {
        $this->id = $args["id"] ?? null;
        $this->nombre = $args["nombre"] ?? '';
        $this->apellido = $args["apellido"] ?? '';
        $this->telefono = $args["telefono"] ?? '';
        $this->telefono = $args["email"] ?? '';
    }

    public function validar() {

        if (!$this->nombre) {
            self::$errores[] = "Debe ingresar el nombre del vendedor";
        }

        if (!$this->apellido) {
            self::$errores[] = "Debe ingresar el apellido del vendedor";
        }

        if (!$this->telefono) {
            self::$errores[] = "Debe ingresar número de teléfono del vendedor";
        }

        if ($this->email && !filter_var($this->email, FILTER_VALIDATE_EMAIL)){
            self::$errores[] = "El e-mail ingreso no es valido";
        }

        if (!$this->telefono || !preg_match("/[0-9]{10}/", $this->telefono)){
            self::$errores[] = "El formato del telefono no es valido";
        }

        return self::$errores;
    }
}