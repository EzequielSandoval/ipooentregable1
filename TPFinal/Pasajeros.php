<?php
class Pasajeros
{

    private $nombre;
    private $apellido;
    private $dni;
    private $telefono;
    private $idViajeAsignado;
    private $mensajeOperacion;

    public function __construct()
    {
        $this->nombre = '';
        $this->apellido = '';
        $this->dni = '';
        $this->telefono = '';
        $this->idViajeAsignado = '';
        $this->mensajeOperacion = '';
    }

    public function cargar($nombrep, $apellidop, $dnip, $telefonop, $idViajep)
    {
        $this->set_nombre($nombrep);
        $this->set_apellido($apellidop);
        $this->set_dni($dnip);
        $this->set_telefono($telefonop);
        $this->set_idViaje($idViajep);
    }
    // Funciones de retorno

    public function get_nombre()
    {
        return $this->nombre;
    }
    public function get_apellido()
    {
        return $this->apellido;
    }
    public function get_dni()
    {
        return $this->dni;
    }

    public function get_telefono()
    {
        return $this->telefono;
    }
    public function get_idViajeAsignado()
    {
        return $this->idViajeAsignado;
    }
    // funciones de seteo de datos

    public function set_nombre($nombre)
    {
        $this->nombre = $nombre;
    }
    public function set_apellido($apellido)
    {
        $this->apellido = $apellido;
    }
    public function set_dni($dni)
    {
        $this->dni = $dni;
    }
    public function set_telefono($telefono)
    {
        $this->telefono = $telefono;
    }
    public function set_idViaje($idViaje)
    {
        $this->idViajeAsignado = $idViaje;
    }


    public function setmensajeoperacion($mensajeOperacion)
    {
        $this->mensajeOperacion = $mensajeOperacion;
    }
    public function getmensajeoperacion()
    {
        return $this->mensajeOperacion;
    }


    /**
     * Recupera los datos de un pasajero por medio del dni
     * @param int $dni
     * @return true en caso de encontrar los datos, false en caso contrario 
     */
    public function BuscarPasajero($dni)
    {
        $base = new BaseDatos();
        $consultaPasajero = "Select * from pasajero where pdocumento=" . $dni;
        $resp = false;
        if ($base->Iniciar()) {
            if ($base->Ejecutar($consultaPasajero)) {
                if ($row = $base->Registro()) {
                    $this->cargar($row['pnombre'], $row['papellido'], $dni, $row['ptelefono'], $row['idviaje']);
                    $resp = true;
                }
            } else {
                $this->setmensajeoperacion($base->getError());
            }
        } else {
            $this->setmensajeoperacion($base->getError());
        }
        return $resp;
    }




    public function insertarPasajero()
    {
        $base = new BaseDatos();
        $resp = false;

        $nombrePasajero = $this->get_nombre();
        $apellidoPasajero = $this->get_apellido();
        $dniPasajero = $this->get_dni();
        $telefonoPasajero = $this->get_telefono();
        $idViajePasajero = $this->get_idViajeAsignado();

        $consultaInsertarPasajero = "INSERT INTO pasajero (pdocumento, pnombre, papellido, ptelefono, idviaje) 
                                    VALUES ('$dniPasajero', '$nombrePasajero', '$apellidoPasajero', '$telefonoPasajero', '$idViajePasajero')";
        // si se inicia correctamente la base de datos
        if ($base->Iniciar()) {
            // pasa la consulta al metodo y se ejecuta, si se ejecuta exitosamente retorna true
            if ($base->Ejecutar($consultaInsertarPasajero)) {
                $resp = true;
            } else {
                // si falla la ejecucion de la consulta el error se almacena en el metodo setmensajeoperacion
                $this->setmensajeoperacion($base->getError());
            }
        } else {
            $this->setmensajeoperacion($base->getError());
        }
        return $resp;
    }

    public function listarPasajeros($condicion = "")
    {
        $arrayPasajero = null;
        $base = new BaseDatos();
        $consultaPasajero = "SELECT * FROM pasajero";
        if ($condicion != "") {
            $consultaPasajero = $consultaPasajero . ' WHERE ' . $condicion;
        }
        $consultaPasajero .= " order by pnombre";

        if ($base->Iniciar()) {
            if ($base->Ejecutar($consultaPasajero)) {
                $arrayPasajero = [];
                while ($row = $base->Registro()) {
                    $documento = $row['pdocumento'];
                    $nombre =  $row['pnombre'];
                    $apellido = $row['papellido'];
                    $telefono = $row['ptelefono'];
                    $viajeVinculado = $row['idviaje'];
                    $pasajero = new Pasajeros();
                    $pasajero->cargar($nombre, $apellido, $documento, $telefono, $viajeVinculado);
                    array_push($arrayPasajero, $pasajero);
                }
            } else {
                $this->setmensajeoperacion($base->getError());
            }
        } else {
            $this->setmensajeoperacion($base->getError());
        }
        return $arrayPasajero;
    }

    public function modificarPasajero()
    {
        $resp = false;
        $base = new BaseDatos();

        $documento = $this->get_dni();
        $nombre = $this->get_nombre();
        $apellido = $this->get_apellido();
        $telefono = $this->get_telefono();
        // $idViaje = $this->get_idViajeAsignado();

        $conusultaModificacionPasajero  = "UPDATE pasajero SET 
                                          pdocumento = '$documento',
                                          pnombre = '$nombre',
                                          papellido = '$apellido', 
                                          ptelefono = '$telefono'
                                        
                                          WHERE pdocumento='$documento'";
        if ($base->Iniciar()) {
            if ($base->Ejecutar($conusultaModificacionPasajero)) {
                $resp = true;
            } else {
                $this->setmensajeoperacion($base->getError());
            }
        } else {
            $this->setmensajeoperacion($base->getError());
        }
        return $resp;
    }


    public function eliminarPasajero()
    {
        $base = new BaseDatos();
        $resp = false;
        $dniPasajero = $this->get_dni();
        $consultaEliminarPasajero = "DELETE FROM pasajero WHERE pdocumento = '$dniPasajero'";
        if ($base->Iniciar()) {
            if ($base->Ejecutar($consultaEliminarPasajero)) {
                $resp = true;
            } else {
                $this->setmensajeoperacion($base->getError());
            }
        } else {
            $this->setmensajeoperacion($base->getError());
        }
        return $resp;
    }







    // Retorno de datos por pantalla
    public function __toString()
    {
        $datosPasajero =
            "NOMBRE: " . $this->get_nombre() . "\n" .
            "APELLIDO: " . $this->get_apellido()  . "\n" .
            "DNI: " . $this->get_dni() . "\n" .
            "TELEFONO: " . $this->get_telefono() . "\n" .
            "ID VIAJE ASIGNADO: " . $this->get_idViajeAsignado() . "\n";
        return $datosPasajero;
    }
}
