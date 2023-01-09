<?php
require_once "class_fruta.php"; // Lo requiere si no ha sido requirido previamente
class Uva extends Fruta
{
    //Atributo
    private $tieneSemilla;

    //Metodo 'get'
    public function tieneSemilla()
    {
        return $this->tieneSemilla;
    }


    public function __construct($nuevo_color, $nuevo_tamano, $tiene)
    {
        $this->tieneSemilla = $tiene;

        //Aquí está llamando al padre
        parent::__construct($nuevo_color, $nuevo_tamano, $tiene);
    }

    public function imprimir()
    {
        parent::imprimir();   
        if($this->tieneSemilla){
            echo "<p>Tiene semillas</p>";
        } else {
            echo "<p>No tiene semillas</p>";
        }
    }




}
?>