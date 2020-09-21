<?php

class Paquete
{
    private $codigo;
    private $fragil;
    private $pedecedero;
    private $direccionRemitente;
    private $direccionEnvio;
    private $fechaEstimadaEntrega;
    private $estadoPaquete;
    private $fechaYHoraAsignacion;
    private $fechaEntrega;

    function __get($atributo)
    {
        if (property_exists(__CLASS__, $atributo))
        {
            return $this->$atributo;
        }
        else
        {
            die("No se encontró el atributo '$atributo' (Paquete.php-get)");
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
            die("No se encontró el atributo '$atributo' (Paquete.php-set)");
        }
    }
}

?>