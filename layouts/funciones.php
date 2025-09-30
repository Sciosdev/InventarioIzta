<?php

function url(string $path = ''): string
{
    $path = ltrim($path, '/');

    if (BASE_PATH === '') {
        return '/' . $path;
    }

    if ($path === '') {
        return BASE_PATH . '/';
    }

    return BASE_PATH . '/' . $path;
}

function debuguear($variable) : string {
    echo "<pre>";
    var_dump($variable);
    echo "</pre>";
    exit;
}

// Escapa / Sanitizar el HTML
function s($html) : string {
    $s = htmlspecialchars($html);
    return $s;
}

// Función que revisa que el usuario este autenticado
function isAuth() : void {
    if(!isset($_SESSION['login'])) {
        header('Location: ' . url('/'));
    }
}

function isAdmin() : bool {

    return (isset($_SESSION['rol']) && $_SESSION['rol'] === 'Administrador');
}

function redirectIfNotAdmin(): void {

    if (!isset($_SESSION['rol']) || $_SESSION['rol'] !== 'Administrador') {
        header('Location: ' . url('/dashboard.php'));
        exit; // ¡Importante para detener la ejecución!
    }
}

function mi_autoload($clase)
{
    $partes = explode('\\', $clase);
    $ruta = __DIR__ . '/../clases/';
    $archivo = $ruta . $partes[1] . '.php';
    // Comprobar si el archivo existe y, si es así, incluirlo
    if (file_exists($archivo)) {
        require_once $archivo;
    } else {
        // Si no se encuentra la clase, puedes lanzar un error o manejarlo
       return false;
    }
}
function mi_autoloadController($controller)
{
    $partes = explode('\\', $controller);
    $ruta = __DIR__ . '/../api/Controllers/';
    $archivo = $ruta . $partes[1] . '.php';
    // Comprobar si el archivo existe y, si es así, incluirlo
    if (file_exists($archivo)) {
        require_once $archivo;
    } else {
        // Si no se encuentra la clase, puedes lanzar un error o manejarlo
        return false;
    }
}
function mi_autoloadMVC($mvc)
{
    $partes = explode('\\', $mvc);
    $ruta = __DIR__ . '/../api/core/';
    $archivo = $ruta . $partes[1] . '.php';
    // Comprobar si el archivo existe y, si es así, incluirlo
    if (file_exists($archivo)) {
        require_once $archivo;
    } else {
        // Si no se encuentra la clase, puedes lanzar un error o manejarlo
       return false;
    }
}
