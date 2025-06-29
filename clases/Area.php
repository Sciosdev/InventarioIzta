<?php

namespace Model;

class Area extends ActiveRecord {

protected static $tabla = 'area';

protected static $columnasDB  = ['id','nombre_area','cve_area','modified_by'];

public $id;
public $nombre_area;
public $cve_area;
public $modified_by;

public function __construct( $args = []){

    $this->id = $args['id'] ?? null;
    $this->nombre_area = $args['nombre_area'] ?? '';
    $this->cve_area = $args['cve_area'] ?? '';
    $this->modified_by = $args['modified_by'] ?? null;
}
}