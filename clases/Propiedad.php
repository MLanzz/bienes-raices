<?php

namespace App;

class Propiedad extends ActiveRecord {

    protected static $columnasDB = ['id', 'titulo', 'precio', 'imagen', 'descripcion', 'habitaciones', 'wc', 'estacionamiento', 'vendedorId'];

    protected static $tabla = 'propiedades';

    public $id;
    public $titulo;
    public $precio;
    public $imagen;
    public $descripcion;
    public $habitaciones;
    public $wc;
    public $estacionamiento;
    public $creado;
    public $vendedorId;

    public function __construct($args = []) {
        $this->id = $args["id"] ?? null;
        $this->titulo = $args["titulo"] ?? '';
        $this->precio = $args["precio"] ?? '';
        $this->imagen = $args["imagen"] ?? '';
        $this->descripcion = $args["descripcion"] ?? '';
        $this->habitaciones = $args["habitaciones"] ?? '';
        $this->wc = $args["wc"] ?? '';
        $this->estacionamiento = $args["estacionamiento"] ?? '';
        $this->creado = date('Y/m/d');
        $this->vendedorId = $args["vendedorId"] ?? '';
    }
    
    public function validar() {

        if(!$this->titulo) {
            self::$errores[] = "Debes ingresar el titulo";
        }

        if(!$this->precio) {
            self::$errores[] = "Debes ingresar el precio";
        } else {
            if($this->precio <= 0) {
                self::$errores[] = "El precio debe ser mayor a 0";
            }
        }
        
        if(!$this->descripcion) {
            self::$errores[] = "Debes ingresar una descripción";
        }

        if(!$this->habitaciones) {
            self::$errores[] = "Debes indicar la cantidad de habitaciones";
        }

        if(!$this->wc) {
            self::$errores[] = "Debes indicar la cantidad de baños";
        }

        if(!$this->estacionamiento) {
            self::$errores[] = "Debes indicar la cantidad de estacionamientos";
        }

        if(!$this->vendedorId) {
            self::$errores[] = "Debes indicar el vendedor";
        }

        if (!$this->imagen) {
            self::$errores[] = "La imagen es obligatoria";
        }
        return self::$errores;
    }
}
