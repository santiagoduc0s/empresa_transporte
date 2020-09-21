<?php

require_once "../modelo/Conexion.php";
require_once "../modelo/Usuario.php";
require_once "../modelo/Transportista.php";
require_once "../modelo/Encargado.php";
require_once "../manejador/ManejadorTransportista.php";
require_once "../manejador/ManejadorEncargado.php";

if (isset($_POST['login'])) // VERIFICAMOS QUE SE INTENTE ENTRAR A ESTA PAGINA DESDE EL LOGIN USUARIO
{
    // EXTRAEMOS LA CEDULA INGRESADA EN LA VISTA
    $cedula = $_POST["cedula"];
    // EXTRAEMOS EL PIN INGRESADO EN LA VISTA
    $pin = md5($_POST["pin"]);
    // EXTRAEMOS EL TIPO DE USUARIO
    $tipoUsuario = $_POST['tipoUsuario'];

    session_start();

    if ($tipoUsuario == 'transportista') // SI EL USUARIO ES UN TRANSPORTISTA
    {
        // CREAMOS UN OBJETO DE TIPO TRANSPORTISTA PARA ALMACENAR LA INFORMACION DE LA VISTA
        $transportistaLogin = new Transportista;
        $transportistaLogin->cedula = $cedula;
        $transportistaLogin->pin = $pin;

        $manejadorTransportista = new ManejadorTransportista;
        // VERIFICAMOS SI LOS DATOS CORRESPONDEN A UN TRANSPORTISTA
        $puedeIngresar = $manejadorTransportista->autenticarTransportista($transportistaLogin);

        if ($puedeIngresar) // SI ES UN TRANSPORTISTA
        {
            $transportistaLogin->nombre = $manejadorTransportista->nombreTransportista($transportistaLogin);

            // GUARDAMOS AL TRANSPORTISTA CREADO EN LA SESION
            $_SESSION['usuario'] = $transportistaLogin;
            // CREAMOS UNA COOKIE PARA CONTROLAR EL TIEMPO DEL TRANSPORTISTA DENTRO DE LA APLICACION
            setcookie('tiempoDeSesion', 'transportista', time() + 60 * 60, '/');

            // LO REDIRECCIONAMOS AL HOME TRANSPORTISTA
            header('Location: ../vista/transportista/homeTransportista.php');
        }
        else // SI NO ES UN TRANSPORTISTA
        {
            // REDIRECCIONAMOS AL LOGIN
            header("Location: ../vista/loginUsuario.php?mensaje=Hay un error en los datos del transportista ingresado.");
        }
    }
    else if ($tipoUsuario == 'encargado') // SI EL SUARIO ES UN ENCARGADO
    {
        /* FUNCIONA IGUAL QUE EL TRANSPORTISTA. LA UNICA DIFERENCIA ES QUE EN VEZ DE GUARDAR UN TRANSPORTISTA
        EN LA SESION, SE GUARDA UN ENCARGADO*/
        $encargadoLogin = new Encargado;
        $encargadoLogin->cedula = $cedula;
        $encargadoLogin->pin = $pin;

        $manejadorEncargado = new ManejadorEncargado;
        $puedeIngresar = $manejadorEncargado->autenticarEncargado($encargadoLogin);

        if ($puedeIngresar)
        {
            $encargadoLogin->nombre = $manejadorEncargado->nombreEncargado($encargadoLogin);

            $_SESSION['usuario'] = $encargadoLogin;
            setcookie('tiempoDeSesion', 'encargado', time() + 60 * 60, '/');

            header('Location: ../vista/encargado/homeEncargado.php');
        }
        else
        {
            header("Location: ../vista/loginUsuario.php?mensaje=Hay un error en los datos del encargado ingresado.");
        }
    }
    else // SI NO ES UN TRANSPORTISTA O UN ENCARGADO
    {
        header("Location: ../vista/formularioLogin.php?mensaje=Hubo un problema en el sistema, avise de esta problematica a su superior.");
    }
}
else // SI SE INTENTA INGRESAR A ESTA PAGINA DESDE LA URL
{
    // REDIRECCIONAMOS AL LOGIN USUARIO
    header("Location: ../vista/formularioLogin.php");
}

?>