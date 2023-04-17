<?php
include 'Viaje.php';

// string $codigo, $destino, $nuevoCodigo, $nuevoDestino, $nuevaCantidad, $nuevoNombre, $nuevoDni, $nuevoApellido
// int $cantidadPasajeros, $dniPasajero, $opcion, $opcionModificacion, $opcionModificacionPersona
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

/**
 * solicita datos de pasajeros para una determinada cantidad
 * y carga los datos en el array
 * @param int $cantPasajeros
 * @param array $arrayPersonas
 */
function solicitarDatosPasajero($cantPasajeros)
{
    // int $contCant
    // string $nombrePasajero, $apellidoPasajero, $dniPasajero
    $nombrePasajero = "";
    $apellidoPasajero = "";
    $dniPasajero = 0;
    $contCant = 1;
    $arrayPersonas = [];
    do {
        echo "Nombre: ";
        $nombrePasajero = trim(fgets(STDIN));
        echo "Apellido: ";
        $apellidoPasajero = trim(fgets(STDIN));
        echo "DNI: ";
        $dniPasajero = trim(fgets(STDIN));

        array_push($arrayPersonas, array("nombre" => $nombrePasajero, "apellido" => $apellidoPasajero, "dni" => $dniPasajero));
        $contCant++;
    } while ($contCant == $cantPasajeros);
    return $arrayPersonas;
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
echo "Ingresar la cantidad de pasajeros: ";
$cantidadPasajeros = trim(fgets(STDIN));
echo "Cargar datos del pasajero: \n";
$coleccionPersonas = solicitarDatosPasajero($cantidadPasajeros);

// print_r($coleccionPersonas);
$viaje = new Viaje($codigo, $destino, $cantidadPasajeros, $coleccionPersonas);
$datosPasajeroActual = $viaje->get_Pasajeros();


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
                        $nuevaCantidad = $nuevaCantidad - $cantidadAntigua;
                        $nuevosPasajeros = solicitarDatosPasajero($nuevaCantidad);
                        $arrayAntiguo = $viaje->get_Pasajeros();
                        $arrayDePasajeros =  array_merge($arrayAntiguo, $nuevosPasajeros);
                        $viaje->set_Pasajeros($arrayDePasajeros);
                    }
                    break;
            }
            break;
        case 2:

            echo "Ingresar el numero de dni para identificar a la persona: ";
            $dniPersona = trim(fgets(STDIN));
            $pasajerosActualizados = $viaje->get_Pasajeros();
            for ($i = 0; $i < count($pasajerosActualizados); $i++) {
                if ($dniPersona == $pasajerosActualizados[$i]["dni"]) {
                    // echo $pasajerosActualizados[$i]["nombre"];
                    echo "*************** SELECCIONAR OPCION: ***************\n";
                    echo "[1]Modificar el Nombre: (actual: " . $pasajerosActualizados[$i]["nombre"] . ")\n";
                    echo "[2]Modificar el Apellido: (actual: " . $pasajerosActualizados[$i]["apellido"] . ")\n";
                    echo "[3]Modificar el DNI: (actual: " . $pasajerosActualizados[$i]["dni"] . ")\n";
                    $opcionModificacionPersona = trim(fgets(STDIN));
                    switch ($opcionModificacionPersona) {

                        case 1:
                            echo "Ingresar el nuevo nombre: ";
                            $nuevoNombre = trim(fgets(STDIN));
                            $viaje->set_DatosPasajeros($i, "nombre", $nuevoNombre);
                            break;
                        case 2:
                            echo "Ingresar el nuevo apellido: ";
                            $nuevoApellido = trim(fgets(STDIN));
                            $viaje->set_DatosPasajeros($i, "apellido", $nuevoApellido);
                            break;
                        case 3:
                            echo "Ingresar el nuevo dni: ";
                            $nuevoDni = trim(fgets(STDIN));
                            $viaje->set_DatosPasajeros($i, "dni", $nuevoDni);
                            break;
                    }
                    break;
                }
            }

        case 3:
            echo $viaje;
            break;
    }
} while ($opcion != 4);
