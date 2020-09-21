<?php

class ManejadorTransportista extends Conexion
{
    /* esta funcion retorna true si el transportista ingresado, es un transportista */
    public function autenticarTransportista($transportista) // CONTROLADOR LOGIN
    {
        // EXTRAEMOS LA CEDULA DEL TRANSPORTISTA
        $cedulaTransportista = $transportista->cedula;
        // EXTRAEMOS EL PIN DEL TRANSPORTISTA
        $pinTransportista = $transportista->pin;

        $sentencia = "SELECT * FROM transportista
                        WHERE cedula_transportista = '$cedulaTransportista'
                        AND pin = '$pinTransportista'
                        AND estado_transportista != 'dado de baja'";

        $this->conexionServidor();
        $this->conexionBaseDatos();
        $resultado = $this->ejecutarSentencia($sentencia);
        $this->cerrarConexion();

        $cantidadFilas = mysqli_num_rows($resultado);

        if ($cantidadFilas >= 1) // SI EL TRANSPORTISTA EXISTE
        {
            // RETORNAMOS TRUE
            return true;
        }
        else // SI NO EXISTE 
        {
            // RETORNAMOS FALSE
            return false;
        }
    }

    /* esta funcion retorna el nombre del transportista ingresado */
    public function nombreTransportista($transportista) // CONTROLADOR LOGIN
    {
        // EXTRAEMOS LA CEDULA DEL TRANSPORTISTA
        $cedulaTransportista = $transportista->cedula;

        $sentencia = "SELECT * FROM transportista
                        WHERE cedula_transportista = '$cedulaTransportista'";

        $this->conexionServidor();
        $this->conexionBaseDatos();
        $resultado = $this->ejecutarSentencia($sentencia);
        $this->cerrarConexion();

        // EXTRAEMOS LOS DATOS DEL RESULTADO
        $fila = mysqli_fetch_assoc($resultado);
        $nombreTransportista = $fila['nombre'];

        // RETORNAMOS EL NOMBRE DEL TRANSPORTISTA
        return $nombreTransportista;
    }

    /* esta funciona retorna (si es que hay) el paquete "en transito" del transportista ingresado */
    public function paqueteActivo($transportista) // VISTA HOME
    {
        // CREAMOS UN PAQUETE PARA ALMACENAR LA INFORMACION
        $paquete = new Paquete;
        
        // EXTRAEMOS LA CEDULA DEL TRANSPORTISTA INGRESADO
        $cedulaTransportista = $transportista->cedula;

        $sentencia = "SELECT * FROM paquete
                        WHERE estado_paquete = 'en transito' 
                        AND ci_transportista = '$cedulaTransportista'";
                
        $this->conexionServidor();
        $this->conexionBaseDatos();
        $resultado = $this->ejecutarSentencia($sentencia);
        $this->cerrarConexion();

        $cantidadFilas = mysqli_num_rows($resultado);

        if ($cantidadFilas >= 1) // SI HAY UN PAQUETE EN TRANSITO 
        {
            // EXTRAEMOS LA INFORACION DEL RESULTADO
            $fila = mysqli_fetch_assoc($resultado);

            $paquete->codigo = $fila["codigo"];
            $paquete->estadoPaquete = $fila["estado_paquete"];
            $paquete->fechaEstimadaEntrega = $fila["fecha_estimada_entrega"];
            $paquete->fragil = $fila["fragil"];
            $paquete->pedecedero = $fila["pedecedero"];
            $paquete->direccionRemitente = $fila["direccion_remitente"];
            $paquete->direccionEnvio = $fila["direccion_envio"];
            $paquete->fechaYHoraAsignacion = $fila["fecha_hora_asignacion"];

            // RETORNAMOS EL PAQUETE EN TRANSITO
            return $paquete;
        }
        else // SI NO HAY UN PAQUETE EN TRANSITO
        {
            // RETORNAMOS NULL
            return null;
        }
    }

    /* esta funcion finaliza la entrega de un paquete "en transito" por parte de un transportista */
    public function finalizarEntrega($transportista, $codigoPaquete) 
    {
        // EXTRAEMOS LA CEDULA DEL TRANSPORTISTA
        $cedulaTransportista = $transportista->cedula;

        // SETEAMOS EN EL SERVIDOR LA HORA DE MONTEVIDEO
        date_default_timezone_set('America/Montevideo');
        // FECHA DEL DIA DE HOY
        $fechaEntrega = date('Y-m-d');

        $sentenciaTablaPaquete = "UPDATE paquete 
                                  SET fecha_entrega = '$fechaEntrega', estado_paquete = 'entregado' 
                                  WHERE codigo = '$codigoPaquete'";

        $sentenciaTablaTransportista = "UPDATE transportista 
                                        SET estado_transportista = 'disponible' 
                                        WHERE cedula_transportista = '$cedulaTransportista'";

        $this->conexionServidor();
        $this->conexionBaseDatos();

        // CAMBIAMOS EL ESTADO DEL PAQUETE DE "EN TRANSITO" A "ENTREGADO"
        $this->ejecutarSentencia($sentenciaTablaPaquete);
        // CAMBIAMOS EL ESTADO DEL TRANSPORTISTA DE "NO DISPONIBLE" A "DISPONIBLE"
        $this->ejecutarSentencia($sentenciaTablaTransportista);
        $this->cerrarConexion();
    }

    /* esta funcion retorna un array con todos los paquetes "entregados" y "en transito" del transportista ingresado */
    public function historialTransportista($transportista)
    {
        // CEDULA DEL TRANSPORTISTA
        $cedulaTransportista = $transportista->cedula;

        $sentencia = "SELECT * FROM paquete
                      WHERE ci_transportista = '$cedulaTransportista'
                      ORDER BY estado_paquete";
    
        $this->conexionServidor();
        $this->conexionBaseDatos();
        $resultado = $this->ejecutarSentencia($sentencia);
        $this->cerrarConexion();

        $cantidadFilas = mysqli_num_rows($resultado); 

        if ($cantidadFilas >= 1) // SI TIENE MAS DE UN PAQUETE ASIGNADO A ESE TRANSPORTISTA
        {
            $historialPaquetes = array();

            // EXTRAEMOS DEL RESULTADO TODOS LOS PAQUETES
            for ($i = 0; $i < $cantidadFilas; $i++)
            {
                $paquete = new Paquete;

                $fila = mysqli_fetch_assoc($resultado);

                $paquete->codigo = $fila["codigo"];
                $paquete->fechaEstimadaEntrega = $fila["fecha_estimada_entrega"];
                $paquete->fechaEntrega = $fila["fecha_entrega"];
                $paquete->estadoPaquete = $fila["estado_paquete"];

                $historialPaquetes[] = $paquete;
            }

            // RETORNAMOS LOS PAQUETES
            return $historialPaquetes;
        }
        else // EL TRSNPORTISTA NO TIENE NIGUN PAQUETE ASIGNADO
        {
            // RETORNAMOS NULL
            return null;
        }
    }

    /* esta funcion retorna true si el transportista ingresado esta en estado "disponible" */
    public function estaDisponible($transportista)
    {
        // EXTRAEMOS LA CEDULA DEL TRANSPORTISTA
        $cedulaTransportista = $transportista->cedula;

        $sentencia = "SELECT * FROM transportista
                      WHERE cedula_transportista = '$cedulaTransportista'
                      AND estado_transportista = 'disponible'";

        $this->conexionServidor();
        $this->conexionBaseDatos();
        $resultado = $this->ejecutarSentencia($sentencia);
        $this->cerrarConexion();

        $cantidadFilas = mysqli_num_rows($resultado);
    
        if ($cantidadFilas >= 1) // SI ESTÁ DISPONIBLE
        {
            // RETORNAMOS TRUE
            return true;
        }
        else // SI NO ESTÁ DISPONIBLE 
        {
            // RETORNAMOS FALSE
            return false;
        }
    }

    /* esta funcion retorna un array con todos los paquetes sin asignar */
    public function paquetesSinAsignar()
    {
        $sentencia = "SELECT * FROM paquete
                      WHERE estado_paquete = 'sin asignar'";

        $this->conexionServidor();
        $this->conexionBaseDatos();
        $resultado = $this->ejecutarSentencia($sentencia);
        $this->cerrarConexion();

        $cantidadFilas = mysqli_num_rows($resultado);

        if ($cantidadFilas >= 1) // SI HAY MAS DE UN PAQUETE SIN ASIGNAR
        {
            // CREAMOS UN ARRAY PARA GUARDAR TODOS LOS PAQUETES "SIN ASIGAR"
            $paquetesSinAsignar = array();

            for ($i = 0; $i < $cantidadFilas; $i++)
            {
                $paquete = new Paquete();

                $fila = mysqli_fetch_assoc($resultado);

                $paquete->codigo = $fila["codigo"];
                $paquete->fragil = $fila["fragil"];
                $paquete->pedecedero = $fila["pedecedero"];
                $paquete->direccionRemitente = $fila["direccion_remitente"];
                $paquete->direccionEnvio = $fila["direccion_envio"];

                $paquetesSinAsignar[] = $paquete;
            }

            // RETORNAMOS EL ARRAY CON LOS PAQUETES
            return $paquetesSinAsignar;
        }
        else // SI NO HAY PAQUETES "SIN ASIGNAR"
        {
            // RETORNAMOS NULL
            return null;
        } 
    }

    /* esta funcion retorna un paquete con su informacion, segun el codigo de paquete ingresado */
    public function paqueteParaAsignar($codigoPaquete)
    {
        $sentencia = "SELECT * FROM paquete
                      WHERE codigo = '$codigoPaquete'";

        $this->conexionServidor();
        $this->conexionBaseDatos();
        $resultado = $this->ejecutarSentencia($sentencia);
        $this->cerrarConexion();

        // EXTRAEMOS LA INFORMACION DEL PAQUETE
        $fila = mysqli_fetch_assoc($resultado);

        // CREAMOS UN PAQUETE PARA ALMACENAR LA INFORMACION
        $paquete = new Paquete;

        $paquete->codigo = $fila['codigo'];
        $paquete->direccionRemitente = $fila['direccion_remitente'];
        $paquete->direccionEnvio = $fila['direccion_envio'];
        $paquete->fragil = $fila['fragil'];
        $paquete->pedecedero = $fila['pedecedero'];

        // RETORNAMOS EL PAQUETE CON LA INFORMACION
        return $paquete;
    }

    /* esta funcion asigna un paquete (ingresado) a un transportista (ingresado). Este paquete va a tener una fecha 
    estimada de entrega (ingresada) */
    public function asignarPaquete($transportista, $codigoPaquete, $fechaEstimadaEntrega)
    {
        // EXTRAEMOS LA CEDULA DEL TRANSPORTISTA
        $cedulaTransportista = $transportista->cedula;

        // LE PONEMOS LA HORA DE MONTEVIDEO AL SERVIDOR
        date_default_timezone_set('America/Montevideo');
        // FECHA Y HORA ACTUAL. ESTO SE VA A UTILIZAR PARA EL CAMPO FECHA Y HORA DE LA ASIGNACION DE LA BASE
        $fechaHoraAsignacion = date('Y-m-d H:i:s');

        $sentenciaTablaPaquete = "UPDATE paquete 
                                  SET fecha_estimada_entrega = '$fechaEstimadaEntrega', estado_paquete = 'en transito', fecha_hora_asignacion = '$fechaHoraAsignacion', ci_transportista = '$cedulaTransportista' 
                                  WHERE codigo = '$codigoPaquete'";

        $sentenciaTablaTransportista = "UPDATE transportista 
                                        SET estado_transportista = 'no disponible' 
                                        WHERE cedula_transportista = '$cedulaTransportista'";

        $this->conexionServidor();
        $this->conexionBaseDatos();

        // MOFICAMOS EL ESTADO DEL PAQUETE DE "SIN ASIGNAR" A "EN TRANSITO", LE AGREGAMOS UNA FECHA ESTIMADA DE ENTREGA,
        // FECHA Y HORA DE ASIGNACION Y LA CEDULA DEL TRANSPORTISTA QUE SE LE ASIGNÓ EL PAQUETE
        $this->ejecutarSentencia($sentenciaTablaPaquete);
        // MODIFICAMOS EL ESTADO DEL TRANSPORTISTA DE "DISPONIBLE" A "NO DISPONIBLE" 
        $this->ejecutarSentencia($sentenciaTablaTransportista);

        $this->cerrarConexion();
    }
}

?>