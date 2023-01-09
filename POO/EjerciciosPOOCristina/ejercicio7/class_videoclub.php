<?php
//Clase
class Videoclub {
    //Atributos
    private $titulo;
    private $director;
    private $precio;//€
    private $alquilada;//true-false
    private $fec_prev_dev;//date
    private $recargo;//€

    //Constructor
    function __construct($titulo, $director, $precio, 
    $alquilada, $fec_prev_dev){
        $this->titulo = $titulo;
        $this->director = $director;
        $this->precio = $precio;
        $this->alquilada = $alquilada;
        $this->fec_prev_dev = new DateTime($fec_prev_dev);
    }

    //Getter y Setter
    function get_titulo(){
        return $this->titulo;
    }

    function get_director(){
        return $this->director;
    }

    function get_precio(){
        return $this->precio;
    }

    function get_alquilada(){
        return $this->alquilada;
    }

    function get_fechaPrevDev(){
        return $this->fec_prev_dev->format('d/m/Y');
    }

    function set_titulo($titulo_new){
        $this->titulo = $titulo_new;
    }

    function set_director($director_new){
        $this->director = $director_new;
    }

    function set_precio($precio_new){
        $this->precio = $precio_new;
    }

    function set_alquilada($alquilada_new){
        $this->alquilada = $alquilada_new;
    }

    function set_fecDevPrev($fec_prev_dev_new){

        $this->fec_prev_dev = new DateTime($fec_prev_dev_new);
    }

    //Método que calcula el recargo
    function calcularRecargo(){
        $fec_actual = new DateTime('now');

        if($fec_actual > $this->fec_prev_dev){
            $dif_dias = $fec_actual->diff($this->fec_prev_dev);
            $this->recargo = 1.2 * $dif_dias->days;
        }else{
            $this->recargo = 0;
        }
        return $this->recargo;
    }
}

?>