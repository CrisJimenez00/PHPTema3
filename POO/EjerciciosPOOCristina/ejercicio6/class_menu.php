<?php

//Clase
class Menu
{
    //Atributos
    private $enlace = [];
    private $nombre = [];

    //carga
    public function carga($nuevo_enlace, $nuevo_nombre)
    {
        $this->enlace[] = $nuevo_enlace;
        $this->nombre[] = $nuevo_nombre;

    }

    public function horizontal()
    {

        $total_nombre = count($this->nombre);
        $total_enlace = count($this->enlace);
        echo "<p>";
        for ($i = 0; $i < count($this->nombre) - 1; $i++) {
            echo "<a href='".$this->enlace[$i]."'>".$this->nombre[$i] . "</a> - ";
        }
        echo "<a href='".$this->enlace[$total_enlace-1]."'>".$this->nombre[$total_nombre - 1] . "</a></p> ";
    }
    public function vertical()
    {
        for ($i = 0; $i < count($this->nombre); $i++) {
            echo "<p><a href='".$this->enlace[$i]."'>" . $this->nombre[$i] . "</a></p>";
        }
    }

}
?>