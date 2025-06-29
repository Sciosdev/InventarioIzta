<?php

namespace Model;

class TipoBien extends ActiveRecord {

protected static $tabla = 'tipo_bien';

protected static $columnasDB  = ['id','cvetpo','tipobien','modified_by'];

public $id;
public $cvetpo;
public $tipobien;
public $modified_by;


public function __construct( $args = []){

    $this->id = $args['id'] ?? null;
    $this->cvetpo = $args['cvetpo'] ?? '';
    $this->tipobien = $args['tipobien'] ?? '';
    $this->modified_by = $args['modified_by'] ?? null;
    
}
}