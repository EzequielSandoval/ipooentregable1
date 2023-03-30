<?php
class Viaje
{
    // Registra almacena y representa informacion referencia a viajes 
    // atributos: 
    private $codigoViaje;
    private $destinoViaje;
    private $cantMaxPasajeros;
    private $pasajeros = [];



    public function __construct($codigoViaje, $destinoViaje, $cantMaxPasajeros, $pasajeros)
    // Metodo constructor 
    {
        $this->codigoViaje = $codigoViaje;
        $this->destinoViaje = $destinoViaje;
        $this->cantMaxPasajeros = $cantMaxPasajeros;
        $this->pasajeros = $pasajeros;
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
    public function get_Pasajeros()
    {
        return $this->pasajeros;
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
    public function set_Pasajeros($arrayPasajeros)
    {
        $this->pasajeros = $arrayPasajeros;
    }
    // asignar los datos de los pasajeros del viaje del viaje al atributo
    public function set_DatosPasajeros($numeroPasajero, $tipoDato, $valorTipodato)
    {
        $this->pasajeros[$numeroPasajero][$tipoDato] = $valorTipodato;
    }

    public function __toString()
    {
        $cadena = "";
        for ($i = 0; $i < count($this->get_Pasajeros()); $i++) {
            $cadena = "******************PASAJERO [" . $i+1 . "] ****************** \n"
                . "NOMBRE: " . $this->get_Pasajeros()[$i]["nombre"] . "\n"
                . "APELLIDO: " . $this->get_Pasajeros()[$i]["apellido"] . "\n"
                . "DNI: " . $this->get_Pasajeros()[$i]["dni"] . "\n" .
                "************************************************* \n" . $cadena;
        }
        return  "*************** DATOS DEL VIAJE: ****************\n" .
            "CODIGO DEL VIAJE: " . $this->get_CodigoViaje() . "\n" .
            "DESTINO: " . $this->get_DestinoViaje() . "\n" .
            "CANTIDAD DE PASAJEROS: " . $this->get_MaxPasajeros() . "\n" .
            "*************************************************\n" .
            $cadena;
    }
}
