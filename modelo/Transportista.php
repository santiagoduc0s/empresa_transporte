<?php

class Transportista extends Usuario
{
    private $direccion;
    private $telefono;
    private $estadoTransportista;

    function __get($atributo)
    {
        if (property_exists(__CLASS__, $atributo))
        {
            return $this->$atributo;
        }
        else
        {
            die("No se encontró el atributo '$atributo' (Transposrtista.php-get)");
        }
    }

    function __set($atributo, $valor)
    {
        if (property_exists(__CLASS__, $atributo))
        {
            $this->$atributo = $valor;
        }
        else
        {
            die("No se encontró el atributo '$atributo' (Transportista.php-set)");
        }
    }
}

?>