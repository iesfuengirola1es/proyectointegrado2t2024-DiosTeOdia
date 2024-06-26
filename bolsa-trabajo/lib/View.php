<?php

/**
 * Clase View
 * 
 * Esta clase representa una vista en la aplicación. Se encarga de renderizar las vistas
 * correspondientes a cada acción del controlador.
 */
class View {
    public $tituloPage;
    public $error;
    public $mensaje;
    public $ofertas;
    public $oferta;
    public $aplicaciones;
    public $usuario;

    /**
     * Constructor de la clase View
     */
    function __construct(){
    }

    /**
     * Método render
     * 
     * Este método se encarga de renderizar una vista específica.
     * 
     * @param string $name El nombre de la vista a renderizar
     */
    function render($name){
        require 'views/' . $name . '.php';
    }
}