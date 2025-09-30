<?php

define('BASE_PATH', rtrim(getenv('APP_BASE_PATH') ?: '/inventario', '/'));

/* Base de datos configuración */
define('DB_SERVER', '192.185.131.183');
define('DB_USERNAME', 'xaanal_inventario');
define('DB_PASSWORD', 'Inventario-1$');
define('DB_NAME', 'xaanal_inventarioBD');

try {
    // Crear una nueva instancia de PDO
    $dsn = 'mysql:host=' . DB_SERVER . ';dbname=' . DB_NAME . ';charset=utf8';
    $options = array(
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION, // Lanza excepciones en caso de error
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC, // Establece el modo de recuperación por defecto
        PDO::ATTR_EMULATE_PREPARES => false, // Desactiva la emulación de consultas preparadas
    );
    
    // Crear la conexión
    $db = new PDO($dsn, DB_USERNAME, DB_PASSWORD, $options);
    
} catch (PDOException $e) {
    // Si ocurre un error, lo capturamos y mostramos el mensaje de error
    die("ERROR: No se pudo conectar. " . $e->getMessage());
}

$gmailid = ''; // YOUR gmail email
$gmailpassword = ''; // YOUR gmail password
$gmailusername = ''; // YOUR gmail User name

?>