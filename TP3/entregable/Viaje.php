<?php
class Viaje
{
    // Registra almacena y representa informacion referencia a viajes 
    // atributos: 
    private $codigoViaje;
    private $destinoViaje;
    private $cantMaxPasajeros;
    private $pasajeros;
    private $responsable;
    private $costoViaje;
    private $sumaCostos;
    public function __construct($codigoViaje, $destinoViaje, $cantMaxPasajeros, $pasajeros, $responsable, $costoViaje, $sumaCostos)
    // Metodo constructor 
    {
        $this->codigoViaje = $codigoViaje;
        $this->destinoViaje = $destinoViaje;
        $this->cantMaxPasajeros = $cantMaxPasajeros;
        $this->pasajeros = $pasajeros;
        $this->responsable = $responsable;
        $this->costoViaje = $costoViaje;
        $this->sumaCostos = $sumaCostos;
   
    }

    // retorna el codigo del viaje
    public function get_CodigoViaje()
    {
        return $this->codigoViaje;
    }
    // retorna el destino del viaje
    public function get_DestinoViaje()
    {
        return $this->destinoViaje;
    }
    // retorna el maximo de pasajeros del viaje
    public function get_MaxPasajeros()
    {
        return $this->cantMaxPasajeros;
    }
    // retorna los datos de los pasajeros del viaje del viaje
    public function get_Objpasajeros()
    {
        return $this->pasajeros;
    }
   
    // retorna los datos de los pasajeros del viaje del viaje
    public function get_Responsable()
    {
        return $this->responsable;
    }

    public function get_costoViaje()
    {
        return $this->costoViaje;
    }

    public function get_sumaCostos()
    {
        return $this->sumaCostos;
    }
    public function set_sumaCostos($sumaCostos)
    {
        $this->sumaCostos = $sumaCostos;
    }

    // asignar el codigo del viaje  al atributo
    public function set_CodigoViaje($codigoViaje)
    {
        $this->codigoViaje = $codigoViaje;
    }
    // asignar el destino del viaje al atributo
    public function set_DestinoViaje($destinoViaje)
    {
        $this->destinoViaje = $destinoViaje;
    }
    // asignar el maximo de pasajeros del viaje al atributo
    public function set_MaxPasajeros($cantMaxPasajeros)
    {
        $this->cantMaxPasajeros = $cantMaxPasajeros;
    }
    // asignar nuevos pasajeros
    public function set_Objpasajeros($arrayPasajeros)
    {
        $this->pasajeros = $arrayPasajeros;
    }

 
    // asignar los datos de los pasajeros del viaje del viaje al atributo
    public function set_DatosPasajeros($numeroPasajero, $tipoDato, $valorTipodato)
    {
        $this->pasajeros[$numeroPasajero][$tipoDato] = $valorTipodato;
    }
    // asignar nuevos pasajeros
    public function set_Responsable($responsable)
    {
        $this->responsable = $responsable;
    }
    public function set_costoViaje($costoViaje)
    {
        $this->costoViaje = $costoViaje;
    }

    public function hayPasajesDisponibles()
    {
        $coleccionPasajeros = $this->get_Objpasajeros();


        $cantidadActualPasajeros = count($coleccionPasajeros);
        $cantidadMaximaPasajeros = $this->get_MaxPasajeros();
        $hayPasajesDisponibles = false;

        if ($cantidadActualPasajeros < $cantidadMaximaPasajeros) {
            $hayPasajesDisponibles = true;
        }
        return $hayPasajesDisponibles;
    }

    public function venderPasaje($Objpasajero, $tipoPasajero, $porcIncremento)
    {
        $pasajeDisponible = $this->hayPasajesDisponibles();
        if ($pasajeDisponible) {
            if ($tipoPasajero == "PasajerosComunes") {
                $coleccionPasajeros = $this->get_Objpasajeros();
                $coleccionPasajeros[$tipoPasajero][] = $Objpasajero;
                $this->set_Objpasajeros($coleccionPasajeros);
                $costoViaje = $this->get_costoViaje();
                $sumaCostos = $this->get_sumaCostos();
                $costoFinal = $costoViaje + ($costoViaje * $porcIncremento);
                $totalCostos = $sumaCostos + $costoFinal;
                $this->set_sumaCostos($totalCostos);
            } elseif ($tipoPasajero == "PasajerosVip") {
                $coleccionPasajeros = $this->get_Objpasajeros();
                $coleccionPasajeros[$tipoPasajero][] = $Objpasajero;
                $this->set_Objpasajeros($coleccionPasajeros);
                $costoViaje = $this->get_costoViaje();
                $sumaCostos = $this->get_sumaCostos();
                $costoFinal = $costoViaje + ($costoViaje * $porcIncremento);
                $totalCostos = $sumaCostos + $costoFinal;
                $this->set_sumaCostos($totalCostos);
            } elseif ($tipoPasajero == "PasajerosEspeciales") {
                $coleccionPasajeros = $this->get_Objpasajeros();
                $coleccionPasajeros[$tipoPasajero][] = $Objpasajero;
                $this->set_Objpasajeros($coleccionPasajeros);
                $costoViaje = $this->get_costoViaje();
                $sumaCostos = $this->get_sumaCostos();
                $costoFinal = $costoViaje + ($costoViaje * $porcIncremento);
                $totalCostos = $sumaCostos + $costoFinal;
                $this->set_sumaCostos($totalCostos);
            }
        }
        return $costoFinal;
    }




    public function __toString()
    {
        $cadena = "";
      
        if (isset($this->get_Objpasajeros()["PasajerosComunes"])) {
            for ($i = 0; $i < count($this->get_Objpasajeros()["PasajerosComunes"]); $i++) {
                $pasajeroComun = $this->get_Objpasajeros()["PasajerosComunes"][$i];
                $cadena .= "******************PASAJERO COMUN****************** \n"
                    . "NOMBRE: " . $pasajeroComun->get_nombre() . "\n"
                    . "APELLIDO: " . $pasajeroComun->get_apellido() . "\n"
                    . "DNI: " . $pasajeroComun->get_dni() . "\n"
                    . "TELEFONO: " . $pasajeroComun->get_telefono() . "\n";
            }
        }
        
        if (isset($this->get_Objpasajeros()["PasajerosVip"])) {
            for ($a = 0; $a < count($this->get_Objpasajeros()["PasajerosVip"]); $a++) {
                $pasajeroVip = $this->get_Objpasajeros()["PasajerosVip"][$a];
                $cadena .= "******************PASAJERO VIP****************** \n"
                    . "NOMBRE: " . $pasajeroVip->get_nombre() . "\n"
                    . "APELLIDO: " . $pasajeroVip->get_apellido() . "\n"
                    . "DNI: " . $pasajeroVip->get_dni() . "\n"
                    . "TELEFONO: " . $pasajeroVip->get_telefono() . "\n"
                    . "Num Viajero Frecuente: " . $pasajeroVip->get_numViajeFrecuente() . "\n"
                    . "Cant Millas: " . $pasajeroVip->get_cantMillas() .  "\n";
            }
        }
       
        if (isset($this->get_Objpasajeros()["PasajerosEspeciales"])) {
            for ($e = 0; $e < count($this->get_Objpasajeros()["PasajerosEspeciales"]); $e++) {
                $pasajeroEspecial = $this->get_Objpasajeros()["PasajerosEspeciales"][$e];
                $cadena .= "******************PASAJERO ESPECIAL****************** \n"
                    . "NOMBRE: " . $pasajeroEspecial->get_nombre() . "\n"
                    . "APELLIDO: " . $pasajeroEspecial->get_apellido() . "\n"
                    . "DNI: " . $pasajeroEspecial->get_dni() . "\n"
                    . "TELEFONO: " . $pasajeroEspecial->get_telefono() . "\n"
                    . "Necesidad especial: " . $pasajeroEspecial->get_necesidadEspecial() . "\n"
                    . "Silla de ruedas: " . $pasajeroEspecial->get_sillaRuedas() . "\n"
                    . "Asistencia: " . $pasajeroEspecial->get_asistencia() . "\n"
                    . "Comida Especial" . $pasajeroEspecial->get_comidaEspecial() . "\n";
            }
        }

        return  "*************** DATOS DEL VIAJE: ****************\n" .
            "CODIGO DEL VIAJE: " . $this->get_CodigoViaje() . "\n" .
            "DESTINO: " . $this->get_DestinoViaje() . "\n" .
            "CANTIDAD DE PASAJEROS: " . $this->get_MaxPasajeros() . "\n" .
            "RESPONSABLE: " . $this->get_Responsable()->get_nombreResponsable() . "\n" .
            "COSTO: " . $this->get_costoViaje() . "\n" .
            "SUMA TOTAL DE VENTAS: " . $this->get_sumaCostos() . "\n" .
            "*************************************************\n" .
            $cadena;
    }
}
