<?php
/**
 *  Copyright 2011 Realstaters
 *
 * Licensed under the Apache License, Version 2.0 (the "License");
 * you may not use this work except in compliance with the License.
 * You may obtain a copy of the License in the LICENSE file, or at:
 *
 *     http://www.apache.org/licenses/LICENSE-2.0
 *
 * Unless required by applicable law or agreed to in writing, software
 * distributed under the License is distributed on an "AS IS" BASIS,
 * WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
 * See the License for the specific language governing permissions and
 * limitations under the License.
 */

/**
 * Class RealstatersPublicar
 * Organiza la estructura del anuncio a publicar 
 * @author Christian David Ibarguen R <christiandavid@realstaters.com>
 * @version 1.0
 */
require 'realstaters.php';
class RealstatersPublicar {
    /**
    * representa el API cliente
    * @access protected
    */
    protected $realstaters;
	
    /**
    * Opciones permitidas por cada tipo de anuncios
    * @var array
    */
    public static $PROPIEDADES = array(
		#Venta
		'venta' => array(
			'apartaestudio' => 'apartaestudio', 'apartamento' => 'apartamento', 'bodega' => 'bodega', 'casacampestre' => 'casa', 'casa' => 'casa', 'condominio_unidadresidencial' => 'condominio_unidadresidencial', 'edificio' => 'edificio', 'finca' => 'finca', 'franquicia' => 'franquicia', 'localcomercial' => 'localcomercial', 'primalocalcomercial' => 'localcomercial', 'lote' => 'lote', 'lotefunebre' => 'lotefunebre', 'oficina' => 'localcomercial', 'consultorio' => 'localcomercial', 'primaconsultorio' => 'localcomercial', 'primaoficina' => 'localcomercial',	'parcelacion' => 'parcelacion', 'parqueadero_garaje' => 'parqueadero_garaje',
		),
		#Alquiler
		'alquiler' => array(
			'apartaestudio' => 'apartaestudio', 'apartamento' => 'apartamento', 'bodega' => 'bodega', 'casacampestre' => 'casa', 'casa' => 'casa', 'condominio_unidadresidencial' => 'condominio_unidadresidencial', 'edificio' => 'edificio', 'finca' => 'finca', 'localcomercial' => 'localcomercial', 'lote' => 'lote', 'lotefunebre' => 'lotefunebre', 'oficina' => 'localcomercial', 'consultorio' => 'localcomercial', 'parqueadero_garaje' => 'parqueadero_garaje',
		),
		#Alquiler Temporal
		'alquilertemporal' => array(
			'apartaestudio' => 'apartaestudio', 'apartamento' => 'apartamento', 'casacampestre' => 'casa', 'casa' => 'casa', 'finca' => 'finca',
		),
		#Alquiler Compartido
		'alquilercompartido' => array(
			'apartaestudio' => 'apartaestudio', 'apartamento' => 'apartamento', 'casacampestre' => 'casa', 'casa' => 'casa', 'finca' => 'finca', 'hotel' => 'casa', 'hostal' => 'casa', 'hospedaje' => 'casa'
		)
	);
	
    /**
    * Opciones permitidas por Apartaestudio
    * @var array 
    */
	public static $OPCIONES_APARTAESTUDIO = array (
		#Obligatorios
		'id' => null, 'estrato' => null, 'departamento' => null, 'ciudad' => null, 'barrio' => null, 'precio' => null, 'estadoActual' => null, 'titulo' => null, 'descripcion' => null, 
		#Opcionales
		'direccion' => null, 'areaHabitacion' => null, 'areaTotal' => null, 'negociable' => null, 'pisos' => null, 'banos' => null, 'habitaciones' => null, 'parqueaderosPrivados' => null, 'lineasTelefonicas' => null, 'comentarios' => null, 'mesesConstruida' => null, 'anosConstruida' => null, 'depositoAdelanto' => null, 'habitacionesDisponibles' => null, 'latitudMapa' => null, 'longitudMapa' => null, 'zoomMapa' => null,
		#dias, semana, quincena, mes
		'cobroAlquiler' => null,
		#Max 1 Año
		'tiempoMinEstadia' => null,
		#Max 2 Año
		'tiempoMaxEstadia' => null,
		#total, parcial, no
		'amobladoPropiedad' => null,
		#Maximo 5 Imagenes
		'urlImagenes' => null 
	);
	
    /**
    * Opciones permitidas por Apartamento
    * @var array 
    */
    public static $OPCIONES_APARTAMENTO = array (
		#Obligatorios
		'id' => null, 'estrato' => null, 'departamento' => null, 'ciudad' => null, 'barrio' => null, 'precio' => null, 'estadoActual' => null, 'titulo' => null, 'descripcion' => null, 'penthouse' => null,
		#Opcionales
		'direccion' => null, 'areaHabitacion' => null, 'areaTotal' => null, 'negociable' => null, 'pisos' => null, 'banos' => null, 'habitaciones' => null, 'parqueaderosPrivados' => null, 'lineasTelefonicas' => null, 'comentarios' => null, 'mesesConstruida' => null, 'anosConstruida' => null, 'depositoAdelanto' => null, 'habitacionesDisponibles' => null, 'latitudMapa' => null, 'longitudMapa' => null, 'zoomMapa' => null, 
		#dias, semana, quincena, mes
		'cobroAlquiler' => null,
		#Max 1 Año
		'tiempoMinEstadia' => null,
		#Max 2 Año
		'tiempoMaxEstadia' => null,
		#total, parcial, no
		'amobladoPropiedad' => null,
		#Maximo 5 Imagenes
		'urlImagenes' => null 
    );
	
    /**
    * Opciones permitidas por Bodega
    * @var array 
    */
    public static $OPCIONES_BODEGA = array (
		#Obligatorios
		'id' => null, 'estrato' => null, 'departamento' => null, 'ciudad' => null, 'barrio' => null, 'precio' => null, 'estadoActual' => null, 'titulo' => null, 'descripcion' => null,
		#Opcionales
		'direccion' => null, 'areaTotal' => null, 'areaConstruida' => null, 'negociable' => true,  'comentarios' => null,  'mesesConstruida' => null,  'anosConstruida' => null, 'depositoAdelanto' => null, 'latitudMapa' => null, 'longitudMapa' => null, 'zoomMapa' => null,
		#Maximo 5 Dimensiones
		'otrasDimensiones' => null,
		#Maximo 5 Imagenes
		'urlImagenes' => null 
    );
	
    /**
    * Opciones permitidas por Casa, Casa Campestre, Hotel, Hostal, Hospedaje
    * @var array 
    */
    public static $OPCIONES_CASA = array (
		#Obligatorios
		'id' => null, 'estrato' => null, 'departamento' => null, 'ciudad' => null, 'barrio' => null, 'precio' => null, 'estadoActual' => null, 'titulo' => null, 'descripcion' => null, 
		#Opcionales
		'direccion' => null, 'areaHabitacion' => null, 'areaTotal' => null, 'areaConstruida' => null, 'negociable' => null, 'pisos' => null, 'banos' => null, 'habitaciones' => null, 'parqueaderosPrivados' => null, 'lineasTelefonicas' => null, 'comentarios' => null, 'mesesConstruida' => null, 'anosConstruida' => null, 'depositoAdelanto' => null, 'habitacionesDisponibles' => null, 'latitudMapa' => null, 'longitudMapa' => null, 'zoomMapa' => null, 
		#dias, semana, quincena, mes
		'cobroAlquiler' => null,
		#Max 1 Año
		'tiempoMinEstadia' => null,
		#Max 2 Año
		'tiempoMaxEstadia' => null,
		#total, parcial, no
		'amobladoPropiedad' => null,
		#Maximo 5 Imagenes
		'urlImagenes' => null 
    );
	
    /**
    * Opciones permitidas por Condominio o Unidad Residencial
    * @var array 
    */
    public static $OPCIONES_CONDOMINIO_UNIDADRESIDENCIAL = array (
		#Obligatorios
		'id' => null, 'estrato' => null, 'departamento' => null, 'ciudad' => null, 'barrio' => null, 'precio' => null, 'estadoActual' => null, 'titulo' => null, 'descripcion' => null,
		#Opcionales
		'direccion' => null, 'numeroResidencias' => null,'areaTotal' => null, 'areaPorResidencia' => null,'negociable' => null, 'comentarios' => null, 'mesesConstruida' => null, 'anosConstruida' => null, 'depositoAdelanto' => null, 'latitudMapa' => null, 'longitudMapa' => null, 'zoomMapa' => null,
		#Maximo 5 Imagenes
		'urlImagenes' => null
    );
	
    /**
    * Opciones permitidas por Edificio
    * @var array 
    */
    public static $OPCIONES_EDIFICIO = array (
		#Obligatorios
		'id' => null, 'estrato' => null, 'departamento' => null, 'ciudad' => null, 'barrio' => null, 'precio' => null, 'estadoActual' => null, 'titulo' => null, 'descripcion' => null,
		#Opcionales
		'direccion' => null, 'numeroApartamentos' => null,'areaTotal' => null, 'areaPorApartamento' => null,'negociable' => null, 'comentarios' => null, 'mesesConstruida' => null, 'anosConstruida' => null, 'depositoAdelanto' => null, 'latitudMapa' => null, 'longitudMapa' => null, 'zoomMapa' => null,
		#Maximo 5 Imagenes
		'urlImagenes' => null
    );
	
    /**
    * Opciones permitidas por Finca
    * @var array 
    */
    public static $OPCIONES_FINCA = array (
		#Obligatorios
		'id' => null, 'departamento' => null, 'ciudad' => null, 'precio' => null, 'estadoActual' => null, 'titulo' => null, 'descripcion' => null, 
		#Opcionales
		'direccion' => null, 'areaHabitacion' => null, 'areaTotal' => null, 'areaConstruida' => null, 'negociable' => null, 'pisos' => null, 'banos' => null, 'habitaciones' => null, 'parqueaderosPrivados' => null, 'lineasTelefonicas' => null, 'comentarios' => null, 'mesesConstruida' => null, 'anosConstruida' => null, 'depositoAdelanto' => null, 'habitacionesDisponibles' => null, 'latitudMapa' => null, 'longitudMapa' => null, 'zoomMapa' => null, 
		#dias, semana, quincena, mes
		'cobroAlquiler' => null,
		#Max 1 Año
		'tiempoMinEstadia' => null,
		#Max 2 Año
		'tiempoMaxEstadia' => null,
		#total, parcial, no
		'amobladoPropiedad' => null,
		#Maximo 5 Imagenes
		'urlImagenes' => null 
    );
	
    /**
    * Opciones permitidas por Franquicia
    * @var array 
    */
    public static $OPCIONES_FRANQUICIA = array (
		#Obligatorios
		'id' => null, 'departamento' => null, 'ciudad' => null, 'barrio' => null, 'precio' => null, 'estadoActual' => null, 'titulo' => null, 'descripcion' => null,
		#Opcionales
		'productoOServicio' => null, 'direccion' => null, 'negociable' => null, 'comentarios' => null, 'mesesConstruida' => null, 'anosConstruida' => null, 'depositoAdelanto' => null, 'latitudMapa' => null, 'longitudMapa' => null, 'zoomMapa' => null,
		#Maximo 5 Imagenes
		'urlImagenes' => null
    );
	
    /**
    * Opciones permitidas por Local Comercial, Prima Local Comercial, Oficina, Consultorio, Prima de Consultorio, Prima de Oficina
    * @var array 
    */
    public static $OPCIONES_LOCALCOMERCIAL = array (
		#Obligatorios
		'id' => null, 'estrato' => null, 'departamento' => null, 'ciudad' => null, 'barrio' => null, 'precio' => null, 'estadoActual' => null, 'titulo' => null, 'descripcion' => null, 
		#Opcionales
		'direccion' => null, 'areaTotal' => null, 'nombreCentroComercial' => null, 'negociable' => null, 'pisos' => null, 'banos' => null, 'parqueaderosPrivados' => null, 'comentarios' => null, 'mesesConstruida' => null, 'anosConstruida' => null, 'depositoAdelanto' => null, 'latitudMapa' => null, 'longitudMapa' => null, 'zoomMapa' => null, 
		#Maximo 5 Imagenes
		'urlImagenes' => null 
    );
	
    /**
    * Opciones permitidas por Lote
    * @var array 
    */
    public static $OPCIONES_LOTE = array (
		#Obligatorios
		'id' => null, 'estrato' => null, 'departamento' => null, 'ciudad' => null, 'barrio' => null, 'precio' => null, 'estadoActual' => null, 'titulo' => null, 'descripcion' => null, 
		#Opcionales
		'direccion' => null, 'areaTotal' => null, 'negociable' => null, 'comentarios' => null, 'mesesConstruida' => null, 'anosConstruida' => null, 'depositoAdelanto' => null, 'latitudMapa' => null, 'longitudMapa' => null, 'zoomMapa' => null, 
		#Maximo 5 Imagenes
		'urlImagenes' => null 
    );
	
    /**
    * Opciones permitidas por Lote Funebre
    * @var array 
    */
    public static $OPCIONES_LOTEFUNEBRE = array (
		#Obligatorios
		'id' => null, 'departamento' => null, 'ciudad' => null, 'precio' => null, 'titulo' => null, 'descripcion' => null,
		#Opcionales
		'estrato' => null, 'nombreCementerio' => null, 'negociable' => null,  'comentarios' => null, 'mesesConstruida' => null, 'anosConstruida' => null, 'depositoAdelanto' => null, 'latitudMapa' => null, 'longitudMapa' => null, 'zoomMapa' => null,
		#Maximo 5 Imagenes
		'urlImagenes' => null
    );
	
    /**
    * Opciones permitidas por Parcelacion
    * @var array 
    */
	public static $OPCIONES_PARCELACION = array (
		#Obligatorios
		'id' => null, 'estrato' => null, 'departamento' => null, 'ciudad' => null, 'barrio' => null, 'precio' => null, 'estadoActual' => null, 'titulo' => null, 'descripcion' => null, 
		#Opcionales
		'direccion' => null, 'areaTotal' => null, 'areaConstruida' => null, 'numerodeLotes' => null,'negociable' => null, 'comentarios' => null, 'mesesConstruida' => null, 'anosConstruida' => null, 'depositoAdelanto' => null, 'latitudMapa' => null, 'longitudMapa' => null, 'zoomMapa' => null, 
		#Maximo 5 Imagenes
		'urlImagenes' => null 
    );
	
    /**
    * Opciones permitidas por Parqueadero o Garaje
    * @var array 
    */
    public static $OPCIONES_PARQUEADERO_GARAJE = array (
		#Obligatorios
		'id' => null, 'departamento' => null, 'ciudad' => null, 'barrio' => null, 'precio' => null, 'estadoActual' => null, 'titulo' => null, 'descripcion' => null, 
		#Opcionales
		'direccion' => null, 'areaTotal' => null, 'numerodeParquederosGarajes' => null,'negociable' => null, 'comentarios' => null, 'mesesConstruida' => null, 'anosConstruida' => null, 'depositoAdelanto' => null, 'latitudMapa' => null, 'longitudMapa' => null, 'zoomMapa' => null, 
		#Maximo 5 Imagenes
		'urlImagenes' => null 
    );
	
    /**
      * Inicializa el API Realstaters
      *
      * Configuracion:
      * - apiKey: the API Key ID
	  *
      * @param string $apiKey API Key del usuario
   	  */
	public function __construct($apiKey = false) {
		$this->realstaters = ($apiKey) ? new Realstaters ( array ('apiKey' => $apiKey ), 'POST' ) : false;
	}
	
	/**
	 * Evita que el anuncio se cree y retorna los datos como llegan al servidor
	 * @param boolean $opcion
	 */
	public function test($test = false) {
		if ($test === true) {
			$this->realstaters->test = array ( 'test' => $test );
		}
	}

	/**
	 * Activa un Anuncio Desactivado
	 * @param integer $id id Anuncio a activar
	 * @return boolean
	 */
	public function activar($id = null) {
		if ($id) {
			$tipo = 'activar';
			$this->realstaters->setMethod('PUT');
			$this->realstaters->setData ( compact ( 'id', 'tipo' ) );
			if ($this->realstaters->makeRequest ()) {
				return $this->realstaters->getResponseData ();
			}
		}
		return false;
	}
	
	/**
	 * Desactiva un Anuncio Activado
	 * @param integer $id id Anuncio a desactivar
	 * @return boolean
	 */
	public function desactivar($id = null) {
		if ($id) {
			$tipo = 'desactivar';
			$this->realstaters->setMethod('PUT');
			$this->realstaters->setData ( compact ( 'id', 'tipo' ) );
			if ($this->realstaters->makeRequest ()) {
				return $this->realstaters->getResponseData ();
			}
		}
		return false;
	}
	
	/**
	 * Borra un Anuncio
	 * @param integer $id id Anuncio a borrar
	 * @return boolean
	 */
	public function borrar($id = null) {
		if ($id) {
			$tipo = 'borrar';
			$this->realstaters->setMethod('DELETE');
			$this->realstaters->setData ( compact ( 'id', 'tipo' ) );
			if ($this->realstaters->makeRequest ()) {
				return $this->realstaters->getResponseData ();
			}
		}
		return false;
	}
	
	/**
	 * Organiza los parametros para publicar un Apartaestudio
	 * @param string $amobladoPropiedad total, parcial, no
	 * @param integer $anosConstruida
	 * @param integer $areaHabitacion
	 * @param integer $areaTotal
	 * @param integer $banos
	 * @param string $barrio
	 * @param string $ciudad
	 * @param string $cobroAlquiler dias, semana, quincena, mes
	 * @param boolean $comentarios
	 * @param string $departamento
	 * @param string $depositoAdelanto 15 dias, 1 semana,1 mes, 2 meses, 3 meses, no es requerido, negociable
	 * @param string $descripcion
	 * @param string $direccion
	 * @param array $estadoActual adecuado, abandonado, buen estado, planos, sin adecuar, nuevo, obra negra, excelente, regular
	 * @param integer $estrato
	 * @param integer $habitaciones
	 * @param integer $habitacionesDisponibles
	 * @param integer $id para editar el anuncio debe incluirse el id
	 * @param string $latitudMapa
	 * @param integer $lineasTelefonicas
	 * @param string $longitudMapa
	 * @param integer $mesesConstruida
	 * @param boolean $negociable
	 * @param integer $parqueaderosPrivados
	 * @param integer $pisos
	 * @param string $precio
	 * @param string $tiempoMaxEstadia
	 * @param string $tiempoMinEstadia
	 * @param string $titulo
	 * @param array $urlImagenes Maximo 5 Imagenes
	 * @param integer $zoomMapa
	 * @param string $tipo venta, alquiler...
	 * @param string $propiedad Especifica el tipo de propiedad a publicar, apartaestudio
	 * @return boolean
	 */
	protected function apartaestudio($amobladoPropiedad = null, $anosConstruida = null, $areaHabitacion = null, $areaTotal = null, $banos = null, $barrio = null, $ciudad = null, $cobroAlquiler = null, $comentarios = null, $departamento = null, $depositoAdelanto = null, $descripcion = null, $direccion = null, $estadoActual = null, $estrato = null, $habitaciones = null, $habitacionesDisponibles = null, $id = null, $latitudMapa = null, $lineasTelefonicas = null, $longitudMapa = null, $mesesConstruida = null, $negociable = null, $parqueaderosPrivados = null, $pisos = null, $precio = null, $tiempoMaxEstadia = null, $tiempoMinEstadia = null, $titulo = null, $urlImagenes = null, $zoomMapa = null, $tipo = null, $propiedad = null) {
		if ($estrato && $departamento && $ciudad && $barrio && $precio && $estadoActual && $titulo && $descripcion && $tipo && $propiedad) {
			// Para Actualizaciones
			if ($id) {
				$this->realstaters->setMethod('PUT');
			}
			$this->realstaters->setData ( compact ( 'amobladoPropiedad', 'anosConstruida', 'areaHabitacion', 'areaTotal', 'banos', 'barrio', 'ciudad', 'cobroAlquiler', 'comentarios', 'departamento', 'depositoAdelanto', 'descripcion', 'direccion', 'estadoActual', 'estrato', 'habitaciones', 'habitacionesDisponibles', 'id', 'latitudMapa', 'lineasTelefonicas', 'longitudMapa', 'mesesConstruida', 'negociable', 'parqueaderosPrivados', 'pisos', 'precio', 'tiempoMaxEstadia', 'tiempoMinEstadia', 'titulo', 'urlImagenes', 'zoomMapa', 'tipo', 'propiedad' ) );
			if ($this->realstaters->makeRequest ()) {
				return $this->realstaters->getResponseData ();
			}
		}
		return false;
	}
	
	/**
	 * Organiza los parametros para publicar un Apartamento
	 * @param string $amobladoPropiedad total, parcial, no
	 * @param integer $anosConstruida
	 * @param integer $areaHabitacion
	 * @param integer $areaTotal
	 * @param integer $banos
	 * @param string $barrio
	 * @param string $ciudad
	 * @param string $cobroAlquiler dias, semana, quincena, mes
	 * @param boolean $comentarios
	 * @param string $departamento
	 * @param string $depositoAdelanto 15 dias, 1 semana,1 mes, 2 meses, 3 meses, no es requerido, negociable
	 * @param string $descripcion
	 * @param string $direccion
	 * @param array $estadoActual adecuado, abandonado, buen estado, planos, sin adecuar, nuevo, obra negra, excelente, regular
	 * @param integer $estrato
	 * @param integer $habitaciones
	 * @param integer $habitacionesDisponibles
	 * @param integer $id para editar el anuncio debe incluirse el id
	 * @param string $latitudMapa
	 * @param integer $lineasTelefonicas
	 * @param string $longitudMapa
	 * @param integer $mesesConstruida
	 * @param boolean $negociable
	 * @param integer $parqueaderosPrivados
	 * @param string $penthouse
	 * @param integer $pisos
	 * @param string $precio
	 * @param string $tiempoMaxEstadia
	 * @param string $tiempoMinEstadia
	 * @param string $titulo
	 * @param array $urlImagenes Maximo 5 Imagenes
	 * @param integer $zoomMapa
	 * @param string $tipo venta, alquiler...
	 * @param string $propiedad Especifica el tipo de propiedad a publicar, apartamento
	 * @return boolean
	 */
	protected function apartamento($amobladoPropiedad = null, $anosConstruida = null, $areaHabitacion = null, $areaTotal = null, $banos = null, $barrio = null, $ciudad = null, $cobroAlquiler = null, $comentarios = null, $departamento = null, $depositoAdelanto = null, $descripcion = null, $direccion = null, $estadoActual = null, $estrato = null, $habitaciones = null, $habitacionesDisponibles = null, $id = null, $latitudMapa = null, $lineasTelefonicas = null, $longitudMapa = null, $mesesConstruida = null, $negociable = null, $parqueaderosPrivados = null, $penthouse = null, $pisos = null, $precio = null, $tiempoMaxEstadia = null, $tiempoMinEstadia = null, $titulo = null, $urlImagenes = null, $zoomMapa = null, $tipo = null, $propiedad = null) {
		if ($estrato && $departamento && $ciudad && $barrio && $precio && $estadoActual && $titulo && $descripcion && $tipo && $propiedad) {
			// Para Actualizaciones
			if ($id) {
				$this->realstaters->setMethod('PUT');
			}
			$this->realstaters->setData ( compact ( 'amobladoPropiedad', 'anosConstruida', 'areaHabitacion', 'areaTotal', 'banos', 'barrio', 'ciudad', 'cobroAlquiler', 'comentarios', 'departamento', 'depositoAdelanto', 'descripcion', 'direccion', 'estadoActual', 'estrato', 'habitaciones', 'habitacionesDisponibles', 'id', 'latitudMapa', 'lineasTelefonicas', 'longitudMapa', 'mesesConstruida', 'negociable', 'parqueaderosPrivados', 'penthouse', 'pisos', 'precio', 'tiempoMaxEstadia', 'tiempoMinEstadia', 'titulo', 'urlImagenes', 'zoomMapa', 'tipo', 'propiedad' ) );
			if ($this->realstaters->makeRequest ()) {
				return $this->realstaters->getResponseData ();
			}
		}
		return false;
	}
	
	/**
	 * Organiza los parametros para publicar una Bodega
	 * @param integer $anosConstruida
	 * @param integer $areaConstruida
	 * @param integer $areaTotal
	 * @param string $barrio
	 * @param string $ciudad
	 * @param boolean $comentarios
	 * @param string $departamento
	 * @param string $depositoAdelanto 15 dias, 1 semana,1 mes, 2 meses, 3 meses, no es requerido, negociable
	 * @param string $descripcion
	 * @param string $direccion
	 * @param array $estadoActual adecuado, abandonado, buen estado, planos, sin adecuar, nuevo, obra negra, excelente, regular
	 * @param integer $estrato
	 * @param integer $id para editar el anuncio debe incluirse el id
	 * @param string $latitudMapa
	 * @param string $longitudMapa
	 * @param integer $mesesConstruida
	 * @param boolean $negociable
	 * @param array $otrasDimensiones Maximo 5 Dimensiones
	 * @param string $precio
	 * @param string $titulo
	 * @param array $urlImagenes Maximo 5 Imagenes
	 * @param integer $zoomMapa
	 * @param string $tipo venta, alquiler...
	 * @param string $propiedad Especifica el tipo de propiedad a publicar, bodega
	 * @return boolean
	 */
	protected function bodega($anosConstruida = null, $areaConstruida = null, $areaTotal = null, $barrio = null, $ciudad = null, $comentarios = null, $departamento = null, $depositoAdelanto = null, $descripcion = null, $direccion = null, $estadoActual = null, $estrato = null, $id = null, $latitudMapa = null, $longitudMapa = null, $mesesConstruida = null, $negociable = null, $otrasDimensiones = null, $precio = null, $titulo = null, $urlImagenes = null, $zoomMapa = null, $tipo = null, $propiedad = null) {
		if ($estrato && $departamento && $ciudad && $barrio && $precio && $estadoActual && $titulo && $descripcion && $tipo && $propiedad) {
			// Para Actualizaciones
			if ($id) {
				$this->realstaters->setMethod('PUT');
			}
			
			if (is_array ( $otrasDimensiones )) {
				foreach ( $otrasDimensiones as $otraDimension ) {
					if (count ( $otraDimension ) == 4) {
						if (! array_key_exists ( 'Altura', $otraDimension ) || ! array_key_exists ( 'AreaOficinas', $otraDimension ) || ! array_key_exists ( 'AltoPuertaAcceso', $otraDimension ) || ! array_key_exists ( 'AnchoPuertaAcceso', $otraDimension )) {
							return false;
						}
					} else {
						return false;
					}
				}
			}
			$this->realstaters->setData ( compact ( 'anosConstruida', 'areaConstruida', 'areaTotal', 'barrio', 'ciudad', 'comentarios', 'departamento', 'depositoAdelanto', 'descripcion', 'direccion', 'estadoActual', 'estrato', 'id', 'latitudMapa', 'longitudMapa', 'mesesConstruida', 'negociable', 'otrasDimensiones', 'precio', 'titulo', 'urlImagenes', 'zoomMapa', 'tipo', 'propiedad' ) );
			if ($this->realstaters->makeRequest ()) {
				return $this->realstaters->getResponseData ();
			}
		}
		return false;
	}
	
	/**
	 * Organiza los parametros para publicar una Casa, Casa Campestre, Hotel, Hostal, Hospedaje
	 * @param string $amobladoPropiedad total, parcial, no
	 * @param integer $anosConstruida
	 * @param integer $areaConstruida
	 * @param integer $areaHabitacion
	 * @param integer $areaTotal
	 * @param integer $banos
	 * @param string $barrio
	 * @param string $ciudad
	 * @param string $cobroAlquiler dias, semana, quincena, mes
	 * @param boolean $comentarios
	 * @param string $departamento
	 * @param string $depositoAdelanto 15 dias, 1 semana,1 mes, 2 meses, 3 meses, no es requerido, negociable
	 * @param string $descripcion
	 * @param string $direccion
	 * @param array $estadoActual adecuado, abandonado, buen estado, planos, sin adecuar, nuevo, obra negra, excelente, regular
	 * @param integer $estrato
	 * @param integer $habitaciones
	 * @param integer $habitacionesDisponibles
	 * @param integer $id para editar el anuncio debe incluirse el id
	 * @param string $latitudMapa
	 * @param integer $lineasTelefonicas
	 * @param string $longitudMapa
	 * @param integer $mesesConstruida
	 * @param boolean $negociable
	 * @param integer $parqueaderosPrivados
	 * @param integer $pisos
	 * @param string $precio
	 * @param string $tiempoMaxEstadia
	 * @param string $tiempoMinEstadia
	 * @param string $titulo
	 * @param array $urlImagenes Maximo 5 Imagenes
	 * @param integer $zoomMapa
	 * @param string $tipo venta, alquiler...
	 * @param string $propiedad Especifica el tipo de propiedad a publicar, casa, casa campestre, hote, hostal, hospedaje
	 * @return boolean
	 */
	protected function casa($amobladoPropiedad = null, $anosConstruida = null, $areaConstruida = null, $areaHabitacion = null, $areaTotal = null, $banos = null, $barrio = null, $ciudad = null, $cobroAlquiler = null, $comentarios = null, $departamento = null, $depositoAdelanto = null, $descripcion = null, $direccion = null, $estadoActual = null, $estrato = null, $habitaciones = null, $habitacionesDisponibles = null, $id = null, $latitudMapa = null, $lineasTelefonicas = null, $longitudMapa = null, $mesesConstruida = null, $negociable = null, $parqueaderosPrivados = null, $pisos = null, $precio = null, $tiempoMaxEstadia = null, $tiempoMinEstadia = null, $titulo = null, $urlImagenes = null, $zoomMapa = null, $tipo = null, $propiedad = null) {
		if ($estrato && $departamento && $ciudad && $barrio && $precio && $estadoActual && $titulo && $descripcion && $tipo && $propiedad) {
			// Para Actualizaciones
			if ($id) {
				$this->realstaters->setMethod('PUT');
			}
			$this->realstaters->setData ( compact ( 'amobladoPropiedad', 'anosConstruida', 'areaConstruida', 'areaHabitacion', 'areaTotal', 'banos', 'barrio', 'ciudad', 'cobroAlquiler', 'comentarios', 'departamento', 'depositoAdelanto', 'descripcion', 'direccion', 'estadoActual', 'estrato', 'habitaciones', 'habitacionesDisponibles', 'id', 'latitudMapa', 'lineasTelefonicas', 'longitudMapa', 'mesesConstruida', 'negociable', 'parqueaderosPrivados', 'pisos', 'precio', 'tiempoMaxEstadia', 'tiempoMinEstadia', 'titulo', 'urlImagenes', 'zoomMapa', 'tipo', 'propiedad' ) );
			if ($this->realstaters->makeRequest ()) {
				return $this->realstaters->getResponseData ();
			}
		}
		return false;
	}
	
	/**
	 * Organiza los parametros para publicar un Condominio o Unidad Residencial
	 * @param integer $anosConstruida
	 * @param integer $areaPorResidencia
	 * @param integer $areaTotal
	 * @param string $barrio
	 * @param string $ciudad
	 * @param boolean $comentarios
	 * @param string $departamento
	 * @param string $depositoAdelanto 15 dias, 1 semana,1 mes, 2 meses, 3 meses, no es requerido, negociable
	 * @param string $descripcion
	 * @param string $direccion
	 * @param array $estadoActual adecuado, abandonado, buen estado, planos, sin adecuar, nuevo, obra negra, excelente, regular
	 * @param integer $estrato
	 * @param integer $id para editar el anuncio debe incluirse el id
	 * @param string $latitudMapa
	 * @param string $longitudMapa
	 * @param integer $mesesConstruida
	 * @param boolean $negociable
	 * @param string $numeroResidencias
	 * @param string $precio
	 * @param string $titulo
	 * @param array $urlImagenes Maximo 5 Imagenes
	 * @param integer $zoomMapa
	 * @param string $tipo venta, alquiler...
	 * @param string $propiedad Especifica el tipo de propiedad a publicar, condominio_unidadresidencial
	 * @return boolean
	 */
	protected function condominio_unidadresidencial($anosConstruida = null, $areaPorResidencia = null, $areaTotal = null, $barrio = null, $ciudad = null, $comentarios = null, $departamento = null, $depositoAdelanto = null, $descripcion = null, $direccion = null, $estadoActual = null, $estrato = null, $id = null, $latitudMapa = null, $longitudMapa = null, $mesesConstruida = null, $negociable = null, $numeroResidencias = null, $precio = null, $titulo = null, $urlImagenes = null, $zoomMapa = null, $tipo = null, $propiedad = null) {
		if ($estrato && $departamento && $ciudad && $barrio && $precio && $estadoActual && $titulo && $descripcion && $tipo && $propiedad) {
			// Para Actualizaciones
			if ($id) {
				$this->realstaters->setMethod('PUT');
			}
			$this->realstaters->setData ( compact ( 'anosConstruida', 'areaPorResidencia', 'areaTotal', 'barrio', 'ciudad', 'comentarios', 'departamento', 'depositoAdelanto', 'descripcion', 'direccion', 'estadoActual', 'estrato', 'id', 'latitudMapa', 'longitudMapa', 'mesesConstruida', 'negociable', 'numeroResidencias', 'precio', 'titulo', 'urlImagenes', 'zoomMapa', 'tipo', 'propiedad' ) );
			if ($this->realstaters->makeRequest ()) {
				return $this->realstaters->getResponseData ();
			}
		}
		return false;
	}
	
	/**
	 * Organiza los parametros para publicar un Edificio
	 * @param integer $anosConstruida
	 * @param integer $areaPorApartamento
	 * @param integer $areaTotal
	 * @param string $barrio
	 * @param string $ciudad
	 * @param boolean $comentarios
	 * @param string $departamento
	 * @param string $depositoAdelanto 15 dias, 1 semana,1 mes, 2 meses, 3 meses, no es requerido, negociable
	 * @param string $descripcion
	 * @param string $direccion
	 * @param array $estadoActual adecuado, abandonado, buen estado, planos, sin adecuar, nuevo, obra negra, excelente, regular
	 * @param integer $estrato
	 * @param integer $id para editar el anuncio debe incluirse el id
	 * @param string $latitudMapa
	 * @param string $longitudMapa
	 * @param integer $mesesConstruida
	 * @param boolean $negociable
	 * @param string $numeroApartamentos
	 * @param string $precio
	 * @param string $titulo
	 * @param array $urlImagenes Maximo 5 Imagenes
	 * @param integer $zoomMapa
	 * @param string $tipo venta, alquiler...
	 * @param string $propiedad Especifica el tipo de propiedad a publicar, edificio
	 * @return boolean
	 */
	protected function edificio($anosConstruida = null, $areaPorApartamento = null, $areaTotal = null, $barrio = null, $ciudad = null, $comentarios = null, $departamento = null, $depositoAdelanto = null, $descripcion = null, $direccion = null, $estadoActual = null, $estrato = null, $id = null, $latitudMapa = null, $longitudMapa = null, $mesesConstruida = null, $negociable = null, $numeroApartamentos = null, $precio = null, $titulo = null, $urlImagenes = null, $zoomMapa = null, $tipo = null, $propiedad = null) {
		if ($estrato && $departamento && $ciudad && $barrio && $precio && $estadoActual && $titulo && $descripcion && $tipo && $propiedad) {
			// Para Actualizaciones
			if ($id) {
				$this->realstaters->setMethod('PUT');
			}
			$this->realstaters->setData ( compact ( 'anosConstruida', 'areaPorApartamento', 'areaTotal', 'barrio', 'ciudad', 'comentarios', 'departamento', 'depositoAdelanto', 'descripcion', 'direccion', 'estadoActual', 'estrato', 'id', 'latitudMapa', 'longitudMapa', 'mesesConstruida', 'negociable', 'numeroApartamentos', 'precio', 'titulo', 'urlImagenes', 'zoomMapa', 'tipo', 'propiedad' ) );
			if ($this->realstaters->makeRequest ()) {
				return $this->realstaters->getResponseData ();
			}
		}
		return false;
	}
	
	/**
	 * Organiza los parametros para publicar una Finca
	 * @param string $amobladoPropiedad total, parcial, no
	 * @param integer $anosConstruida
	 * @param integer $areaConstruida
	 * @param integer $areaHabitacion
	 * @param integer $areaTotal
	 * @param integer $banos
	 * @param string $ciudad
	 * @param string $cobroAlquiler dias, semana, quincena, mes
	 * @param boolean $comentarios
	 * @param string $departamento
	 * @param string $depositoAdelanto 15 dias, 1 semana,1 mes, 2 meses, 3 meses, no es requerido, negociable
	 * @param string $descripcion
	 * @param string $direccion
	 * @param array $estadoActual adecuado, abandonado, buen estado, planos, sin adecuar, nuevo, obra negra, excelente, regular
	 * @param integer $habitaciones
	 * @param integer $habitacionesDisponibles
	 * @param integer $id para editar el anuncio debe incluirse el id
	 * @param string $latitudMapa
	 * @param integer $lineasTelefonicas
	 * @param string $longitudMapa
	 * @param integer $mesesConstruida
	 * @param boolean $negociable
	 * @param integer $parqueaderosPrivados
	 * @param integer $pisos
	 * @param string $precio
	 * @param string $tiempoMaxEstadia
	 * @param string $tiempoMinEstadia
	 * @param string $titulo
	 * @param array $urlImagenes Maximo 5 Imagenes
	 * @param integer $zoomMapa
	 * @param string $tipo venta, alquiler...
	 * @param string $propiedad Especifica el tipo de propiedad a publicar, finca
	 * @return boolean
	 */
	protected function finca($amobladoPropiedad = null, $anosConstruida = null, $areaConstruida = null, $areaHabitacion = null, $areaTotal = null, $banos = null, $ciudad = null, $cobroAlquiler = null, $comentarios = null, $departamento = null, $depositoAdelanto = null, $descripcion = null, $direccion = null, $estadoActual = null, $habitaciones = null, $habitacionesDisponibles = null, $id = null, $latitudMapa = null, $lineasTelefonicas = null, $longitudMapa = null, $mesesConstruida = null, $negociable = null, $parqueaderosPrivados = null, $pisos = null, $precio = null, $tiempoMaxEstadia = null, $tiempoMinEstadia = null, $titulo = null, $urlImagenes = null, $zoomMapa = null, $tipo = null, $propiedad = null) {
		if ($departamento && $ciudad && $precio && $estadoActual && $titulo && $descripcion && $tipo && $propiedad) {
			// Para Actualizaciones
			if ($id) {
				$this->realstaters->setMethod('PUT');
			}
			$this->realstaters->setData ( compact ( 'amobladoPropiedad', 'anosConstruida', 'areaConstruida', 'areaHabitacion', 'areaTotal', 'banos', 'ciudad', 'cobroAlquiler', 'comentarios', 'departamento', 'depositoAdelanto', 'descripcion', 'direccion', 'estadoActual', 'habitaciones', 'habitacionesDisponibles', 'id', 'latitudMapa', 'lineasTelefonicas', 'longitudMapa', 'mesesConstruida', 'negociable', 'parqueaderosPrivados', 'pisos', 'precio', 'tiempoMaxEstadia', 'tiempoMinEstadia', 'titulo', 'urlImagenes', 'zoomMapa', 'tipo', 'propiedad' ) );
			if ($this->realstaters->makeRequest ()) {
				return $this->realstaters->getResponseData ();
			}
		}
		return false;
	}
	
	/**
	 * Organiza los parametros para publicar una Franquicia
	 * @param integer $anosConstruida
	 * @param string $barrio
	 * @param string $ciudad
	 * @param boolean $comentarios
	 * @param string $departamento
	 * @param string $depositoAdelanto 15 dias, 1 semana,1 mes, 2 meses, 3 meses, no es requerido, negociable
	 * @param string $descripcion
	 * @param string $direccion
	 * @param array $estadoActual adecuado, abandonado, buen estado, planos, sin adecuar, nuevo, obra negra, excelente, regular
	 * @param integer $id para editar el anuncio debe incluirse el id
	 * @param string $latitudMapa
	 * @param string $longitudMapa
	 * @param integer $mesesConstruida
	 * @param boolean $negociable
	 * @param string $precio
	 * @param string $productoOServicio
	 * @param string $titulo
	 * @param array $urlImagenes Maximo 5 Imagenes
	 * @param integer $zoomMapa
	 * @param string $tipo venta, alquiler...
	 * @param string $propiedad Especifica el tipo de propiedad a publicar, franquicia
	 * @return boolean
	 */
	protected function franquicia($anosConstruida = null, $barrio = null, $ciudad = null, $comentarios = null, $departamento = null, $depositoAdelanto = null, $descripcion = null, $direccion = null, $estadoActual = null, $id = null, $latitudMapa = null, $longitudMapa = null, $mesesConstruida = null, $negociable = null, $precio = null, $productoOServicio = null, $titulo = null, $urlImagenes = null, $zoomMapa = null, $tipo = null, $propiedad = null) {
		if ($departamento && $ciudad && $barrio && $precio && $estadoActual && $titulo && $descripcion && $tipo && $propiedad) {
			// Para Actualizaciones
			if ($id) {
				$this->realstaters->setMethod('PUT');
			}
			$this->realstaters->setData ( compact ( 'anosConstruida', 'barrio', 'ciudad', 'comentarios', 'departamento', 'depositoAdelanto', 'descripcion', 'direccion', 'estadoActual', 'id', 'latitudMapa', 'longitudMapa', 'mesesConstruida', 'negociable', 'precio', 'productoOServicio', 'titulo', 'urlImagenes', 'zoomMapa', 'tipo', 'propiedad' ) );
			if ($this->realstaters->makeRequest ()) {
				return $this->realstaters->getResponseData ();
			}
		}
		return false;
	}
	
	/**
	 * Organiza los parametros para publicar un Local Comercial, Prima Local Comercial, Oficina, Prima oficina, Consultorio, Prima Consultorio
	 * @param integer $anosConstruida
	 * @param integer $areaTotal
	 * @param integer $banos
	 * @param string $barrio
	 * @param string $ciudad
	 * @param boolean $comentarios
	 * @param string $departamento
	 * @param string $depositoAdelanto 15 dias, 1 semana,1 mes, 2 meses, 3 meses, no es requerido, negociable
	 * @param string $descripcion
	 * @param string $direccion
	 * @param array $estadoActual adecuado, abandonado, buen estado, planos, sin adecuar, nuevo, obra negra, excelente, regular
	 * @param integer $estrato
	 * @param integer $id para editar el anuncio debe incluirse el id
	 * @param string $latitudMapa
	 * @param string $longitudMapa
	 * @param integer $mesesConstruida
	 * @param boolean $negociable
	 * @param string $nombreCentroComercial
	 * @param integer $parqueaderosPrivados
	 * @param integer $pisos
	 * @param string $precio
	 * @param string $titulo
	 * @param array $urlImagenes Maximo 5 Imagenes
	 * @param integer $zoomMapa
	 * @param string $tipo venta, alquiler...
	 * @param string $propiedad Especifica el tipo de propiedad a publicar, localcomercial, primalocalcomercial, oficina, primaoficina, consultorio, primaconsultorio
	 * @return boolean
	 */
	protected function localcomercial($anosConstruida = null, $areaTotal = null, $banos = null, $barrio = null, $ciudad = null, $comentarios = null, $departamento = null, $depositoAdelanto = null, $descripcion = null, $direccion = null, $estadoActual = null, $estrato = null, $id = null, $latitudMapa = null, $longitudMapa = null, $mesesConstruida = null, $negociable = null, $nombreCentroComercial = null, $parqueaderosPrivados = null, $pisos = null, $precio = null, $titulo = null, $urlImagenes = null, $zoomMapa = null, $tipo = null, $propiedad = null) {
		if ($estrato && $departamento && $ciudad && $barrio && $precio && $estadoActual && $titulo && $descripcion && $tipo && $propiedad) {
			// Para Actualizaciones
			if ($id) {
				$this->realstaters->setMethod('PUT');
			}
			$this->realstaters->setData ( compact ( 'anosConstruida', 'areaConstruida', 'areaTotal', 'banos', 'barrio', 'ciudad', 'comentarios', 'departamento', 'depositoAdelanto', 'descripcion', 'direccion', 'estadoActual', 'estrato', 'id', 'latitudMapa', 'longitudMapa', 'mesesConstruida', 'negociable', 'nombreCentroComercial', 'parqueaderosPrivados', 'pisos', 'precio', 'titulo', 'urlImagenes', 'zoomMapa', 'tipo', 'propiedad' ) );
			if ($this->realstaters->makeRequest ()) {
				return $this->realstaters->getResponseData ();
			}
		}
		return false;
	}
	
	/**
	 * Organiza los parametros para publicar un Lote
	 * @param integer $anosConstruida
	 * @param integer $areaTotal
	 * @param string $barrio
	 * @param string $ciudad
	 * @param boolean $comentarios
	 * @param string $departamento
	 * @param string $depositoAdelanto 15 dias, 1 semana,1 mes, 2 meses, 3 meses, no es requerido, negociable
	 * @param string $descripcion
	 * @param string $direccion
	 * @param array $estadoActual adecuado, abandonado, buen estado, planos, sin adecuar, nuevo, obra negra, excelente, regular
	 * @param integer $estrato
	 * @param integer $id para editar el anuncio debe incluirse el id
	 * @param string $latitudMapa
	 * @param string $longitudMapa
	 * @param integer $mesesConstruida
	 * @param boolean $negociable
	 * @param string $precio
	 * @param string $titulo
	 * @param array $urlImagenes Maximo 5 Imagenes
	 * @param integer $zoomMapa
	 * @param string $tipo venta, alquiler...
	 * @param string $propiedad Especifica el tipo de propiedad a publicar, lote
	 * @return boolean
	 */
	protected function lote($anosConstruida = null, $areaTotal = null, $barrio = null, $ciudad = null, $comentarios = null, $departamento = null, $depositoAdelanto = null, $descripcion = null, $direccion = null, $estadoActual = null, $estrato = null, $id = null, $latitudMapa = null, $longitudMapa = null, $mesesConstruida = null, $negociable = null, $precio = null, $titulo = null, $urlImagenes = null, $zoomMapa = null, $tipo = null, $propiedad = null) {
		if ($estrato && $departamento && $ciudad && $barrio && $precio && $estadoActual && $titulo && $descripcion && $tipo && $propiedad) {
			// Para Actualizaciones
			if ($id) {
				$this->realstaters->setMethod('PUT');
			}
			$this->realstaters->setData ( compact ( 'anosConstruida', 'areaTotal', 'barrio', 'ciudad', 'comentarios', 'departamento', 'depositoAdelanto', 'descripcion', 'direccion', 'estadoActual', 'estrato', 'id', 'latitudMapa', 'longitudMapa', 'mesesConstruida', 'negociable', 'precio', 'titulo', 'urlImagenes', 'zoomMapa', 'tipo', 'propiedad' ) );
			if ($this->realstaters->makeRequest ()) {
				return $this->realstaters->getResponseData ();
			}
		}
		return false;
	}
	
	/**
	 * Organiza los parametros para publicar un Lote Funebre
	 * @param integer $anosConstruida
	 * @param string $ciudad
	 * @param boolean $comentarios
	 * @param string $departamento
	 * @param string $depositoAdelanto 15 dias, 1 semana,1 mes, 2 meses, 3 meses, no es requerido, negociable
	 * @param string $descripcion
	 * @param integer $estrato
	 * @param integer $id para editar el anuncio debe incluirse el id
	 * @param string $latitudMapa
	 * @param string $longitudMapa
	 * @param integer $mesesConstruida
	 * @param boolean $negociable
	 * @param string $nombreCementerio
	 * @param string $precio
	 * @param string $titulo
	 * @param array $urlImagenes Maximo 5 Imagenes
	 * @param integer $zoomMapa
	 * @param string $tipo venta, alquiler...
	 * @param string $propiedad Especifica el tipo de propiedad a publicar, lote funebre
	 * @return boolean
	 */
	protected function lotefunebre($anosConstruida = null, $ciudad = null, $comentarios = null, $departamento = null, $depositoAdelanto = null, $descripcion = null, $estrato = null, $id = null, $latitudMapa = null, $longitudMapa = null, $mesesConstruida = null, $negociable = null, $nombreCementerio = null, $precio = null, $titulo = null, $urlImagenes = null, $zoomMapa = null, $tipo = null, $propiedad = null) {
		if ($departamento && $ciudad && $precio && $titulo && $descripcion && $tipo && $propiedad) {
			// Para Actualizaciones
			if ($id) {
				$this->realstaters->setMethod('PUT');
			}
			$this->realstaters->setData ( compact ( 'anosConstruida', 'ciudad', 'comentarios', 'departamento', 'depositoAdelanto', 'descripcion', 'estrato', 'id', 'latitudMapa', 'longitudMapa', 'mesesConstruida', 'negociable', 'nombreCementerio', 'precio', 'titulo', 'urlImagenes', 'zoomMapa', 'tipo', 'propiedad' ) );
			if ($this->realstaters->makeRequest ()) {
				return $this->realstaters->getResponseData ();
			}
		}
		return false;
	}
	
	/**
	 * Organiza los parametros para publicar una Parcelacion
	 * @param integer $anosConstruida
	 * @param integer $areaConstruida
	 * @param integer $areaTotal
	 * @param string $barrio
	 * @param string $ciudad
	 * @param boolean $comentarios
	 * @param string $departamento
	 * @param string $depositoAdelanto 15 dias, 1 semana,1 mes, 2 meses, 3 meses, no es requerido, negociable
	 * @param string $descripcion
	 * @param string $direccion
	 * @param array $estadoActual adecuado, abandonado, buen estado, planos, sin adecuar, nuevo, obra negra, excelente, regular
	 * @param integer $estrato
	 * @param integer $id para editar el anuncio debe incluirse el id
	 * @param string $latitudMapa
	 * @param string $longitudMapa
	 * @param integer $mesesConstruida
	 * @param boolean $negociable
	 * @param string $numerodeLotes
	 * @param string $precio
	 * @param string $titulo
	 * @param array $urlImagenes Maximo 5 Imagenes
	 * @param integer $zoomMapa
	 * @param string $tipo venta, alquiler...
	 * @param string $propiedad Especifica el tipo de propiedad a publicar
	 * @return boolean
	 */
	protected function parcelacion($anosConstruida = null, $areaConstruida = null, $areaTotal = null, $barrio = null, $ciudad = null, $comentarios = null, $departamento = null, $depositoAdelanto = null, $descripcion = null, $direccion = null, $estadoActual = null, $estrato = null, $id = null, $latitudMapa = null, $longitudMapa = null, $mesesConstruida = null, $negociable = null, $numerodeLotes = null, $precio = null, $titulo = null, $urlImagenes = null, $zoomMapa = null, $tipo = null, $propiedad = null) {
		if ($estrato && $departamento && $ciudad && $barrio && $precio && $estadoActual && $titulo && $descripcion && $tipo && $propiedad) {
			// Para Actualizaciones
			if ($id) {
				$this->realstaters->setMethod('PUT');
			}
			$this->realstaters->setData ( compact ( 'anosConstruida', 'areaTotal', 'areaConstruida', 'barrio', 'ciudad', 'comentarios', 'departamento', 'depositoAdelanto', 'descripcion', 'direccion', 'estadoActual', 'estrato', 'id', 'latitudMapa', 'longitudMapa', 'mesesConstruida', 'negociable', 'numerodeLotes', 'precio', 'titulo', 'urlImagenes', 'zoomMapa', 'tipo', 'propiedad' ) );
			if ($this->realstaters->makeRequest ()) {
				return $this->realstaters->getResponseData ();
			}
		}
		return false;
	}
	
	/**
	 * Organiza los parametros para publicar un Parquedero o Garaje
	 * @param integer $anosConstruida
	 * @param integer $areaTotal
	 * @param string $barrio
	 * @param string $ciudad
	 * @param boolean $comentarios
	 * @param string $departamento
	 * @param string $depositoAdelanto 15 dias, 1 semana,1 mes, 2 meses, 3 meses, no es requerido, negociable
	 * @param string $descripcion
	 * @param string $direccion
	 * @param array $estadoActual adecuado, abandonado, buen estado, planos, sin adecuar, nuevo, obra negra, excelente, regular
	 * @param integer $id para editar el anuncio debe incluirse el id
	 * @param string $latitudMapa
	 * @param string $longitudMapa
	 * @param integer $mesesConstruida
	 * @param boolean $negociable
	 * @param string $numerodeParquederosGarajes
	 * @param string $precio
	 * @param string $titulo
	 * @param array $urlImagenes Maximo 5 Imagenes
	 * @param integer $zoomMapa
	 * @param string $tipo venta, alquiler...
	 * @param string $propiedad Especifica el tipo de propiedad a publicar, parqueadero_garaje
	 * @return boolean
	 */
	protected function parqueadero_garaje($anosConstruida = null, $areaTotal = null, $barrio = null, $ciudad = null, $comentarios = null, $departamento = null, $depositoAdelanto = null, $descripcion = null, $direccion = null, $estadoActual = null, $id = null, $latitudMapa = null, $longitudMapa = null, $mesesConstruida = null, $negociable = null, $numerodeParquederosGarajes = null, $precio = null, $titulo = null, $urlImagenes = null, $zoomMapa = null, $tipo = null, $propiedad = null) {
		if ($departamento && $ciudad && $barrio && $precio && $estadoActual && $titulo && $descripcion && $tipo && $propiedad) {
			// Para Actualizaciones
			if ($id) {
				$this->realstaters->setMethod('PUT');
			}
			$this->realstaters->setData ( compact ( 'anosConstruida', 'areaTotal', 'barrio', 'ciudad', 'comentarios', 'departamento', 'depositoAdelanto', 'descripcion', 'direccion', 'estadoActual', 'id', 'latitudMapa', 'longitudMapa', 'mesesConstruida', 'negociable', 'numerodeParquederosGarajes', 'precio', 'titulo', 'urlImagenes', 'zoomMapa', 'tipo', 'propiedad' ) );
			if ($this->realstaters->makeRequest ()) {
				return $this->realstaters->getResponseData ();
			}
		}
		return false;
	}
	/**
	  * Borra las opciones que no pertenecen al anuncio
      *
      * @param array $opciones Opciones del Anuncio
      * @param array $arrayOpciones base para la comparacion
      * @return array
   	  */
	protected function verificarOpciones($opciones, $arrayOpciones) {
		foreach ( $opciones as $key => $value ) {
			if (! array_key_exists ( $key, self::$$arrayOpciones )) {
				unset ( $opciones [$key] );
			}
		}
		return $opciones;
	}
	/**
	  * Hace el llamado al metodo correspondiente
      *
      * @param string $metodo contiene el tipo de anuncio y propiedad a publicar
      * @param array $opciones Opciondes del anuncio a publicar
      * @return array
   	  */
	public function __call($metodo, $opciones) {
		list ( $tipo, $propiedad ) = explode ( '_', $metodo, 2 );
		$propiedad = strtolower ( $propiedad );
		$tipo = strtolower ( $tipo );
		try {
			switch ($tipo) {
				case 'venta' :
					// En venta no se maneja el deposito o adelanto
					if (isset ( $opciones [0] ['depositoAdelanto'] ))
						unset ( $opciones [0] ['depositoAdelanto'] );
				case 'alquiler' :
				case 'alquilercompartido' :
				case 'alquilertemporal' :
					// Verifica si el tipo de propiedad pertenece al tipo de anuncio
					if (isset ( self::$PROPIEDADES [$tipo] [$propiedad] ) && is_array ( $opciones )) {
						$metodo = self::$PROPIEDADES [$tipo] [$propiedad];
						$arrayOpciones = 'OPCIONES_' . strtoupper ( $metodo );
						// Elimina los datos que no pertenecen al anuncio
						$opciones = $this->verificarOpciones ( $opciones [0], $arrayOpciones );
						$opciones = array_merge ( self::$$arrayOpciones, ( array ) $opciones );
						// Los parametros deben ser enviados a los metodos en orden alfabetico
						ksort ( $opciones );
						$opciones ['tipo'] = $tipo;
						$opciones ['propiedad'] = $propiedad;
						if (method_exists ( $this, $metodo )) {
							return call_user_func_array ( array ($this, $metodo ), $opciones );
						}
						throw new Exception ( 'Error al especificar la Funcion o las Opciones.' );
					} else {
						throw new Exception ( 'Error en el tipo de anuncio o las Opciones.' );
					}
					break;
				default :
					throw new Exception ( 'Error al Especificar la Funcion.' );
					break;
			}
		} catch ( Exception $e ) {
			echo '<strong>Error:</strong> ', $e->getMessage (), "\n";
		}
		return false;
	}
}
?>