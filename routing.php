<?php

/**
 * Front Controller / Router
 * Estilo Plantilla Académica
 */

// Usamos la cadena inteligente de rutas absolutas
require_once __DIR__ . '/EnvLoader.php';

// Obtener controlador y acción de la petición
$controller = $_GET['controller'] ?? $_POST['controller'] ?? 'sede';
$action = $_GET['action'] ?? $_POST['action'] ?? 'index';

// Definición de controladores y acciones permitidas
$controllers = array(
    'sede' => ['index', 'show', 'store', 'update', 'destroy'],
);

// Validación de existencia del controlador y acción
if (array_key_exists($controller, $controllers)) {
    if (in_array($action, $controllers[$controller])) {
        call($controller, $action);
    } else {
        // Podrías redirigir a una página de error académica aquí
        http_response_code(404);
        echo "<h1>Error 404: Acción No Encontrada</h1>";
    }
} else {
    http_response_code(404);
    echo "<h1>Error 404: Controlador No Encontrado</h1>";
}

function call($controller, $action)
{
    // Ruta absoluta usando dirname
    $controllerFile = __DIR__ . '/controller/' . $controller . 'Controller.php';

    if (!file_exists($controllerFile)) {
        http_response_code(404);
        echo "<h1>Error 404: Archivo del Controlador no encontrado</h1>";
        return;
    }

    require_once($controllerFile);

    // Instanciación dinámica según el controlador
    switch ($controller) {
        case 'sede':
            $controllerObj = new SedeController();
            break;
    }

    // Verificar que el método existe en el objeto
    if (!method_exists($controllerObj, $action)) {
        http_response_code(404);
        echo "<h1>Error 404: El método $action no existe en el controlador</h1>";
        return;
    }

    try {
        // Uso de Reflexión para llamadas dinámicas con parámetros inteligentes
        $reflection = new ReflectionMethod($controllerObj, $action);
        $args = [];

        foreach ($reflection->getParameters() as $param) {
            $paramName = $param->getName();
            // Priorizamos $_POST para creación/edición, luego $_GET
            if (isset($_POST[$paramName])) {
                $args[] = $_POST[$paramName];
            } elseif (isset($_GET[$paramName])) {
                $args[] = $_GET[$paramName];
            } elseif ($param->isDefaultValueAvailable()) {
                $args[] = $param->getDefaultValue();
            } elseif (!$param->isOptional()) {
                http_response_code(400);
                echo "<h1>Error 400: Falta el parámetro requerido: $paramName</h1>";
                return;
            }
        }

        // Ejecutar la acción
        $controllerObj->{$action}(...$args);
    } catch (ReflectionException $e) {
        http_response_code(500);
        echo "<h1>Error 500: Error de Reflexión - " . $e->getMessage() . "</h1>";
    }
}
