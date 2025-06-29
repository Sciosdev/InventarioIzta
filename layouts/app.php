<?php 

require 'funciones.php';
require 'config.php';

use Model\ActiveRecord;

require_once __DIR__.'/../clases/ActiveRecord.php';

ActiveRecord::setDB($db); 