<?php

require_once '../modelo/Conexion.php';
require_once "../modelo/Usuario.php";
require_once '../modelo/Transportista.php';
require_once '../modelo/Paquete.php';
require_once '../manejador/ManejadorTransportista.php';

if (isset($_GET['accion']))
{
    $accion = $_GET['accion'];
    $manejadorTransportista = new ManejadorTransportista;

    session_start();

    // EXTRAEMOS AL TRANSPORTISTA DE LA SESION
    $transportistaSesion = $_SESSION['usuario'];

    if ($accion == 'finalizarEntrega' and isset($_GET['codigoPaquete'])) // FINALIZAR ENTREGA
    {
        // EXTRAEMOS EL CODIGO DEL PAQUETE SELECCIONADO
        $codigoPaquete = $_GET['codigoPaquete'];
        // FINALIZAMOS LA ENTREGA DEL PAQUETE
        $manejadorTransportista->finalizarEntrega($transportistaSesion, $codigoPaquete);
        
        // REDIRECCIOANAMOS AL HOME TRANSPORTISTA
        header("Location: ../vista/transportista/homeTransportista.php");
    }
    else if ($accion == "asignarPaquete" and isset($_POST['asignarPaquete'])) // ASIGNAR UN PAQUETE AL TRANSPORTISTA
    {
        // EXTRAEMOS EL CODIGO DEL PAQUETE SELECCIONADO 
        $codigoPaquete = $_POST['codigoPaquete'];
        // EXTRAEMOS LA FECHA ESTIMADA DE LA ENTREGA DEL PAQUETE
        $fechaEstimadaEntrega = $_POST['fechaEstimadaEntrega'];

        // ASIGNAMOS ESE PAQUETE AL TRANSPORTISTA
        $manejadorTransportista->asignarPaquete($transportistaSesion, $codigoPaquete, $fechaEstimadaEntrega);

        // REDIRECCIONAMOS AL HOME TRANSPORTISTA
        header("Location: ../vista/transportista/homeTransportista.php");
    }
}
else // SI SE INTENTA INGRESAR A ESTA PAGINA DESDE LA URL
{
    // REDIRECCIONAMOS AL HOME DE TRANSPORTISTA
    header("Location: ../vista/transportista/homeTransportista.php");
}

?>