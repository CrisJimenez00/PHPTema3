<?php
//Clase
class Empleado
{
    //Atributos
    private $nombre;
    private $sueldo;

    //Constructor
    public function __construct($nuevo_nombre, $nuevo_sueldo)
    {
        $this->nombre = $nuevo_nombre;
        $this->sueldo = $nuevo_sueldo;

    }

    //Getter y setter
    public function get_nombre()
    {
        return $this->nombre;
    }
    public function get_sueldo()
    {
        return $this->sueldo;
    }
    //-----------------------------------
    public function set_nombre($nuevo_nombre)
    {
        return $this->nombre = $nuevo_nombre;
    }
    public function set_sueldo($nuevo_sueldo)
    {
        return $this->sueldo = $nuevo_sueldo;
    }


    //Método que imprime nombre y dice si paga o no impuestos
    public function pagaImpuestos()
    {
        echo "<p><strong> " . $this->nombre . "</strong>";
        if ($this->sueldo > 3000) {
            echo " tiene que pagar impuestos</p>";
        } else {
            echo " no tiene que pagar impuestos</p>";
        }
    }
}
?>