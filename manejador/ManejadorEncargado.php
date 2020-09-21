<?php

class ManejadorEncargado extends Conexion
{
    /* esta funcion retorna true si el encargado ingresado, es un encargado */
    public function autenticarEncargado($encargado)
    {
        // EXTRAEMOS LA CEDULA DE ENCARGADO
        $cedulaEncargado = $encargado->cedula;
        // EXTRAEMOS EL PIN DE ENCARGADO
        $pinEncargado = $encargado->pin;

        $sentencia = "SELECT * FROM encargado
                      WHERE cedula_encargado = '$cedulaEncargado'
                      AND pin = '$pinEncargado'";

        $this->conexionServidor();
        $this->conexionBaseDatos();
        $resultado = $this->ejecutarSentencia($sentencia);
        $this->cerrarConexion();

        $cantidadFilas = mysqli_num_rows($resultado);

        if ($cantidadFilas >= 1) // SI EXISTE EL ENCARGADO
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

    /* esta funcion retorna el nombre del encargado ingresado */
    public function nombreEncargado($encargado)
    {
        // EXTRAEMOS LA CEDULA DEL ENCARGADO
        $cedulaEncargado = $encargado->cedula;

        $sentencia = "SELECT * FROM encargado
                      WHERE cedula_encargado = '$cedulaEncargado'";

        $this->conexionServidor();
        $this->conexionBaseDatos();
        $resultado = $this->ejecutarSentencia($sentencia);
        $this->cerrarConexion();

        // EXTRAEMOS EL NOMBRE DEL ENCARGADO DEL RESULTADO
        $fila = mysqli_fetch_assoc($resultado);
        $nombreEncargado = $fila['nombre'];

        // RETORNAMOS EL NOMBRE DEL ENCARGADO
        return $nombreEncargado;
    }

    /* esta funcion retorna un array con los paquetes "en transito" con su transportista */
    public function paquetesEnTransito()
    {
        $sentencia = "SELECT * FROM paquete
                      JOIN transportista
                      ON ci_transportista = cedula_transportista
                      WHERE estado_paquete = 'en transito'
                      ORDER BY fecha_entrega";

        $this->conexionServidor();
        $this->conexionBaseDatos();
        $resultado = $this->ejecutarSentencia($sentencia);
        $this->cerrarConexion();

        $cantidadFilas = mysqli_num_rows($resultado);

        if ($cantidadFilas >= 1) // SI HAY MAS DE UN PAQUETE "EN TRANSITO"
        {
            // CREAMOS UN ARRAY PARA GUARDAR LOS PAQUETES "EN TRANSITO" Y SU TRANSPORTISTA
            $transportesActivos = array();

            // EXTRAEMOS LOS PAQUETES "EN TRANSITO" CON SU TRANSPORTISTA DEL RESULTADO, Y LOS AGREGAOS AL ARRAY
            for ($i = 0; $i < $cantidadFilas; $i++)
            {
                $paquete = new Paquete;
                $transportista = new Transportista;

                $fila = mysqli_fetch_assoc($resultado);

                $paquete->codigo = $fila['codigo'];
                $paquete->fechaYHoraAsignacion = $fila['fecha_hora_asignacion'];

                $transportista->cedula = $fila['cedula_transportista'];
                $transportista->nombre = $fila['nombre'];

                $transporte = array($paquete, $transportista);

                $transportesActivos[] = $transporte;
            }

            // RETORNAMOS EL ARRAY CON LOS PAQUETE Y SUS TRANSPORTISTAS
            return $transportesActivos;
        }
        else // SI NO HAY PAQUETES EN TRANSITO
        {
            // RETORNAMOS NULL
            return null;
        }
    }

    /* esta funcion retorna los paquetes "sin asignar", "en transito" y "entregados", cada uno en un array y estos tres 
    array dentro de otro array */
    public function todosLosPaquetes()
    {
        // ARRAY PARA GUARDAR LOS PAQUTES "SIN ASIGNAR"
        $paquetesSinAsignar = array();  
        // ARRAY PARA GUARDAR LOS PAQUTES "EN TRANITO"
        $paquetesEnTransito = array();
        // ARRAY PARA GUARDAR LOS PAQUTES "ENTREGADOS"
        $paquetesEntregados = array();

        $sentencia = "SELECT * FROM paquete
                      WHERE estado_paquete != 'eliminado' 
                      ORDER BY fecha_entrega desc, 
                      fecha_estimada_entrega desc ";

        $this->conexionServidor();
        $this->conexionBaseDatos();
        $resultado = $this->ejecutarSentencia($sentencia);
        $this->cerrarConexion();

        $cantidadFilas = mysqli_num_rows($resultado);

        if ($cantidadFilas >= 1) // SI EXISTE UN PAQUETE O MAS
        {
            // EXTRAEMOS LA INFORMACION DEL RESULTADO, Y AGREGAMOS LOS PAQUETES A CADA UNO DE LOS ARRAY SEGUN SU ESTADO
            for ($i = 0; $i < $cantidadFilas; $i++)
            {
                $paquete = new Paquete;

                $fila = mysqli_fetch_assoc($resultado);

                $paquete->codigo = $fila["codigo"];
                $paquete->estadoPaquete = $fila["estado_paquete"];
                $paquete->fechaEstimadaEntrega = $fila["fecha_estimada_entrega"];
                $paquete->fragil = $fila["fragil"];
                $paquete->pedecedero = $fila["pedecedero"];
                $paquete->direccionRemitente = $fila["direccion_remitente"];
                $paquete->direccionEnvio = $fila["direccion_envio"];
                $paquete->fechaYHoraAsignacion = $fila["fecha_hora_asignacion"];
                $paquete->fechaEntrega = $fila["fecha_entrega"];

                switch ($paquete->estadoPaquete) 
                {
                    case "sin asignar": // PAQUETE "SIN ASIGNAR"
                        $paquetesSinAsignar[] = $paquete;
                        break;
                    case "en transito": // PAQUETE "EN TRANSITO"
                        $paquetesEnTransito[] = $paquete;
                        break;
                    case "entregado": // PAQUETE "ENTREGADO"
                        $paquetesEntregados[] = $paquete;
                        break;
                    default;
                        die("No tiene estado o es incorrecto: ManejadorPaquete.php - todosLosPaquetes() - switch - Avise a su superior de este error");
                    break;
                }
            }

            $paquetes = array(
                "paquetesSinAsignar" => $paquetesSinAsignar, 
                "paquetesEnTransito" => $paquetesEnTransito,
                "paquetesEntregados" => $paquetesEntregados
            );

            // RETORNAMOS TODOS LOS PAQUETES
            return $paquetes;
        }
        else // SI NO EXISTE NINGUN PAQUETE
        {
            // RETORNAMOS NULL
            return null;
        }
    }

    /* esta funcion cambia el estado de un paquete a "eliminado" */
    public function eliminarPaquete($codigoPaquete)
    {
        $sentencia = "UPDATE paquete 
                      SET estado_paquete = 'eliminado' 
                      WHERE codigo = '$codigoPaquete'";

        $this->conexionServidor();
        $this->conexionBaseDatos();
        $this->ejecutarSentencia($sentencia);
        $this->cerrarConexion();
    }

    /* esta funcion retorna un paquete con informacion según el código del paquete ingresado */
    public function paqueteParaModificar($codigoPaquete)
    {
        $sentencia = "SELECT * FROM paquete
                      WHERE codigo = '$codigoPaquete'";

        $this->conexionServidor();
        $this->conexionBaseDatos();
        $resultado = $this->ejecutarSentencia($sentencia);
        $this->cerrarConexion();

        // EXTRAEMOS LA INFORMACION DEL PAQUETE DEL RESULTADO
        $fila = mysqli_fetch_assoc($resultado);

        $paquete = new Paquete;

        $paquete->codigo = $fila['codigo'];
        $paquete->direccionRemitente = $fila['direccion_remitente'];
        $paquete->direccionEnvio = $fila['direccion_envio'];
        $paquete->fragil = $fila['fragil'];
        $paquete->pedecedero = $fila['pedecedero'];

        // RETORNAMOS EL PAQUETE CON LA INFORMACION
        return $paquete;
    }

    /* esta funcion modifica un paquete de la base */
    public function modificarPaquete($paquete)
    {
        // EXTRAEMOS LA INFORMACION DEL PAQUETE
        $codigoPaquete = $paquete->codigo;
        $direccionRemitente = $paquete->direccionRemitente;
        $direccionEnvio = $paquete->direccionEnvio;
        $fragil = $paquete->fragil;
        $pedecedero = $paquete->pedecedero;
        
        $sentencia = "UPDATE paquete 
                      SET direccion_remitente = '$direccionRemitente', 
                      direccion_envio = '$direccionEnvio', 
                      fragil = '$fragil', 
                      pedecedero = '$pedecedero'
                      WHERE codigo = '$codigoPaquete'";

        $this->conexionServidor();
        $this->conexionBaseDatos();
        // MODIFICAMOS EL PAQUETE
        $this->ejecutarSentencia($sentencia);
        $this->cerrarConexion();
    }

    /* esta funcion retorna un codigo unico de 16 digitos alfanumericos. Esta funcion se va a utilizar en la funcion 
    crearPaquete() */
    public function crearCodigoPaquete() // (funcion privada)
    {
        do {
            $codigoRepetido = false;
            $codigoPaquete = "";
            $valoresAlfabeticos = ["a", "b", "c", "d", "e", "f", "g", "h", "i", "j", "k", "l", "m", "n", "o", "p", 
                                "q", "r", "s", "t", "u", "v", "w", "x", "y", "z"];
            $valoresNumericos = ["0", "1", "2", "3", "4", "5", "6", "7", "8", "9"];

            // CREAMOS EL CODIGO DEL PAQUETE
            for ($i = 0; $i < 8; $i++)
            {
                $letraRandom = random_int(0, 25);
                $numeroRandom = random_int(0, 9);
                $codigoPaquete .= $valoresAlfabeticos[$letraRandom];
                $codigoPaquete .= $valoresNumericos[$numeroRandom];
            }    

            $sentencia = "SELECT codigo 
                          FROM paquete 
                          WHERE codigo = '$codigoPaquete'";

            $this->conexionServidor();
            $this->conexionBaseDatos();
            // BUSCAMOS SI YA HAY UN CODIGO IGUAL AL CREADO
            $resultado = $this->ejecutarSentencia($sentencia);
            $this->cerrarConexion();

            // VERIFICAMOS QUE EL CODIGO SEA UNICO
            if (mysqli_num_rows($resultado) >= 1) // SI NO LO ES
            {
                // REPETIMOS EL PROCEDIMIENTO
                $codigoRepetido = true;
            }

        } while ($codigoRepetido);

        // RETORNAOS EL CODIGO DEL PAQUETE
        return $codigoPaquete;
    }

    /* esta funcion agrega un paquete a la base de datos */
    public function crearPaquete($paquete)
    {
        // CREAMOS UN CODIGO UNICO PARA EL PAQUETE
        $codigo = $this->crearCodigoPaquete();
        // EXTRAEMOS LA INFORMACION DEL PAQUETE INGRESADO
        $direccionRemitente = $paquete->direccionRemitente;
        $direccionEnvio = $paquete->direccionEnvio;
        $fragil = $paquete->fragil;
        $pedecedero = $paquete->pedecedero;

        $sentencia = "INSERT INTO paquete (codigo, direccion_remitente, direccion_envio, fragil, pedecedero, 
                                           estado_paquete) 
                      VALUES ('$codigo', '$direccionRemitente', '$direccionEnvio', '$fragil', '$pedecedero', 
                              'sin asignar')";

        $this->conexionServidor();
        $this->conexionBaseDatos();
        // AGREGAMOS EL PAQUETE A LA BASE DE DATOS
        $this->ejecutarSentencia($sentencia);
        $this->cerrarConexion();
    }

    /* esta funcion retorna dos array: uno con los transportistas en estado "disponible" y otro con los "no disponible" 
    y estos dos array van dentro de otro array */
    public function todosLosTransportistas()
    {
        $sentencia = "SELECT * FROM transportista
                      WHERE estado_transportista != 'dado de baja'";

        $this->conexionServidor();
        $this->conexionBaseDatos();
        $resultado = $this->ejecutarSentencia($sentencia);
        $this->cerrarConexion();

        $cantidadFilas = mysqli_num_rows($resultado);

        if ($cantidadFilas >= 1) // SI HAY UNO O MAS TRANSPORTISTAS
        {
            // CREAMOS UN ARRAY PARA ALMACENAR A LOS TRANSPORTISTAS "DISPONIBLES"
            $transportistasDisponibles = array();
            // CREAMOS UN ARRAY PARA ALMACENAR A LOS TRANSPORTISTAS "NO DISPONIBLES"
            $transportistasNoDisponibles = array();

            // EXTRAEMOS A LOS TRANSPORTISTAS DEL RESULTADO
            for ($i = 0; $i < $cantidadFilas; $i++)
            {
                $transportista = new Transportista;

                $fila = mysqli_fetch_assoc($resultado);

                $transportista->cedula = $fila["cedula_transportista"];
                $transportista->nombre = $fila["nombre"];
                $transportista->apellido = $fila["apellido"];
                $transportista->foto = $fila["foto"];
                $transportista->direccion = $fila["direccion"];
                $transportista->telefono = $fila["telefono"];
                $transportista->estadoTransportista = $fila["estado_transportista"];

                switch ($transportista->estadoTransportista) 
                {
                    case "disponible":
                        $transportistasDisponibles[] = $transportista;
                        break;
                    case "no disponible":
                        $transportistasNoDisponibles[] = $transportista;
                        break;
                    default;
                        die("No tiene estado o es incorrecto: ManejadorTransportista.php - listarTransportistas() 
                            - switch");
                    break;
                }
            }

            $transportistas = array(
                "transportistasDisponibles" => $transportistasDisponibles, 
                "transportistasNoDisponibles" => $transportistasNoDisponibles
            );
            
            // RETORAMOS A LOS TRANSPORTISTAS
            return $transportistas;
        }
        else
        {
            return null;
        }
    }

    /* esta funcion retorna true si la cedula del transportista ingresado entá en estado "disponible". Esta funcion se
    va a utilizar en la funcion eliminarTransportista() */
    private function estaDisponible($cedulaTransportista) // (funcion privada)
    {
        $sentencia = "SELECT * FROM transportista
                      WHERE cedula_transportista = '$cedulaTransportista'
                      AND estado_transportista = 'disponible'";

        $this->conexionServidor();
        $this->conexionBaseDatos();
        $resultado = $this->ejecutarSentencia($sentencia);
        $this->cerrarConexion();

        $cantidadFilas = mysqli_fetch_assoc($resultado);

        if ($cantidadFilas >= 1) // SI EL TRANSPORTISTA ESTA DISPONIBLE
        {
            // RETORNAMOS TRUE
            return true;
        }
        else // SI EL NO TRANSPORTISTA ESTA DISPONIBLE
        {
            // RETORNAMOS FALSE
            return false;
        }
    }

    /* esta funcion desasigna a un paquete de un transportista. Esta funcion se va a utilizar en la funcion 
    eliminarTransportista() */
    private function desasignarPaquete($cedulaTransportista) // (funcion privada)
    {
        $sentencia = "UPDATE paquete SET fecha_estimada_entrega = NULL, estado_paquete = 'sin asignar', 
                             fecha_hora_asignacion = NULL, ci_transportista = NULL
                      WHERE ci_transportista = '$cedulaTransportista'
                      AND estado_paquete = 'en transito'";

        $this->conexionServidor();
        $this->conexionBaseDatos();
        // DESASIGANMSO UN PAQUETE DE UN TRANSPORTISTA
        $this->ejecutarSentencia($sentencia);
        $this->cerrarConexion();
    }

    /* segun la cedula ingresada, esta funcion da de baja a un transportista. Y si tiene un paquete asignado, se 
    le desasigna el paquete */
    public function eliminarTransportista($cedulaTransportista)
    {
        // VERIFICAMOS SI EL TRANSPORTISTA TIENE UN PAQUETE ASIGNADO
        $estaDisponible = $this->estaDisponible($cedulaTransportista);

        if (!$estaDisponible) // SI TIENEN UN PAQUETE ASIGNADO
        {
            // LE DESASIGNAMOS EL PAQUETE
            $this->desasignarPaquete($cedulaTransportista);
        }

        $sentencia = "UPDATE transportista 
                      SET estado_transportista = 'dado de baja' 
                      WHERE cedula_transportista = '$cedulaTransportista'";

        $this->conexionServidor();
        $this->conexionBaseDatos();
        // MODIFICAMOS EL ESTADO DEL TRANSPORTISTA A "DADO DE BAJA"
        $this->ejecutarSentencia($sentencia);
        $this->cerrarConexion();
    }

    /* esta funcion retorna un transportista segun la cedula ingresada */
    public function transportistaParaModificar($cedulaTransportista)
    {
        $sentencia = "SELECT * FROM transportista
                      WHERE cedula_transportista = '$cedulaTransportista'";

        $this->conexionServidor();
        $this->conexionBaseDatos();
        $resultado = $this->ejecutarSentencia($sentencia);
        $this->cerrarConexion();

        // EXTRAEMOS LOS DATOS DEL RESULTADO
        $fila = mysqli_fetch_assoc($resultado);

        // CREAMOS UN TRANSPORTISTA PARA ALMACENAR LA INFORMCION
        $transportista = new Transportista;

        $transportista->cedula = $fila['cedula_transportista'];
        $transportista->nombre = $fila['nombre'];
        $transportista->apellido = $fila['apellido'];
        $transportista->direccion = $fila['direccion'];
        $transportista->telefono = $fila['telefono'];
        $transportista->foto = $fila['foto'];

        // RETORNAMOS LA INFORMACION DEL TRANSPORTISTA
        return $transportista;
    }

    /* esta funcion modifica los datos de un transportista ingresado*/
    public function modificarTransportista($transportista, $cedulaVieja)
    {
        // EXTREMOS LA INFORMACION DEL TRANSPORTISTA INGRESADO 
        $cedula = $transportista->cedula;
        $nombre = $transportista->nombre;
        $apellido = $transportista->apellido;
        $direccion = $transportista->direccion;
        $telefono = $transportista->telefono;
        $foto = $transportista->foto;
        $pin = $transportista->pin;
        
        $sentencia = "UPDATE transportista 
                      SET cedula_transportista = '$cedula', pin = '$pin', nombre = '$nombre', apellido = '$apellido', 
                          direccion = '$direccion', telefono = '$telefono', foto = '$foto' 
                      WHERE cedula_transportista = '$cedulaVieja'";

        $this->conexionServidor();
        $this->conexionBaseDatos();
        // MODIFICAMOS AL TRANSPORTISTA
        $this->ejecutarSentencia($sentencia);
        $this->cerrarConexion();
    }

    /* esta funcion retorna true si la cedula ingresada del transportista ya existe */
    public function cedulaTransportistaRepetida($cedulaTransportista)
    {
        $sentencia = "SELECT * FROM transportista
                      WHERE cedula_transportista = '$cedulaTransportista'";

        $this->conexionServidor();
        $this->conexionBaseDatos();
        $resultado = $this->ejecutarSentencia($sentencia);
        $this->cerrarConexion();

        $cantidadFilas = mysqli_num_rows($resultado);

        if ($cantidadFilas >= 1) // SI LA CEDULA INGRESADA SE ENCENTRA EN LA BASE
        {
            // RETORNAMOS TRUE
            return true;
        }
        else // SI LA CEDULA INGRESADA NO SE ENCENTRA EN LA BASE
        {
            // RETORNAMOS TRUE
            return false;
        }
    }

    /* esta funcion retorna un array con el path de la foto. Y si hay un error retorna un string con el error  */
    public function verificarFotoDeTransportista($foto)
    {
        // NOMBRE DEL ARCHIVO
        $nombreOriginalDelArchivo = $_FILES["foto"]["name"];

        // NOMBRE DEL ARCHIVO SIN LA EXTENCION
        $nombreOriginalDelArchivoSinLaExtension = pathinfo($nombreOriginalDelArchivo, PATHINFO_FILENAME);

        // RUTA TEMPORAL DEL ARCHIVO
        $rutaTemporalDelArchivo = $_FILES["foto"]["tmp_name"];

        // RUTA DONDE VAMOS A GUARDAR LA FOTO
        $rutaDeGuarado = "../fotoTransportista/";
        
        // EXTENCION DEL ARCHIVO
        $extencionDelArchivoSinPunto = pathinfo($nombreOriginalDelArchivo, PATHINFO_EXTENSION);

        // TAMAÑO DEL LA FOTO
        $tamañoDelArchivo = $_FILES["foto"]["size"];

        $pathFoto = $rutaDeGuarado . $nombreOriginalDelArchivo;

        // VERIFICAMOS QUE EL ARCHIVO SE SUBA A LA UBICACION TEMPORAL
        if(is_uploaded_file($rutaTemporalDelArchivo))
        {
            // VERIFICAMOS QUE EL TAMAÑO DEL ARCHIVO NO SUPERE EL TAMAÑO MAXIMO (1MB)
            if ($tamañoDelArchivo < 1048576) 
            {
                // VERIFICAMOS QUE LA IMAGEN SEA UNA IMAGEN REAL
                $chequear = getimagesize($rutaTemporalDelArchivo);
                if($chequear !== false) 
                {
                    // VERIFICAMOS QUE EL TIPO DE ARCHIVO SUBIDO SEA CORRECTO
                    if($extencionDelArchivoSinPunto == "jpg" or $extencionDelArchivoSinPunto == "png" or $extencionDelArchivoSinPunto == "jpeg") 
                    {
                        // BUSCAMOS SI EN LA CARPETA DE GUARDADO YA EXISTE UNA FOTO CON ESE NOMBRE
                        // Y SI LA HAY MODIFICAMOS EL NOMBRE
                        while(is_file($pathFoto))
                        {
                            $aleatorio = rand(0, 9);

                            $nombreOriginalDelArchivoSinLaExtension .= $aleatorio;

                            $nombreOriginalDelArchivoNuevo = $nombreOriginalDelArchivoSinLaExtension . "." . $extencionDelArchivoSinPunto;

                            $pathFoto = $rutaDeGuarado . $nombreOriginalDelArchivoNuevo;
                        }

                        // PASAMOS EL ARCHIVO DE LA RUTA TEMPORAL A LA PERMANENTE
                        if(move_uploaded_file($rutaTemporalDelArchivo, $pathFoto))
                        {
                            // GUARDAMOS LA RUTA DE LA FOTO EN UN ARRAY ASOCIATIVO
                            $datos = array('pathDeLaFoto' => "../$pathFoto");
                            // RETORNAMOS EL ARRAY CON LA RUTA DE LA FOTO
                            return $datos;
                        }
                        else
                        {
                            return "No se pudo guardar el archivo, avise de este error a su superior";
                        }
                    }
                    else
                    {
                        return "El archivo subido no tiene la extención '*.jpg' , '*.png' o '*.jpeg'";
                    }   
                }
                else 
                {
                    return "El archivo ingresado no es una imagen real";
                }
            }
            else
            {
                return "La foto no puede pesar mas de 1MB";
            }
        }
        else
        {
            return "Error en la subida del archivo";
        }
    }

    /* esta funcion elimina un archivo en un path determinado */
    public function eliminarFoto($pathFoto)
    {
        // EXTRAEMOS DE LA RUTA DE LA FOTO LOS TRES PRIMERO CARACTERES (../)
        $pathFoto = substr($pathFoto, 3);

        try
        {
            // BORRAMOS LA FOTO
            unlink($pathFoto);
        }
        catch(Exception $e)
        {
            echo "Hubo un error al borrar la foto";
        }
    }

    /* esta funcion recibe un transportista y lo agrega a la base de datos */
    public function registrarTransportista($transportista)
    {
        // EXTRAEMOS LOS DATOS DELTRANSPORTISTA
        $cedula = $transportista->cedula;
        $nombre = $transportista->nombre;
        $apellido = $transportista->apellido;
        $pin = $transportista->pin;
        $foto = $transportista->foto;
        $direccion = $transportista->direccion;
        $telefono = $transportista->telefono;

        $sentencia = "INSERT INTO transportista (cedula_transportista, nombre, apellido, direccion, telefono, pin, 
                                                 foto, estado_transportista) 
                      VALUES ('$cedula', '$nombre', '$apellido', '$direccion', '$telefono', '$pin', 
                              '$foto', 'disponible')";

        $this->conexionServidor();
        $this->conexionBaseDatos();
        // AGREGAMOS EL TRANPORTISTA A LA BASE
        $this->ejecutarSentencia($sentencia);
        $this->cerrarConexion();
    }

    /* esta funcion retorna todos los paquetes */
    public function historialPaquetes()
    {
        // CREAMOS UN ARRAY PARA LOS PAQUETES "SIN ASIGNAR"
        $paquetesSinAsignar = array();
        // CREAMOS UN ARRAY PARA LOS PAQUETES "EN TRANSITO"
        $paquetesEnTransito = array();
        // CREAMOS UN ARRAY PARA LOS PAQUETES "ENTREGADO"
        $paquetesEntregados = array();

        $sentencia = "SELECT * FROM paquete 
                        WHERE estado_paquete != 'eliminado' 
                        ORDER BY fecha_entrega desc, 
                        fecha_estimada_entrega desc ";

        $this->conexionServidor();
        $this->conexionBaseDatos();
        $resultado = $this->ejecutarSentencia($sentencia);
        $this->cerrarConexion();

        $cantidadFilas = mysqli_num_rows($resultado);

        if ($cantidadFilas >= 1) // SI HAY MAS DE UN PAQUETE
        {
            // EXTRAEMOS LOS PAQUETES DEL RESULTADO
            for ($i = 0; $i < $cantidadFilas; $i++) 
            {
                $paquete = new Paquete;

                $fila = mysqli_fetch_assoc($resultado);

                $paquete->codigo = $fila["codigo"];
                $paquete->estadoPaquete = $fila["estado_paquete"];
                $paquete->fechaEstimadaEntrega = $fila["fecha_estimada_entrega"];
                $paquete->fragil = $fila["fragil"];
                $paquete->pedecedero = $fila["pedecedero"];
                $paquete->direccionRemitente = $fila["direccion_remitente"];
                $paquete->direccionEnvio = $fila["direccion_envio"];
                $paquete->fechaYHoraAsignacion = $fila["fecha_hora_asignacion"];
                $paquete->fechaEntrega = $fila["fecha_entrega"];

                switch ($paquete->estadoPaquete) 
                {
                    case "sin asignar":
                        $paquetesSinAsignar[] = $paquete;
                        break;
                    case "en transito":
                        $paquetesEnTransito[] = $paquete;
                        break;
                    case "entregado":
                        $paquetesEntregados[] = $paquete;
                        break;
                    default;
                        die("No tiene estado o es incorrecto: ManejadorPaquete.php - todosLosPaquetes() - switch");
                    break;
                }
            }

            $paquetes = array(
                "paquetesSinAsignar" => $paquetesSinAsignar, 
                "paquetesEnTransito" => $paquetesEnTransito,
                "paquetesEntregados" => $paquetesEntregados
            );
            
            // RETORNAMOS LOS PAQUETES
            return $paquetes;
        }
        else // SI NO HAY PAQUETES
        {
            // RETORNAMOS NULL
            return null;
        }
    }
}

?>