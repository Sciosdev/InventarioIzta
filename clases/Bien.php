<?php

namespace Model;

class Bien extends ActiveRecord
{
    protected static $tabla = 'bien';

    protected static $columnasDB = ['id', 'descripcion', 'tipo_inventario', 'numero_inventario', 'numero_serie', 'tipo_bien_id', 'marca', 'modelo', 'autorizador', 'transferencia', 'edificio_id', 'ubicacion', 'area_id', 'responsable_id', 'modified_by', 'created_by'];

    // Atributos para almacenar los valores
    public $id;
    public $descripcion;
    public $tipo_inventario;
    public $numero_inventario;
    public $numero_serie;
    public $tipo_bien_id;
    public $marca;
    public $modelo;
    public $autorizador;
    public $transferencia;
    public $edificio_id;
    public $ubicacion;
    public $area_id;
    public $responsable_id;
    public $modified_by;
    public $created_by;

    //Valores de otras tablas
    public $tipobien;
    public $nombre_responsable;
    public $nombreedif;
    public $nombre_area;
    public $nombre_autorizador;
    public $nombre_created; //Nombre usuario que lo creo
    public $nombre_modified; //Nombre usuario que lo edito 
    public $rfc_responsable;
    public $puesto_responsable;

    public function __construct($args = [])
    {
        $this->id = $args['id'] ?? null;
        $this->descripcion = $args['descripcion'] ?? '';
        $this->tipo_inventario = $args['tipo_inventario'] ?? '';
        $this->numero_inventario = $args['numero_inventario'] ?? '';
        $this->numero_serie = $args['numero_serie'] ?? '';
        $this->tipo_bien_id = $args['tipo_bien_id'] ?? null;
        $this->marca = $args['marca'] ?? '';
        $this->modelo = $args['modelo'] ?? '';
        $this->autorizador = $args['autorizador'] ?? '';
        $this->transferencia = $args['transferencia'] ?? 0;
        $this->edificio_id = $args['edificio_id'] ?? null;
        $this->ubicacion = $args['ubicacion'] ?? '';
        $this->area_id = $args['area_id'] ?? null;
        $this->responsable_id = $args['responsable_id'] ?? null;
        $this->modified_by = $args['modified_by'] ?? null;
        $this->created_by = $args['created_by'] ?? null;

        //Valores de otras tablas
        $this->tipobien = $args['tipobien'] ?? '';
        $this->nombre_responsable = $args['nombre_responsable'] ?? '';
        $this->nombreedif = $args['nombreedif'] ?? '';
        $this->nombre_area = $args['nombre_area'] ?? '';
        $this->nombre_autorizador = $args['nombre_autorizador'] ?? '';
        $this->nombre_created = $args['nombre_created'] ?? '';
        $this->nombre_modified = $args['nombre_modified'] ?? '';
        $this->rfc_responsable   = $args['rfc_responsable']   ?? '';
$this->puesto_responsable = $args['puesto_responsable'] ?? '';

        
    }

    public function validarBien()
    {

        if (!$this->numero_inventario) {
            self::$alertas['error'][] = 'El numero de inventario es obligatorio';
        }
        if (!$this->tipo_inventario) {
            self::$alertas['error'][] = 'Seleccione un tipo de inventario';
        }
        if (!$this->tipo_bien_id) {
            self::$alertas['error'][] = 'Seleccione un tipo de bien';
        }
        if (!$this->descripcion) {
            self::$alertas['error'][] = 'La descripcion es obligatoria';
        }
        if (!$this->numero_serie) {
            self::$alertas['error'][] = 'El numero de serie es obligatorio';
        }
        if (!$this->marca) {
            self::$alertas['error'][] = 'La marca es obligatoria';
        }
        if (!$this->modelo) {
            self::$alertas['error'][] = 'El modelo es obligatorio';
        }
        if (!$this->autorizador) {
            self::$alertas['error'][] = 'Seleccione un autorizador ';
        }
        if (!$this->responsable_id) {
            self::$alertas['error'][] = 'Seleccione un responsale';
        }
        if (!$this->area_id) {
            self::$alertas['error'][] = 'Seleccione una area';
        }
        if (!$this->edificio_id) {
            self::$alertas['error'][] = 'Selecione un edificio';
        }
        if (!$this->ubicacion) {
            self::$alertas['error'][] = 'Escriba la ubicacion del bien';
        }

        return self::$alertas;
    }

    public static function construirConsulta($filtros)
    {
        //Creamos nuestra consulta
        $consulta = "SELECT bien.id, bien.descripcion, bien.tipo_inventario, bien.numero_inventario, bien.numero_serie, bien.tipo_bien_id, t.tipobien, bien.marca, bien.modelo, bien.autorizador, bien.transferencia, bien.edificio_id, e.nombreedif, bien.ubicacion, bien.area_id, a.nombre_area, bien.responsable_id, r.nombre_responsable, r.rfc AS rfc_responsable, r.puesto AS puesto_responsable, bien.modified_by, um.nombre AS nombre_modified, uc.nombre AS nombre_created, r_aut.nombre_responsable AS nombre_autorizador ";
        $consulta .= "FROM bien ";
        $consulta .= "LEFT OUTER JOIN tipo_bien t ON bien.tipo_bien_id = t.id ";
        $consulta .= "LEFT OUTER JOIN edificio e ON bien.edificio_id = e.id ";
        $consulta .= "LEFT OUTER JOIN area a ON bien.area_id = a.id ";
        $consulta .= "LEFT OUTER JOIN responsable r ON bien.responsable_id = r.id ";
        $consulta .= "LEFT OUTER JOIN responsable r_aut ON bien.autorizador = r_aut.id ";
        $consulta .= "LEFT OUTER JOIN usuarios um ON bien.modified_by = um.id ";
        $consulta .= "LEFT OUTER JOIN usuarios uc ON bien.created_by = uc.id ";

        $condiciones  = []; // Almacenar condiciones de filtro
        $params = []; // Parámetros para PDO

        //Vamos agregando las condiciones y los paramentros con los valores que recibimos en filtros
        // Validar filtros y agregar a las condiciones WHERE
        if (!empty($filtros['numero_inventario'])) {
            $condiciones[] = "bien.numero_inventario = :num_inventario";
            $params[':num_inventario'] = $filtros['numero_inventario'];
        }
        if (!empty($filtros['tipo_inventario'])) {
            $condiciones[] = "bien.tipo_inventario = :tipo_inventario";
            $params[':tipo_inventario'] = $filtros['tipo_inventario'];
        }
        if (!empty($filtros['tipobien'])) {
            $condiciones[] = "bien.tipo_bien_id = :tipo_bien";
            $params[':tipo_bien'] = $filtros['tipobien'];
        }
        if (!empty($filtros['nombre_responsable'])) {
            $condiciones[] = "bien.responsable_id = :responsable";
            $params[':responsable'] = $filtros['nombre_responsable'];
        }
        if (!empty($filtros['nombre_area'])) {
            $condiciones[] = "bien.area_id = :area";
            $params[':area'] = $filtros['nombre_area'];
        }
        if (!empty($filtros['nombreedif'])) {
            $condiciones[] = "bien.edificio_id = :edificio";
            $params[':edificio'] = $filtros['nombreedif'];
        }
        if (!empty($filtros['transferencia'])) {
            $condiciones[] = "bien.transferencia = :transferido";
            $params[':transferido'] = $filtros['transferencia'];
        }

        if (count($condiciones) > 0) {
            $consulta .= " WHERE " . implode(' AND ', $condiciones);
        }

        $limite = $filtros['limite'] ?? '';

        if ($limite) {
            $consulta .= "LIMIT " . $limite; // Agregando el límite dinámicamente
        }

        return [
            'consulta' => $consulta,
            'params' => $params,
        ];
    }

    public static function ejecutarConsulta($consulta, $params)
    {
        return self::SQL($consulta, $params);
    }

    public static function updateBienes($columnas, $ids)
    {

        $sets = [];
        $params = [];

        foreach ($columnas as $columna => $valor) {
            if (!empty($valor)) {
                $sets[] = "{$columna} = :{$columna}";
                $params[":{$columna}"] = $valor;
            }
        }

        return ActiveRecord::updateItems(static::$tabla, $sets, $ids, $params);
    }

    public static function getBienes($ids)
    {

        // Convertir el string "1,2,3" en array de números
        $idsArray = array_filter(array_map('trim', explode(',', $ids)), 'is_numeric');

        //Creamos nuestra consulta
        $consulta = "SELECT bien.id, bien.descripcion, bien.tipo_inventario, bien.numero_inventario, bien.numero_serie, bien.tipo_bien_id, t.tipobien, bien.marca, bien.modelo, bien.autorizador, bien.transferencia, bien.edificio_id, e.nombreedif, bien.ubicacion, bien.area_id, a.nombre_area, bien.responsable_id, r.nombre_responsable, r.rfc AS rfc_responsable, r.puesto AS puesto_responsable, bien.modified_by, um.nombre AS nombre_modified, uc.nombre AS nombre_created, r_aut.nombre_responsable AS nombre_autorizador ";
        $consulta .= "FROM bien ";
        $consulta .= "LEFT OUTER JOIN tipo_bien t ON bien.tipo_bien_id = t.id ";
        $consulta .= "LEFT OUTER JOIN edificio e ON bien.edificio_id = e.id ";
        $consulta .= "LEFT OUTER JOIN area a ON bien.area_id = a.id ";
        $consulta .= "LEFT OUTER JOIN responsable r ON bien.responsable_id = r.id ";
        $consulta .= "LEFT OUTER JOIN responsable r_aut ON bien.autorizador = r_aut.id ";
        $consulta .= "LEFT OUTER JOIN usuarios um ON bien.modified_by = um.id ";
        $consulta .= "LEFT OUTER JOIN usuarios uc ON bien.created_by = uc.id ";

        // Crear placeholders para los IDs
        $placeholders = [];
        $params = [];

        foreach ($idsArray as $index => $id) {
            $placeholder = ":id$index";
            $placeholders[] = $placeholder;
            $params[$placeholder] = $id;
        }

        $consulta .= " WHERE bien.id IN (" . implode(', ', $placeholders) . ")";

        return [
            'consulta' => $consulta,
            'params' => $params,
        ];
    }
}
