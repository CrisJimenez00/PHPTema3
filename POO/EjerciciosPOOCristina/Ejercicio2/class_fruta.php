<?php
//Creamos la clase
class Fruta
{
    //Atributos(como están en la clase se pone private)
    //Si vemos var es como si pusiera public.
    private $color;
    private $tamano;
    public function set_color($color_nuevo)
    {
        //El $ se pone en this, no en color(puede dar error)
        $this->color = $color_nuevo;
    }
    public function set_tamano($tamano_nuevo)
    {
        //El $ se pone en this, no en color(puede dar error)
        $this->tamano = $tamano_nuevo;
    }
    public function get_color()
    {
        //El $ se pone en this, no en color(puede dar error)
        return $this->color;
    }
    public function get_tamano()
    {
        //El $ se pone en this, no en color(puede dar error)
        return $this->tamano;
    }

}

?>