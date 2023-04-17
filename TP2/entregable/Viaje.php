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


    public function __construct($codigoViaje, $destinoViaje, $cantMaxPasajeros, $pasajeros, $responsable)
    // Metodo constructor 
    {
        $this->codigoViaje = $codigoViaje;
        $this->destinoViaje = $destinoViaje;
        $this->cantMaxPasajeros = $cantMaxPasajeros;
        $this->pasajeros = $pasajeros;
        $this->responsable = $responsable;
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

    public function __toString()
    {
        $cadena = "";
        for ($i = 0; $i < count($this->get_Objpasajeros()); $i++) {
            $cadena = "******************PASAJERO [" . $i + 1 . "] ****************** \n"
                . "NOMBRE: " . $this->get_Objpasajeros()[$i]->get_nombre() . "\n" 
                . "APELLIDO: ". $this->get_Objpasajeros()[$i]->get_apellido() . "\n"
                . "DNI: ".$this->get_Objpasajeros()[$i]->get_dni() . "\n"
                . "TELEFONO: ".$this->get_Objpasajeros()[$i]->get_telefono() . "\n". $cadena;
        }
        return  "*************** DATOS DEL VIAJE: ****************\n" .
            "CODIGO DEL VIAJE: " . $this->get_CodigoViaje() . "\n" .
            "DESTINO: " . $this->get_DestinoViaje() . "\n" .
            "CANTIDAD DE PASAJEROS: " . $this->get_MaxPasajeros() . "\n" .
            "RESPONSABLE: " . $this->get_Responsable()->get_nombreResponsable() . "\n" .
            "*************************************************\n" .
            $cadena;
    }
}

