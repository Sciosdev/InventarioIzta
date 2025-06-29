<?php

namespace Model;

class Edificio extends ActiveRecord {

protected static $tabla = 'edificio';

protected static $columnasDB  = ['id','nombreedif','cveedif', 'modified_by'];

public $id;
public $nombreedif;
public $cveedif;
public $modified_by;

public function __construct( $args = []){

    $this->id = $args['id'] ?? null;
    $this->nombreedif = $args['nombreedif'] ?? '';
    $this->cveedif = $args['cveedif'] ?? '';
    $this->modified_by = $args['modified_by'] ?? null;
}
}