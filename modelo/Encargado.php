<?php

class Encargado extends Usuario
{
    private $email;

    function __get($atributo)
    {
        if (property_exists(__CLASS__, $atributo))
        {
            return $this->$atributo;
        }
        else
        {
            die("No se encontró el atributo '$atributo' (Encargado.php-get)");
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
            die("No se encontró el atributo '$atributo' (Encargado.php-set)");
        }
    }
}

?>