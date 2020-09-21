<?php

require_once '../modelo/Conexion.php';
require_once '../modelo/Usuario.php';
require_once '../modelo/Paquete.php';
require_once '../modelo/Encargado.php';
require_once '../modelo/Transportista.php';
require_once '../manejador/ManejadorEncargado.php';

if (isset($_GET['accion']))
{
    // EXTREAMOS LA ECCION QUE VAMOS A REALIZAR
    $accion = $_GET['accion'];

    $manejadoEncargado = new ManejadorEncargado;

    if ($accion == 'eliminarPaquete' and isset($_GET['codigoPaquete'])) // ELIMMINAR UN PAQUETE
    {
        // EXTRAEMOS EL CODIGO DEL PAQUETE SELECCIONADO
        $codigoPaquete = $_GET['codigoPaquete'];

        // ELIMINAMOS EL PAQUETE
        $manejadoEncargado->eliminarPaquete($codigoPaquete);

        // REDIRECCIONAMOS Al ADMINISTRADOR DE PAQUETES
        header("Location: ../vista/encargado/administracionPaquetesEncargado.php");
    }
    else if ($accion == 'modificarPaquete' and isset($_POST['modificarPaquete'])) // MODIFICAR UN PAQUETE
    {
        // CREAMOS UN OBJETO DE TIPO PAQUETE PARA ALMACENAR LA INFORMACION DE LA VISTA
        $paqueteParaModificar = new Paquete;

        $paqueteParaModificar->codigo = $_POST['codigoPaquete'];
        $paqueteParaModificar->fragil = $_POST['fragil'];
        $paqueteParaModificar->pedecedero = $_POST['pedecedero'];
        $paqueteParaModificar->direccionRemitente = strtolower(trim($_POST['direccionRemitente']));
        $paqueteParaModificar->direccionEnvio = strtolower(trim($_POST['direccionEnvio']));

        // MODIFICAMOS EL PAQUETE
        $manejadoEncargado->modificarPaquete($paqueteParaModificar);

        // REDIRECCIONAMOS AL ADMINITRADOR DE PAQUETES
        header("Location: ../vista/encargado/administracionPaquetesEncargado.php");
    }
    else if ($accion == 'crearPaquete' and isset($_POST['crearPaquete'])) // CREAR UN PAQUTE
    {
        // CREAMOS UN OBJETO DE TIPO PAQUETE PARA ALMACENAR LA INFORMACION DE LA VISTA
        $paqueteParaCrear = new Paquete;

        $paqueteParaCrear->direccionRemitente = strtolower(trim($_POST['direccionRemitente']));
        $paqueteParaCrear->direccionEnvio = strtolower(trim($_POST['direccionEnvio']));
        $paqueteParaCrear->fragil = $_POST['fragil'];
        $paqueteParaCrear->pedecedero = $_POST['pedecedero'];

        // CREAMOS EL PAQUETE
        $manejadoEncargado->crearPaquete($paqueteParaCrear);

        // REDIRECCIONAMOS AL ADMINITRADOR DE PAQUETES
        header('Location: ../vista/encargado/administracionPaquetesEncargado.php');
    }
    else if ($accion == 'registrarTransportista' ) // REGISTRAR UN TRANSPORTISTA
    {
        // EXTRAEMOS LA CEDULA DE LA VISTA
        $cedula = $_POST['cedula'];

        // VERIFICAMOS QUE LE CEDULA NO ESTÉ REPETIDA
        $cedulaRepetida = $manejadoEncargado->cedulaTransportistaRepetida($cedula);

        if (!$cedulaRepetida) // SI LA CEDULA NO ESÁ REPETIDA
        {
            // GUARDAMOS LA FOTO INGRESADA
            $verificacionFoto = $manejadoEncargado->verificarFotoDeTransportista($_FILES['foto']);

            if (is_array($verificacionFoto)) // SI NO HUBO NINGUN ERROR EN EL GUARDADO DE LA FOTO
            {
                // EXTRAEMOS LA UBICACION DE LA FOTO
                $pathFoto = $verificacionFoto['pathDeLaFoto'];

                // CREAMOS UN OBJETO DE TIPO TRANSPORTISTA PARA GUARDAR LA INFORMACION
                $transportista = new Transportista;
                
                $transportista->cedula = $cedula;
                $transportista->nombre = strtolower(trim($_POST['nombre']));
                $transportista->apellido = strtolower(trim($_POST['apellido']));
                $transportista->direccion = strtolower(trim($_POST['direccion']));
                $transportista->telefono = str_replace(' ', '', $_POST['telefono']);
                $transportista->pin = md5($_POST['pin']);
                $transportista->foto = $pathFoto;

                // REGISTRAMOS AL TRANSPORTISTA
                $manejadoEncargado->registrarTransportista($transportista);

                // REDIRECCIONAMOS A LA ADMINISTRACION DE TRANSPORTISTAS
                header("Location: ../vista/encargado/administracionTransportistasEncargado.php");
            }
            else // SI HUBO UN ERROR EN LA FOTO
            {
                // REDIRECCIONAMOS AL REGISTRO DEL TRANSPORTISTA
                header("Location: ../vista/encargado/registrarTransportistaEncargado.php?mensaje=$verificacionFoto");
            }
        }
        else // SI LA CEDULA ESTÁ REPETIDA
        {
            // REDIRECCIONAMOS AL REGISTRO DEL TRANSPORTISTA
            header('Location: ../vista/encargado/registrarTransportistaEncargado.php?mensaje=Esta cedula ya fue registrada');
        }
    }
    else if ($accion == 'eliminarTransportista' and isset($_GET['cedulaTransportista'])) // ELIMINAR UN TRANSPORTISTA
    {
        // EXTRAEMOS LA CEDULA DEL TRANSPORTISTA SELECCIONADO EN LA VISTA
        $cedulaTransportista = $_GET['cedulaTransportista'];

        // ELIMINAMOS AL TRANPORTISTA
        $manejadoEncargado->eliminarTransportista($cedulaTransportista);
        
        // REDIRECCIONAMOS AL LA ADMINISTRACION DE TRANSPORTISTAS
        header("Location: ../vista/encargado/administracionTransportistasEncargado.php");
    }
    else if ($accion == 'modificarTransportista' and isset($_POST['modificarTransportista'])) // MODIFICAR UN TRANSPORTISTA
    {
        // EXTRAEMOS LA CEDULA NUEVA DE LA VISTA
        $cedulaNueva = $_POST['cedulaTransportistaNueva'];
        // EXTRAEMOS LA CEDULA VIEJA DE LA VISTA
        $cedulaVieja = $_POST['cedulaTransportistaVieja'];

        // CREAMOS UN OBJETO DE TIPO TRANSPORTISTA PARA ALMACENAR LA INFORMACION DEL TRANSPORTISTA A MODIFICAR
        $transportista = new Transportista;

        if ($cedulaNueva != $cedulaVieja) // SI HAY DIFERENCIA ENTRE LA CEDULA NUEVA Y LA VIEJA
        {
            // VERIFICAMOS SI LA CEDULA NUEVA ESTÁ REPETIDA
            $cedulaRepetida = $manejadoEncargado->cedulaTransportistaRepetida($cedulaNueva);

            if ($cedulaRepetida) // SI ESA CEDULA YA EXISTE
            {
                // REDIRECCIONAMOS AL MODIFICADOR DE TRANSPORTISTA
                header("Location: ../vista/encargado/modificarTransportistaEncargado.php?cedulaTransportista=$cedulaVieja&mensaje=Esta cédula ya está registrada");
                die();
            }
            else // SI NO ESTÁ REPETIDA
            {
                // GUARDAMOS LA CEDULA NUEVA EN EL OBJETO TRANSPORTISTA
                $transportista->cedula = $cedulaNueva;
            }
        }
        else // SI NO HAY DIREFENCIA ENTRE LA CEDULA NUEVA Y LA VIEJA
        {
            // GUARDAMOS LA CEDULA VIEJA EN EL OBJETO TRANSPORTISTA
            $transportista->cedula = $cedulaNueva;
        }
        
        // TRAEMOS LA INFORMACION DEL TRANSPORTISTA QUE VAMOS A MODIFICAR (PORQUE NECESITAMOS AL DIRECCION DE LA FOTO VIEJA)
        $transportistaParaModificar = $manejadoEncargado->transportistaParaModificar($cedulaVieja);

        // SI SE INGRESÓ UNA FOTO NUEVA, HAY QUE ELIMNAR LA FOTO VIEJA DEL TRANSPORTISTA
        if ($_FILES['foto']['size'] > 0) // SI SE INGRESÓ UNA FOTO NUEVA
        {
            // GUARDAMOS LA FOTO NUEVA
            $pathFoto = $manejadoEncargado->verificarFotoDeTransportista($_FILES['foto']);

            if (is_array($pathFoto)) // SI LA FOTO NUEVA SE GUARDÓ BIEN
            {
                // GUARDAMOS EN EL OBJETO TRANSPORTISTA LA DIRECCION DE LA FOTO NUEVA
                $transportista->foto = $pathFoto['pathDeLaFoto'];

                // Y ELIMINAMOS LA FOTO VIEJA
                $manejadoEncargado->eliminarFoto($transportistaParaModificar->foto);
            }
            else // SI LA FOTO NUEVA NO SE PUDO GUARDAR
            {
                // REDIRECCIONAMOS AL MODIFICAR TRANSPORTISTA
                header("Location: ../vista/encargado/modificarTransportistaEncargado.php?cedulaTransportista=$cedulaVieja&mensaje=$pathFoto");
                die();
            }
        }
        else // SI NO SE INGRESÓ UNA FOTO NUEVA
        {
            // GUARDAMOS EN EL OBJETO TRANSPORTISTA LA DIRECCION DE LA FOTO VIEJA
            $transportista->foto = $transportistaParaModificar->foto;
        }
        
        $transportista->nombre = strtolower(trim($_POST['nombre']));
        $transportista->apellido = strtolower($_POST['apellido']);
        $transportista->telefono = str_replace(' ', '', $_POST['telefono']);
        $transportista->direccion = strtolower(trim($_POST['direccion']));
        $transportista->pin = md5($_POST['pin']);

        // MODIFICAMOS AL TRANSPORTISTA
        $manejadoEncargado->modificarTransportista($transportista, $cedulaVieja);
        
        // REDIERCCIONAMOS AL ADMINISTRADOR DE TRANSPORTISTAS
        header('Location: ../vista/encargado/administracionTransportistasEncargado.php');
    }
}
else // SI SE INTENTA INGRESAR A ESTA PAGINA DESDE LA URL
{
    // REDIRECCIONAMOS AL HOME DE ENCARGADO
    header("Location: ../vista/encargado/homeEncargado.php");
}

?>