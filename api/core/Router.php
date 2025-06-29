<?php

namespace MVC;

class Router
{
    public array $getRoutes = [];
    public array $postRoutes = [];
    public array $putRoutes = [];
    public array $deleteRoutes = [];
    
    public function get($url, $fn)
    {
        $this->getRoutes[$url] = $fn;
    }

    public function post($url, $fn)
    {
        $this->postRoutes[$url] = $fn;
    }

    public function put($url, $fn)
    {
        $this->putRoutes[$url] = $fn;
    }
    
    public function delete($url, $fn)
    {
        $this->deleteRoutes[$url] = $fn;
    }

    public function comprobarRutas()
    {

        $currentUrl = $_SERVER['PATH_INFO'] ?? '/';
        $method = $_SERVER['REQUEST_METHOD'];

        if ($method === 'GET') {
            $fn = $this->getRoutes[$currentUrl] ?? null;
        } else if($method === 'POST') {
            $fn = $this->postRoutes[$currentUrl] ?? null;
        }
         else if($method === 'PUT') {
            $fn = $this->putRoutes[$currentUrl] ?? null;
        }
         else if($method === 'DELETE') {
            $fn = $this->deleteRoutes[$currentUrl] ?? null;
        }

        if ( $fn ) {
            // Call user fn va a llamar una función cuando no sabemos cual sera
            call_user_func($fn, $this); // This es para pasar argumentos
        } else {
            echo "Página No Encontrada o Ruta no válida";
        }
    }

}
