<?php

namespace Model;

class ActiveRecord {

    // Base de datos
    protected static $db;
    protected static $tabla = '';
    protected static $columnasDB = [];

    // Alertas y mensajes
    protected static $alertas = [];

    // Definir la conexión a la BD - incluye/database.php
    public static function setDB($database) {
        self::$db = $database;
    }

    public static function setAlerta($tipo, $mensaje) {
        static::$alertas[$tipo][] = $mensaje;
    }

    // Validación
    public static function getAlertas() {
        return static::$alertas;
    }

    public function validar() {
        static::$alertas = [];
        return static::$alertas;
    }

    // Registros - CRUD
    public function guardar() {
        $resultado = '';
        if(!is_null($this->id)) {
            // actualizar
            $resultado = $this->actualizar();
        } else {
            // Creando un nuevo registro
            $resultado = $this->crear();
        }
        return $resultado;
    }

    public static function all() {
        $query = "SELECT * FROM " . static::$tabla;
        $resultado = self::consultarSQL($query);
        return $resultado;
    }

    // Busca un registro por su id
    public static function find($id) {
        $query = "SELECT * FROM " . static::$tabla . " WHERE id = :id";
        $resultado = self::consultarSQL($query, ['id' => $id]);
        return array_shift($resultado);
    }

    // Obtener registro
    public static function get($limite) {
        $query = "SELECT * FROM " . static::$tabla . " LIMIT :limite";
        $resultado = self::consultarSQL($query, ['limite' => $limite]);
        return $resultado;
    }

    // Búsqueda Where con Columna
    public static function where($columna, $valor) {
        $query = "SELECT * FROM " . static::$tabla . " WHERE $columna = :valor";
        $resultado = self::consultarSQL($query, ['valor' => $valor]);
        return array_shift($resultado);
    }

    // Busca todos los registros que pertenecen a un ID
    public static function belongsTo($columna, $valor) {
        $query = "SELECT * FROM " . static::$tabla . " WHERE $columna = :valor";
        $resultado = self::consultarSQL($query, ['valor' => $valor]);
        return $resultado;
    }

    // SQL para consultas avanzadas
    public static function SQL($consulta, $params = []) {
        $resultado = self::consultarSQL($consulta, $params);
        return $resultado;
    }

    // Crear un nuevo registro
    public function crear() {
        // Sanitizar los datos
        $atributos = $this->atributos();

        // Insertar en la base de datos
        $query = "INSERT INTO " . static::$tabla . " (" . join(',', array_keys($atributos)) . ") VALUES (:" . join(", :", array_keys($atributos)) . ")";

        // Preparar la consulta
        $stmt = self::$db->prepare($query);
        $resultado = $stmt->execute($atributos);

        return [
            'resultado' =>  $resultado,
            'id' => self::$db->lastInsertId()
        ];
    }

    // Actualizar un registro
    public function actualizar() {
        // Sanitizar los datos
        $atributos = $this->atributos();

        // Crear los pares columna = valor
        $valores = [];
        foreach($atributos as $key => $value) {
            $valores[] = "{$key} = :{$key}";
        }

        $query = "UPDATE " . static::$tabla . " SET " . join(', ', $valores) . " WHERE id = :id LIMIT 1";

        // Preparar la consulta
        $stmt = self::$db->prepare($query);
        $atributos['id'] = $this->id; // Añadir el ID para la actualización

        $resultado = $stmt->execute($atributos);
        return $resultado;
    }
    
    //Funciona cuando vamos a actualizar varios registros con los mismos valores
    public static function updateItems($tabla, $sets, $ids, $params){
        $sql = "UPDATE {$tabla} SET " . implode(', ', $sets) . " WHERE id IN (" . $ids . ")";
    
        $stmt = self::$db->prepare($sql);
        return $stmt->execute($params);
    }

    // Eliminar un registro
    public function eliminar() {
        $query = "DELETE FROM " . static::$tabla . " WHERE id = :id LIMIT 1";
        $stmt = self::$db->prepare($query);
        $resultado = $stmt->execute(['id' => $this->id]);
        return $resultado;
    }

    // Consultar la base de datos con PDO
    public static function consultarSQL($query, $params = []) {
        $stmt = self::$db->prepare($query);
        $stmt->execute($params);

        // Obtener los resultados
        $registros = $stmt->fetchAll(\PDO::FETCH_ASSOC);

        // Convertir los registros en objetos
        $array = [];
        foreach($registros as $registro) {
            $array[] = static::crearObjeto($registro);
        }

        return $array;
    }

    protected static function crearObjeto($registro) {
        $objeto = new static;

        foreach($registro as $key => $value ) {
            if(property_exists( $objeto, $key )) {
                $objeto->$key = $value;
            }
        }

        return $objeto;
    }

    // Identificar y unir los atributos de la BD
    public function atributos() {
        $atributos = [];
        foreach(static::$columnasDB as $columna) {
            if($columna === 'id') continue;
            $atributos[$columna] = $this->$columna;
        }
        return $atributos;
    }


    public function sincronizar($args=[]) { 
        foreach($args as $key => $value) {
          if(property_exists($this, $key) && !is_null($value)) {
            $this->$key = $value;
          }
        }
    }

    public static function sanitizarFiltro($filtro) {
        return self::$db->quote($filtro);
    }
}