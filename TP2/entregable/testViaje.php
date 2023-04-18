<?php
include_once 'Viaje.php';
include_once 'Pasajeros.php';
include_once 'ResponsableV.php';

// string $codigo, $destino, $nuevoCodigo, $nuevoDestino, $nuevaCantidad, $nuevoNombre, $nuevoDni, $nuevoApellido, $numLicencia, $nombreResponsable, $apellidoResponsable
// int $cantidadPasajeros, $dniPasajero, $opcion, $opcionModificacion, $opcionModificacionPersona, $numEmpleado
// array $coleccionPersonas 

$codigo = "";
$destino = "";
$cantidadPasajeros = 0;
$coleccionPersonas = [];
$opcion = 0;
$opcionModificacion = 0;
$nuevoCodigo = "";
$nuevoNombre = "";
$nuevoApellido = "";
$nuevoDni = "";
$datosPasajeroActual = [];
$nuevosPasajeros = [];

$arrayPersonas = [];
$numEmpleado = 0;
$numLicencia = "";
$nombreResponsable = "";
$apellidoResponsable = "";
/**
 * solicita datos de pasajeros para una determinada cantidad
 * y carga los datos en el array
 * @param int $cantPasajeros
 * @param array $arrayPersonas
 */
function solicitarDatosPasajero($cantPasajeros, $coleccionObjetosPersonas)
{
    // int $contCant
    // string $nombrePasajero, $apellidoPasajero, $dniPasajero
    // bool $dniRepetido
    $nombrePasajero = "";
    $apellidoPasajero = "";
    $telefonoPasajero = "";
    $dniPasajero = 0;
    $contCant = 1;

    // $arrayPersonas = [];
    do {
        echo "Nombre: ";
        $nombrePasajero = trim(fgets(STDIN));
        echo "Apellido: ";
        $apellidoPasajero = trim(fgets(STDIN));
        echo "DNI: ";
        $dniPasajero = trim(fgets(STDIN));
        echo "TELEFONO: ";
        $telefonoPasajero = trim(fgets(STDIN));
        $dniRepetido = false; // bandera
        $i = 0;
        while ($i < count($coleccionObjetosPersonas) && !$dniRepetido) {
            if ($dniPasajero == $coleccionObjetosPersonas[$i]->get_dni()) {
                echo "Este pasajero con este dni ya esta cargado\n";
                $dniRepetido = true; // bandera
            }
            $i++;
        }

        if (!$dniRepetido) {
            array_push($coleccionObjetosPersonas, new Pasajeros($nombrePasajero, $apellidoPasajero, $dniPasajero, $telefonoPasajero));
            $contCant++;
        }
    } while ($contCant <= $cantPasajeros);
    return $coleccionObjetosPersonas;
}
/**
 * Seleccionar una opcion
 * retorna el numero de opcion
 * @return int
 */
function seleccionarOpcion()
{
    echo "SELECCIONAR UNA OPCION:\n";
    echo "[1] Modificar informacion del viaje: \n";
    echo "[2] Modificar datos de una persona: \n";
    echo "[3] Ver datos del viaje: \n";
    echo "[4] Salir\n";
    $opcionElegida = trim(fgets(STDIN));
    return $opcionElegida;
}




echo "Ingresar el codigo del viaje: ";
$codigo = trim(fgets(STDIN));
echo "Ingresar el destino del viaje: ";
$destino = trim(fgets(STDIN));
echo "--------------------------------------\n";
echo "Numero Empleado: ";
$numEmpleado = trim(fgets(STDIN));
echo "Numero Licencia: ";
$numLicencia = trim(fgets(STDIN));
echo "Nombre: ";
$nombreResponsable = trim(fgets(STDIN));
echo "Apellido: ";
$apellidoResponsable = trim(fgets(STDIN));
echo "--------------------------------------\n";
echo "Ingresar la cantidad de pasajeros: ";
$cantidadPasajeros = trim(fgets(STDIN));
echo "Cargar datos del pasajero: \n";
$coleccionPersonas = solicitarDatosPasajero($cantidadPasajeros, $arrayPersonas);

$responsable = new ResponsableV($nombreResponsable, $apellidoResponsable, $numEmpleado, $numLicencia);
$viaje = new Viaje($codigo, $destino, $cantidadPasajeros, $coleccionPersonas, $responsable);


do {
    $opcion = seleccionarOpcion();
    switch ($opcion) {
        case 1:
            echo "*************** SELECCIONAR OPCION: ***************\n";
            echo "[1]Modificar el codigo del viaje: (actual: " . $viaje->get_CodigoViaje() . ")\n";
            echo "[2]Modificar el destino del viaje: (actual: " . $viaje->get_DestinoViaje() . ")\n";
            echo "[3]Modificar el maximo de pasajeros: (actual: " . $viaje->get_MaxPasajeros() . ")\n";
            $opcionModificacion = trim(fgets(STDIN));
            switch ($opcionModificacion) {
                case 1:
                    echo "Ingresar el nuevo codigo: ";
                    $nuevoCodigo = trim(fgets(STDIN));
                    $viaje->set_CodigoViaje($nuevoCodigo);
                    break;

                case 2:
                    echo "Ingresar el nuevo destino: ";
                    $nuevoDestino = trim(fgets(STDIN));
                    $viaje->set_DestinoViaje($nuevoDestino);
                    break;
                case 3:
                    echo "Ingresar la nueva cantidad maxima: ";
                    $nuevaCantidad = trim(fgets(STDIN));
                    $cantidadAntigua = $viaje->get_MaxPasajeros();
                    $viaje->set_MaxPasajeros($nuevaCantidad);
                    if ($nuevaCantidad > $cantidadAntigua) {
                        $arrayAntiguo = $coleccionPersonas;
                        $nuevaCantidad = $nuevaCantidad - $cantidadAntigua;
                        $nuevosPasajeros = solicitarDatosPasajero($nuevaCantidad, $arrayAntiguo);
                        // $arrayDePasajeros =  array_merge($arrayAntiguo, $nuevosPasajeros);
                        print_r($nuevosPasajeros);
                        $viaje->set_Objpasajeros($nuevosPasajeros);
                    }
                    break;
            }
            break;
        case 2:

            echo "Ingresar el numero de dni para identificar a la persona: ";
            $dniPersona = trim(fgets(STDIN));
            $pasajerosActualizados = $coleccionPersonas;
            for ($i = 0; $i < count($pasajerosActualizados); $i++) {
                if ($dniPersona == $pasajerosActualizados[$i]->get_dni()) {
                    echo "*************** SELECCIONAR OPCION: ***************\n";
                    echo "[1]Modificar el Nombre: (actual: " . $pasajerosActualizados[$i]->get_nombre() . ")\n";
                    echo "[2]Modificar el Apellido: (actual: " . $pasajerosActualizados[$i]->get_apellido() . ")\n";
                    echo "[3]Modificar el DNI: (actual: " . $pasajerosActualizados[$i]->get_dni() . ")\n";
                    echo "[4]Modificar el telefono: (actual:" . $pasajerosActualizados[$i]->get_telefono() . ")\n";
                    $opcionModificacionPersona = trim(fgets(STDIN));
                    switch ($opcionModificacionPersona) {
                        case 1:
                            echo "Ingresar el nuevo nombre: ";
                            $nuevoNombre = trim(fgets(STDIN));
                            $pasajerosActualizados[$i]->set_nombre($nuevoNombre);
                            break;
                        case 2:
                            echo "Ingresar el nuevo apellido: ";
                            $nuevoApellido = trim(fgets(STDIN));
                            $pasajerosActualizados[$i]->set_apellido($nuevoNombre);
                            break;
                        case 3:
                            echo "Ingresar el nuevo dni: ";
                            $nuevoDni = trim(fgets(STDIN));
                            $pasajerosActualizados[$i]->set_dni($nuevoNombre);
                            break;
                        case 4:
                            echo "Ingresar el nuevo telefono: ";
                            $nuevoTelefono = trim(fgets(STDIN));
                            $pasajerosActualizados[$i]->set_telefono($nuevoTelefono);
                            break;
                    }
                }
            }
            break;
        case 3:
            echo $viaje;
            break;
    }
} while ($opcion != 4);
