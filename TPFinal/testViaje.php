<?php
include_once './datos/BaseDatos.php';
include_once 'Empresa.php';
include_once 'Pasajeros.php';
include_once 'ResponsableV.php';
include_once 'Viaje.php';


// $empresa = new Empresa(88888, "ViajesDelSur", "Av Arg12333");
// $responsable = new ResponsableV("JUAN", "martinez", 1333, 33333);
// $viaje = new Viaje(1451, "Cordoba", 12, $empresa, 2500, [], $responsable);
// $viaje->insertarViaje();


/**
 * Seleccionar una opcion
 * retorna el numero de opcion
 * @return int
 */
function seleccionarOpcion()
{
    echo "//////////// MENU SELECCIONAR UNA OPCION: ///////////////\n" .
        "----------PASAJEROS----------\n" .
        "[P1] Ingresar un nuevo pasajero\n" .
        "[P2] Ver pasajeros \n" .
        "[P3] Modificar Pasajero\n" .
        "[P4] Eliminar Pasajero\n" .


        "----------EMPRESAS-----------\n" .
        "[E1] Ingresar nueva empresa: \n" .
        "[E2] Ver empreas \n" .
        "[E3] Modificar informacion de una empresa: \n" .
        "[E4] Eliminar una empresa: \n" .



        "----------VIAJES----------\n" .
        "[V1] Ingresar un nuevo viaje\n" .
        "[V2] Ver viajes \n" .
        "[V3] Modificar datos de un viaje\n" .
        "[V4] Eliminar un viaje\n" .
        "----------RESPONSABLES----------\n" .
        "[R1] Ingresar un nuevo responsable\n" .
        "[R2] Ver responsables \n" .
        "[R3] Modificar datos de un responsable\n" .
        "[R4] Eliminar un responsable\n" .
        "[0] Salir \n";
    $opcionElegida = trim(fgets(STDIN));
    return $opcionElegida;
}

do {
    $opcion = seleccionarOpcion();


    switch ($opcion) {
        case "E1":
            echo "Insertar informacion de la nueva empresa: \n";
            echo "Nombre empresa: \n";
            $nombreEmpresa = trim(fgets(STDIN));
            echo "Direccion empresa: \n";
            $direccionEmpresa = trim(fgets(STDIN));
            $empresa = new Empresa();
            $empresa->cargar('', $nombreEmpresa, $direccionEmpresa);
            // se agrega la empresa a la base de datos
            $resp = $empresa->insertarEmpresa();
            if ($resp) {
                echo "#### Empresa agregada con exito a la base de datos #####\n";
            } else {
                echo "No se pudo agregar a la base de datos: \n";
                echo $empresa->getmensajeoperacion();
            }
            break;
        case "E2":
            $empresa = new Empresa();
            $colEmpresas = $empresa->listarEmpresas();
            if ($colEmpresas) {
                foreach ($colEmpresas as $Infoempresa) {
                    echo $Infoempresa;
                    echo "-----------------------------\n";
                }
            } else {
                echo "\033[31mNo hay empresas\033[0m\n";
            }
            break;
        case "E3":
            $empresa = new Empresa();
            $colEmpresas = $empresa->listarEmpresas();
            if ($colEmpresas) {
                foreach ($colEmpresas as $Infoempresa) {
                    echo $Infoempresa;
                    echo "-----------------------------\n";
                }
                echo "Ingrese el numero de identificacion de la empresa a modificar: \n";
                $idEmpresa = trim(fgets(STDIN));
                $empresaEncontrada = $empresa->Buscar($idEmpresa);
                if ($empresaEncontrada) {
                    echo "Ingresar la nueva direccion: \n";
                    $direccionEmpresa = trim(fgets(STDIN));
                    echo "Ingresar el nuevo nombre de la empresa: \n";
                    $nombreEmpresa = trim(fgets(STDIN));


                    $empresa->set_direccion($direccionEmpresa);
                    $empresa->set_nombre($nombreEmpresa);

                    $resp = $empresa->modificarEmpresa();
                    if ($resp) {
                        echo " ####Datos de la empresa modificados con exito ####\n";
                    } else {
                        echo "Falla la modificacion de datos \n";
                        echo $empresa->getmensajeoperacion();
                    }
                } else {
                    echo "\033[31mNo hay empresas con ese numero de IDENTIFICACION\033[0m\n";
                }
            } else {
                echo "\033[31mNo hay empresas\033[0m\n";
            }
            break;
        case "E4":
            $empresa = new Empresa();
            $colEmpresas = $empresa->listarEmpresas();
            // se muestran las empresas
            if ($colEmpresas) {
                foreach ($colEmpresas as $Infoempresa) {
                    echo $Infoempresa;
                    echo "-----------------------------\n";
                }
                echo "Ingresar la identificacion de la empresa a eliminar: ";
                $idEmpresa = trim(fgets(STDIN));
                $empresaEncontrada = $empresa->Buscar($idEmpresa);
                if ($empresaEncontrada) {
                    echo "Si eliminas una empresa eliminaras sus viajes y pasajeros vinculados, continuar(s/n)?:\n";
                    $confirmacionElimianr = trim(fgets(STDIN));
                    if ($confirmacionElimianr == "s") {
                        $viaje = new Viaje();

                        // se muestra la Coleccion de viajes vinculados a esa empresa
                        $colObjviajes = $viaje->listarViajes("idempresa='" . $idEmpresa . "'");

                        foreach ($colObjviajes as $objViaje) {
                            $idViaje = $objViaje->get_idViaje();
                            echo "\033[34m#######INFORMACION DEL VIAJE A ELIMINAR:######## \n";
                            echo $objViaje . "\033[0m";
                            $objPasajero  = new Pasajeros();
                            // //se muestra coleccion de pasajeros vinculados al viaje
                            $colObjPasajeros = $objPasajero->listarPasajeros("idviaje='" . $idViaje . "'");

                            foreach ($colObjPasajeros as $objPasajero) {
                                echo "\033[33mPasajero vinculado a ese viaje: \033[0m\n";
                                echo "\033[32m" . $objPasajero . "\033[0m";
                                $objPasajero->eliminarPasajero();
                            }
                            $objViaje->eliminarViaje();
                            echo "\033[34m######FIN INFORMACION DEL VIAJE A ELIMINAR######\033[0m\n";
                        }
                        $empresa->Buscar($idEmpresa);

                        if ($empresa->eliminarEmpresa()) {
                            echo "#### SE ELIMINARON LOS DATOS CORRECTAMENTE ####\n";
                        }
                    }
                } else {
                    echo "\033[31mNo hay empresas con ese numero de IDENTIFICACION\033[0m\n";
                }
            } else {
                echo "\033[31mNo hay empresas\033[0m\n";
            }

            break;

        case "P1":
            echo "Insertar informacion del nuevo pasajero: \n";
            echo "Numero documento pasajero: \n";
            $numeroDocumentoPasajero = trim(fgets(STDIN));
            echo "Nombre pasajero: \n";
            $nombrePasajero = trim(fgets(STDIN));
            echo "Apellido pasajero: \n";
            $apellidoPasajero = trim(fgets(STDIN));
            echo "Telefono pasajero: \n";
            $telefonoPasajero = trim(fgets(STDIN));


            $viaje = new Viaje();
            $colViajes = $viaje->listarViajes();
            $empresa = new Empresa();
            $colEmpresas = $empresa->listarEmpresas();
            if ($colEmpresas) {
                if ($colViajes) {
                    echo "###### INFORMACION VIAJES ######\n";
                    foreach ($colViajes as $viaje) {
                        echo $viaje;
                        echo "-----------------------------------------\n";
                    }
                    echo "Ingresar el numero de viaje: \n";
                    $idViajeAsignado = trim(fgets(STDIN));

                    // VERIFICAR DISPONIBILIDAD 

                    $viaje->BuscarViaje($idViajeAsignado);

                    $cantMaxViajeSeleccionado  = $viaje->get_cantMaxPasajeros();

                    // Se verifica la cantidad de pasajeros que ya ya estan en el viaje 

                    $pasajero = new Pasajeros();

                    $cantidadPasajeros = count($pasajero->listarPasajeros("idviaje='" . $idViajeAsignado . "'"));

                    if ($cantidadPasajeros < $cantMaxViajeSeleccionado) {
                        $pasajero->cargar($nombrePasajero, $apellidoPasajero, $numeroDocumentoPasajero, $telefonoPasajero, $idViajeAsignado);
                        // se agrega la empresa a la base de datos
                        $resp = $pasajero->insertarPasajero();
                        if ($resp) {
                            echo "#### Pasajero agregado con exito #####\n";
                        } else {
                            echo "No se pudo agregar a la base de datos: \n";
                            echo $pasajero->getmensajeoperacion();
                        }
                    } else {
                        echo "\033[31m No hay espacios disponibles\033[0m\n";
                    }
                } else {
                    echo "\033[31mNo hay viajes disponibles primero necesitas agregar viajes \033[0m\n";
                }
            } else {
                echo "\033[31mNo hay empresas disponibles, primero necesitas agregar empresas \033[0m\n";
            }


            break;
        case "P2":
            $pasajero = new Pasajeros();
            $colPasajeros = $pasajero->listarPasajeros();
            if ($colPasajeros) {
                foreach ($colPasajeros as $Infopasajeros) {
                    echo $Infopasajeros;
                    echo "-----------------------------\n";
                }
            } else {
                echo "\033[31mNo hay pasajeros \033[0m\n";
            }

            break;
        case "P3":
            $pasajero = new Pasajeros();
            $colPasajeros = $pasajero->listarPasajeros();
            if ($colPasajeros) {
                foreach ($colPasajeros as $Infopasajeros) {
                    echo $Infopasajeros;
                    echo "-----------------------------\n";
                }
                echo "Ingrese el numero de dni del pasajero a modificar: \n";
                $numeroDni = trim(fgets(STDIN));

                $pasajeroEncontrado = $pasajero->BuscarPasajero($numeroDni);
                if ($pasajeroEncontrado) {
                    echo "Ingresar el nuevo nombre: \n";
                    $nombre = trim(fgets(STDIN));
                    echo "Ingresar el nuevo apellido: \n";
                    $apellido = trim(fgets(STDIN));
                    echo "Ingresar el nuevo telefono: \n";
                    $telefono = trim(fgets(STDIN));

                    $pasajero->set_nombre($nombre);
                    $pasajero->set_apellido($apellido);
                    $pasajero->set_telefono($telefono);

                    $resp = $pasajero->modificarPasajero();
                    if ($resp) {
                        echo " ####Datos del pasajero modificado con exito ####\n";
                    } else {
                        echo "Falla la modificacion de datos \n";
                        echo $empresa->getmensajeoperacion();
                    }
                } else {
                    echo "\033[31mNo se encuentran pasajeros con ese DNI \033[0m\n";
                }
            } else {
                echo "\033[31mNo hay pasajeros \033[0m\n";
            }

            break;
        case "P4":
            $pasajero = new Pasajeros();
            $colPasajeros = $pasajero->listarPasajeros();
            if ($colPasajeros) {
                foreach ($colPasajeros as $Infopasajeros) {
                    echo $Infopasajeros;
                    echo "-----------------------------\n";
                }
                echo "Ingresar el dni del pasajero a eliminar: ";
                $dni = trim(fgets(STDIN));
                $pasajeroEncontrado = $pasajero->BuscarPasajero($dni);
                if ($pasajeroEncontrado) {
                    $pasajero->set_dni($dni);
                    $resp =  $pasajero->eliminarPasajero();
                    if ($resp) {
                        echo "#### Pasajero eliminado de la base de datos ####\n";
                    } else {
                        echo "Falla la eliminacion:\n";
                        echo  $pasajero->getmensajeoperacion();
                    }
                } else {
                    echo "\033[31mNo se encuentran pasajeros con ese DNI \033[0m\n";
                }
            } else {
                echo "\033[31mNo hay pasajeros \033[0m\n";
            }

            break;
        case "V1":
            echo "Insertar informacion del nuevo viaje: \n";
            echo "Indicar el destino: \n";
            $destino = trim(fgets(STDIN));
            echo "Indicar la cantidad maxima de pasajeros: \n";
            $cantMaxPasajeros = trim(fgets(STDIN));


            $empresa = new Empresa();
            $colEmpresas = $empresa->listarEmpresas();

            if ($colEmpresas) {
                $responsable = new  ResponsableV();
                $colResponsables = $responsable->listarResponsables();
                if ($colResponsables) {
                    echo "-------EMPRESAS DISPONIBLES-------\n";
                    foreach ($colEmpresas as $empresa) {
                        echo $empresa;
                        echo "-----------------------------\n";
                    }
                    echo "Indicar la empresa encargada colocando su ID: \n";
                    $idEmpresa = trim(fgets(STDIN));

                    $seEncontroEmpresa = $empresa->Buscar($idEmpresa);
                    if ($seEncontroEmpresa) {
                        echo "############### EMPRESA SELECCIONADA FUE: ############## \n";
                        echo $empresa;
                        echo "Indicar el importe del viaje: \n";
                        $importeViaje = trim(fgets(STDIN));
                        echo "--------- RESPONSABLES DISPONIBLES -------\n";

                        foreach ($colResponsables as $responsable) {
                            echo $responsable;
                            echo "-----------------------------\n";
                        }
                        echo "Indicar el responsable colocando su Numero de Empleado: \n";
                        $numeroEmpleado = trim(fgets(STDIN));
                        $responsable->Buscar($numeroEmpleado);

                        $viaje = new Viaje();
                        $viaje->set_empresa($empresa);
                        $viaje->set_responsable($responsable);
                        // $empresa, $responsable, []
                        $viaje->cargar('', $destino, $cantMaxPasajeros, $importeViaje, $empresa, $responsable);
                        $resp = $viaje->insertarViaje();

                        if ($resp) {
                            echo "#### Se agrego el viaje exitosamente #####\n";
                        } else {
                            echo "No se pudo agregar a la base de datos: \n";
                            echo $viaje->getmensajeoperacion();
                        }
                    } else {
                        echo "\033[31mNo hay empresas disponibles con esa ID \033[0m\n";
                    }
                } else {
                    echo "\033[31mNo hay responsables disponibles, primero necesitas agregar responsables \033[0m\n";
                }
            } else {
                echo "\033[31mNo hay empresas disponibles, primero necesitas agregar empresas \033[0m\n";
            }


            break;
        case "V2":
            $viaje = new Viaje();
            $colViajes = $viaje->listarViajes();
            if ($colViajes) {
                foreach ($colViajes as $viaje) {
                    echo "\n";
                    echo "\033[32m#####################################\n" .
                        "######### INFORMACION VIAJE #########\n" .
                        "#####################################\033[0m\n";
                    echo "\033[33m" . $viaje;
                    echo "-----  Responsable del viaje   -----\n";
                    echo $viaje->get_responsable();
                    echo "-----Empresa Vinculada al viaje-----\n";
                    echo $viaje->get_empresa() . "\033[0m";
                    echo "-----PASAJEROS VINCULADOS AL VIAJE------\n";
                    echo $viaje->verColeccionPasajeros() . "\n";
                    echo "\033[32m#####################################\n" .
                        "####### FIN INFORMACION VIAJE #######\n" .
                        "#####################################\033[0m\n";
                }
            } else {
                echo "\033[31mNo hay viajes disponibles\033[0m\n";
            }
            break;
        case "V3":
            $viaje = new Viaje();
            $colViajes = $viaje->listarViajes();
            if ($colViajes) {
                foreach ($colViajes as $viaje) {
                    echo "\n";
                    echo "\033[32m#####################################\n" .
                        "######### INFORMACION VIAJE #########\n" .
                        "#####################################\033[0m\n";
                    echo "\033[33m" . $viaje;
                    echo "-----  Responsable del viaje   -----\n";
                    echo $viaje->get_responsable();
                    echo "-----Empresa Vinculada al viaje-----\n";

                    echo $viaje->get_empresa() . "\033[0m";
                    echo "-----PASAJEROS VINCULADOS AL VIAJE------\n";
                    echo $viaje->verColeccionPasajeros() . "\n";
                    echo "\033[32m#####################################\n" .
                        "####### FIN INFORMACION VIAJE #######\n" .
                        "#####################################\033[0m\n";
                }

                echo "Ingrese el numero de identificacion del viaje a modificar: \n";
                $idViaje = trim(fgets(STDIN));
                $viajeEncontrado = $viaje->BuscarViaje($idViaje);
                if ($viajeEncontrado) {
                    echo "Ingresar nuevo destino: \n";
                    $nuevoDestino = trim(fgets(STDIN));
                    echo "Ingresar nueva cantidad maxima de pasajeros: \n";
                    $nuevaCantidadMaximaP = trim(fgets(STDIN));
                    echo "Ingresar el nuevo importe: \n";
                    $nuevoImporte = trim(fgets(STDIN));

                    $viaje->set_idViaje($idViaje);
                    $viaje->set_destino($nuevoDestino);
                    $viaje->set_cantMaxPasajeros($nuevaCantidadMaximaP);
                    $viaje->set_importe($nuevoImporte);


                    $resp = $viaje->modificarViaje();
                    if ($resp) {
                        echo "\033[32m####Datos del viaje han sido modificados con exito ####\033[0m\n";
                    } else {
                        echo "Falla la modificacion de datos \n";
                        echo $empresa->getmensajeoperacion();
                    }
                } else {
                    echo "\033[31mNo hay viajes con ese numero de identificacion\033[0m\n";
                }
            } else {
                echo "\033[31mNo hay viajes disponibles\033[0m\n";
            }
            break;
        case "V4":
            $viaje = new Viaje();
            $colViajes = $viaje->listarViajes();
            if ($colViajes) {
                foreach ($colViajes as $Objviaje) {
                    echo "\n";
                    echo "\033[32m#####################################\n" .
                        "######### INFORMACION VIAJE #########\n" .
                        "#####################################\033[0m\n";
                    echo "\033[33m" . $Objviaje;
                    echo "-----  Responsable del viaje   -----\n";
                    echo $Objviaje->get_responsable();
                    echo "-----Empresa Vinculada al viaje-----\n";
                    echo $Objviaje->get_empresa() . "\033[0m";
                    echo "-----PASAJEROS VINCULADOS AL VIAJE------\n";
                    echo $Objviaje->verColeccionPasajeros() . "\n";
                    echo "\033[32m#####################################\n" .
                        "####### FIN INFORMACION VIAJE #######\n" .
                        "#####################################\033[0m\n";
                }

                echo "Ingresar la identificacion del viaje a eliminar: ";
                $idViaje = trim(fgets(STDIN));
                $viajeEncontrado = $viaje->BuscarViaje($idViaje);
                if ($viajeEncontrado) {
                    echo "Si eliminas este viaje eliminaras tambien todos sus datos vinculados, continuar(s/n)?:\n";
                    $confirmEliminacionViaje = trim(fgets(STDIN));
                    if ($confirmEliminacionViaje== "s") {
                        $viaje->set_idViaje($idViaje);
                        $pasajero = new Pasajeros();
                        $colObjPasajeros = $pasajero->listarPasajeros("idviaje='" . $idViaje . "'");
                        
                        foreach ($colObjPasajeros as $objPasajero) {
                            echo "Pasajero vinculado a ese viaje: \n";
                            echo  $objPasajero . "\n";
                            $objPasajero->eliminarPasajero();
                        }

                        $resp = $viaje->eliminarViaje();

                        if ($resp) {
                            echo "#### Viaje eliminado de la base de datos ####\n";
                        } else {
                            echo "Falla la eliminacion:\n";
                            echo $viaje->getmensajeoperacion();
                        }
                    }
                   
                } else {
                    echo "\033[31mNo hay viajes con ese numero de identificacion\033[0m\n";
                }
            } else {
                echo "\033[31mNo hay viajes disponibles\033[0m\n";
            }
            break;
        case "R1":
            echo "Insertar informacion del nuevo responsable: \n";
            echo "Nombre: \n";
            $nombre = trim(fgets(STDIN));
            echo "Apellido: \n";
            $apellido = trim(fgets(STDIN));
            echo "Numero de licencia: \n";
            $numeroLicencia = trim(fgets(STDIN));

            $responsable = new ResponsableV();

            $responsable->cargar($nombre, $apellido, "", $numeroLicencia);
            // se agrega la empresa a la base de datos
            $resp = $responsable->insertarResponsable();
            if ($resp) {
                echo "#### Responsable agregado con exito #####\n";
            } else {
                echo "No se pudo agregar a la base de datos: \n";
                echo $empresa->getmensajeoperacion();
            }
            break;
        case "R2":
            $responsable = new ResponsableV();
            $colResponsables =  $responsable->listarResponsables();
            if ($colResponsables) {
                foreach ($colResponsables as $objResponsable) {
                    echo "\033[34m\n############### RESPONSABLE ################\n"
                        . $objResponsable .
                        "\n\033[0m";
                    $numeroEmpleado = $objResponsable->get_numeroEmpleado();

                    $viaje = new Viaje();

                    $colViajes = $viaje->listarViajes("rnumeroempleado='" . $numeroEmpleado . "'");

                    if ($colViajes) {
                        foreach ($colViajes as $objViaje) {
                            echo "\n";
                            echo "\033[32m#####################################\n" .
                                "######### INFORMACION VIAJE #########\n" .
                                "#####################################\033[0m\n";
                            echo "\033[33m" . $objViaje;
                            echo "-----Empresa Vinculada al viaje-----\n";
                            echo $objViaje->get_empresa() . "\033[0m";
                            echo "-----PASAJEROS A CARGO------\n";
                            echo $objViaje->verColeccionPasajeros() . "\n";
                            echo "\033[32m#####################################\n" .
                                "####### FIN INFORMACION VIAJE #######\n" .
                                "#####################################\033[0m\n";
                        }
                        echo "\033[34m\n######## FIN INFORMACION RESPONSABLE ########\n\n\033[0m";
                    } else {
                        echo "\033[31mEste responsable no tiene viajes asignados\033[0m\n";
                        echo "\033[34m\n######## FIN INFORMACION RESPONSABLE ########\n\n\033[0m";
                    }
                }
            } else {
                echo "\033[31mNo hay responsables disponibles\033[0m\n";
            }
            break;
        case "R3":
            $responsable = new ResponsableV();
            $colResponsables =  $responsable->listarResponsables();
            if ($colResponsables) {
                foreach ($colResponsables as $objResponsable) {
                    echo "\033[34m\n############### RESPONSABLE ################\n"
                        . $objResponsable .
                        "\n";
                    echo "-----------------------------\n\033[0m";
                }
                echo "Ingresar el numero de empleado que desea modificar: \n";
                $numeroEmpleadoResponsable = trim(fgets(STDIN));
                $responsableEncontrado = $responsable->Buscar($numeroEmpleadoResponsable);

                if ($responsableEncontrado) {
                    echo "Ingrese el nuevo numero de licencia: \n";
                    $nuevoNumeroLicencia = trim(fgets(STDIN));
                    echo "Ingrese el nuevo nombre: \n";
                    $nuevoNombreResponsable = trim(fgets(STDIN));
                    echo "Ingresar el nuevo apellido: \n";
                    $nuevoApellidoResponsable = trim(fgets(STDIN));


                    $responsable->set_numeroEmpleado($numeroEmpleadoResponsable);
                    $responsable->set_numeroLicencia($nuevoNumeroLicencia);
                    $responsable->set_nombreResponsable($nuevoNombreResponsable);
                    $responsable->set_apellidoResponsable($nuevoApellidoResponsable);

                    $resp = $responsable->modificarResponsable();
                    if ($resp) {
                        echo " ####Datos del responsable modificado con exito ####\n";
                    } else {
                        echo "Falla la modificacion de datos \n";
                        echo $empresa->getmensajeoperacion();
                    }
                } else {
                    echo "\033[31mNo hay responsables con ese numero de licencia\033[0m\n";
                }
            } else {
                echo "\033[31mNo hay responsables disponibles\033[0m\n";
            }
            break;
        case "R4":
            $responsable = new ResponsableV();
            $colResponsables =  $responsable->listarResponsables();
            if ($colResponsables) {
                foreach ($colResponsables as $objResponsable) {
                    echo "\033[34m\n############### RESPONSABLE ################\n"
                        . $objResponsable .
                        "\n";
                    echo "-----------------------------\n\033[0m";
                }
                echo "Ingresar el numero de empleado que desea eliminar: \n";
                $numeroEmpleadoResponsable = trim(fgets(STDIN));

                $responsableEncontrado = $responsable->Buscar($numeroEmpleadoResponsable);

                if ($responsableEncontrado) {

                    echo "Si eliminas este responsable tambien eliminaras sus viajes y pasajeros vinculados, continuar(s/n)?:\n";
                    $confirmacionElimianr = trim(fgets(STDIN));
                    if ($confirmacionElimianr == "s") {
                        $viaje = new Viaje();

                        // se muestra la Coleccion de viajes vinculados al responsable
                        $colObjviajes = $viaje->listarViajes("rnumeroempleado='" . $numeroEmpleadoResponsable . "'");

                        foreach ($colObjviajes as $objViaje) {
                            $idViaje = $objViaje->get_idViaje();
                            echo "\033[34m#######INFORMACION DEL VIAJE A ELIMINAR:######## \n";
                            echo $objViaje . "\033[0m";
                            $objPasajero  = new Pasajeros();
                            //se muestra coleccion de pasajeros vinculados al viaje
                            $colObjPasajeros = $objPasajero->listarPasajeros("idviaje='" . $idViaje . "'");

                            foreach ($colObjPasajeros as $objPasajero) {
                                echo "\033[33mPasajero vinculado a ese viaje: \033[0m\n";
                                echo "\033[32m" . $objPasajero . "\033[0m";
                                $objPasajero->eliminarPasajero();
                            }
                            $objViaje->eliminarViaje();
                            echo "\033[34m######FIN INFORMACION DEL VIAJE A ELIMINAR######\033[0m\n";
                        }
                        $responsable->Buscar($numeroEmpleadoResponsable);

                        if ($responsable->eliminarResponsable()) {
                            echo "\033[31SE ELIMINO EL RESPONSABLE Y SUS DATOS VINCULADOS\033[0m\n";
                        }
                    }

                    $responsable->set_numeroEmpleado($numeroEmpleadoResponsable);
                    $resp =  $responsable->eliminarResponsable();
                    if ($resp) {
                        echo "#### Empleado eliminado de la base de datos ####\n";
                    } else {
                        echo "Falla la eliminacion:\n";
                        echo  $responsable->getmensajeoperacion();
                    }
                } else {
                    echo "\033[31mNo hay responsables con ese numero de licencia\033[0m\n";
                }
            } else {
                echo "\033[31mNo hay responsables disponibles\033[0m\n";
            }
            break;
    }
} while ($opcion != 0);
