<?php

session_start();

// VERIFICAMOS SI HAY UN USUARIO INGRESADO
if (!isset($_SESSION['usuario']))
{
    setcookie('tiempoDeSesion', false, time() - 1, '/');
    header('Location: ../loginUsuario.php?mensaje=Primero tiene que ingresar sus datos.');
    die();
}

// VERIFICAMOS SI EL TIEMPO DE SESION A EXPIRADO
if (!isset($_COOKIE['tiempoDeSesion']))
{
    session_destroy();
    header('Location: ../loginUsuario.php?mensaje=Tiempo de sesion finalizado.');
    die();
}

?>