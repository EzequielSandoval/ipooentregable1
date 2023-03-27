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
echo "Ingresar el codigo del viaje: ";
$codigo = trim(fgets(STDIN));
echo "Ingresar el destino del viaje: ";
$destino = trim(fgets(STDIN));
echo "Ingresar la cantidad de pasajeros: ";
$cantidadPasajeros = trim(fgets(STDIN));
echo "Cargar datos del pasajero: \n";

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


$coleccionPersonas = solicitarDatosPasajero($cantidadPasajeros);
$nuevosPasajeros = [];
// print_r($coleccionPersonas);
$viaje = new Viaje($codigo, $destino, $cantidadPasajeros, $coleccionPersonas);
$datosPasajeroActual = $viaje->getPasajeros();

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
    echo "[4] Ver datos de los pasajeros: \n";
    echo "[5] Salir\n";
    $opcionElegida = trim(fgets(STDIN));
    return $opcionElegida;
}


do {
    $opcion = seleccionarOpcion();
    switch ($opcion) {
        case 1:
            echo "*************** SELECCIONAR OPCION: ***************\n";
            echo "[1]Modificar el codigo del viaje: (actual: " . $viaje->getCodigoViaje() . ")\n";
            echo "[2]Modificar el destino del viaje: (actual: " . $viaje->getDestinoViaje() . ")\n";
            echo "[3]Modificar el maximo de pasajeros: (actual: " . $viaje->getMaxPasajeros() . ")\n";
            $opcionModificacion = trim(fgets(STDIN));
            switch ($opcionModificacion) {
                case 1:
                    echo "Ingresar el nuevo codigo: ";
                    $nuevoCodigo = trim(fgets(STDIN));
                    $viaje->setCodigoViaje($nuevoCodigo);
                    break;

                case 2:
                    echo "Ingresar el nuevo destino: ";
                    $nuevoDestino = trim(fgets(STDIN));
                    $viaje->setDestinoViaje($nuevoDestino);
                    break;
                case 3:
                    echo "Ingresar la nueva cantidad maxima: ";
                    $nuevaCantidad = trim(fgets(STDIN));
                    $cantidadAntigua = $viaje->getMaxPasajeros();
                    $viaje->setMaxPasajeros($nuevaCantidad);
                    if ($nuevaCantidad > $cantidadAntigua) {
                        $nuevaCantidad = $nuevaCantidad - $cantidadAntigua;
                        $nuevosPasajeros = solicitarDatosPasajero($nuevaCantidad);
                        $arrayAntiguo = $viaje->getPasajeros();


                        echo "antiguo: ";
                        print_r($arrayAntiguo);
                        $arrayDePasajeros =  array_merge($arrayAntiguo, $nuevosPasajeros);
                        $viaje->setPasajeros($arrayDePasajeros);
                        echo "nuevo: ";
                        print_r($viaje->getPasajeros());
                    }
                    break;
            }
            break;
        case 2:
            echo "Ingresar el numero de persona a modificar: ";
            $numeroPersona = trim(fgets(STDIN));
            $numeroPersona = $numeroPersona - 1;
            echo "*************** SELECCIONAR OPCION: ***************\n";
            echo "[1]Modificar el Nombre: (actual: " . $datosPasajeroActual[$numeroPersona]["nombre"] . ")\n";
            echo "[2]Modificar el Apellido: (actual: " . $datosPasajeroActual[$numeroPersona]["apellido"] . ")\n";
            echo "[3]Modificar el DNI: (actual: " . $datosPasajeroActual[$numeroPersona]["dni"] . ")\n";
            $opcionModificacionPersona = trim(fgets(STDIN));
            switch ($opcionModificacionPersona) {

                case 1:
                    echo "Ingresar el nuevo nombre: ";
                    $nuevoNombre = trim(fgets(STDIN));
                    $viaje->setDatosPasajeros($numeroPersona, "nombre", $nuevoNombre);
                    break;
                case 2:
                    echo "Ingresar el nuevo apellido: ";
                    $nuevoApellido = trim(fgets(STDIN));
                    $viaje->setDatosPasajeros($numeroPersona, "apellido", $nuevoApellido);
                    break;
                case 3:
                    echo "Ingresar el nuevo dni: ";
                    $nuevoDni = trim(fgets(STDIN));
                    $viaje->setDatosPasajeros($numeroPersona, "dni", $nuevoDni);
                    break;
            }
            break;
        case 3:
            echo "*************** DATOS DEL VIAJE: ************************\n";
            echo "**** ****\n";
            echo "CODIGO DEL VIAJE: " . $viaje->getCodigoViaje() . "\n";
            echo "DESTINO: " . $viaje->getDestinoViaje() . "\n";
            echo "CANTIDAD DE PASAJEROS: " . $viaje->getMaxPasajeros() . "\n";
            echo "*********************************************************\n";
            break;
        case 4:
            $datosPasajeros = $viaje->getPasajeros();
            echo "DATOS DE LOS PASAJEROS: \n";
            // print_r($datosPasajeros);
            for ($i = 0; $i < count($datosPasajeros); $i++) {
                echo "--------------------------------------------------\n";
                echo "Nombre: " . $datosPasajeros[$i]["nombre"] . "\n";
                echo "Apellido: " . $datosPasajeros[$i]["apellido"] . "\n";
                echo "Dni: " . $datosPasajeros[$i]["dni"] . "\n";
                echo "--------------------------------------------------\n";
            }
            break;
    }
} while ($opcion != 5);
