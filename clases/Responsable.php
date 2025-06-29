<?php

namespace Model;

class Responsable extends ActiveRecord {

protected static $tabla = 'responsable';

protected static $columnasDB  = ['id','nombre_responsable','rfc','puesto','modified_by'];

public $id;
public $nombre_responsable;
public $rfc;
public $puesto;
public $modified_by;

public function __construct( $args = []){

    $this->id = $args['id'] ?? null;
    $this->nombre_responsable = $args['nombre_responsable'] ?? '';
    $this->rfc = $args['rfc'] ?? '';
    $this->puesto = $args['puesto'] ?? '';
    $this->modified_by = $args['modified_by'] ?? null;
}
}