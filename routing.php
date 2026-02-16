<?php

// Carga de variables de entorno para que Conexion.php funcione
require_once __DIR__ . '/EnvLoader.php';

// Prevenir salida de errores HTML que rompan el JSON en peticiones AJAX
if (isset($_SERVER['HTTP_X_REQUESTED_WITH']) || (isset($_SERVER['HTTP_ACCEPT']) && strpos($_SERVER['HTTP_ACCEPT'], 'application/json') !== false)) {
    ini_set('display_errors', 0);
    error_reporting(E_ALL);
}

$controllers = array(
    'sede' => ['index', 'show', 'store', 'update', 'destroy', 'getProgramas'],
    'ambiente' => ['index', 'show', 'store', 'update', 'destroy'],
    'programa' => ['index', 'show', 'store', 'update', 'destroy', 'getTitulos'],
    'competencia' => ['index', 'show', 'store', 'update', 'destroy'],
    'titulo_programa' => ['index', 'show', 'store', 'update', 'destroy'],
    'instructor' => ['index', 'show', 'showByCentro', 'store', 'update', 'destroy', 'getCentros'],
    // Agrega más controladores y acciones aquí si lo necesitas
);

try {
    // Obtener controlador y acción buscando en GET y POST
    $controller = $_GET['controller'] ?? $_POST['controller'] ?? 'sede';
    $action = $_GET['action'] ?? $_POST['action'] ?? 'index';

    // Validación básica de existencia del controlador y acción
    if (!array_key_exists($controller, $controllers) || !in_array($action, $controllers[$controller])) {
        $controller = 'sede';
        $action = 'index';
    }

    $controllerFile = 'controller/' . $controller . 'Controller.php';

    // Verificar que el archivo del controlador existe
    if (!file_exists($controllerFile)) {
        throw new Exception("Controlador no encontrado: $controller");
    }

    require_once($controllerFile);

    switch ($controller) {
        case 'sede':
            require_once('model/SedeModel.php');
            $controllerObj = new SedeController();
            break;
        case 'ambiente':
            require_once('model/AmbienteModel.php');
            require_once('model/SedeModel.php');
            $controllerObj = new AmbienteController();
            break;
        case 'programa':
            require_once('model/ProgramaModel.php');
            require_once('model/TituloProgramaModel.php');
            $controllerObj = new ProgramaController();
            break;
        case 'titulo_programa':
            require_once('model/TituloProgramaModel.php');
            $controllerObj = new TituloProgramaController();
            break;
        case 'competencia':
            require_once('model/CompetenciaModel.php');
            $controllerObj = new CompetenciaController();
            break;
        case 'instructor':
            require_once('model/InstructorModel.php');
            require_once('model/CentroFormacionModel.php');
            $controllerObj = new InstructorController();
            break;
        default:
            throw new Exception("Controlador no soportado: $controller");
    }

    // Verificar que el método existe
    if (!method_exists($controllerObj, $action)) {
        throw new Exception("Acción no encontrada: $action en $controller");
    }

    $reflection = new ReflectionMethod($controllerObj, $action);
    $args = [];

    // Recolecta los parámetros esperados desde $_POST o $_GET en el orden correcto
    foreach ($reflection->getParameters() as $param) {
        $paramName = $param->getName();
        if (isset($_POST[$paramName])) {
            $args[] = $_POST[$paramName];
        } elseif (isset($_GET[$paramName])) {
            $args[] = $_GET[$paramName];
        } elseif ($param->isDefaultValueAvailable()) {
            $args[] = $param->getDefaultValue();
        } elseif (!$param->isOptional()) {
            http_response_code(400);
            throw new Exception("Falta el parámetro requerido: $paramName");
        }
    }

    // Llama al método con los argumentos necesarios
    $controllerObj->{$action}(...$args);
} catch (Throwable $e) {
    http_response_code(500);
    $isJsonRequest = (isset($_SERVER['HTTP_X_REQUESTED_WITH']) || (isset($_SERVER['HTTP_ACCEPT']) && strpos($_SERVER['HTTP_ACCEPT'], 'application/json') !== false));

    if ($isJsonRequest) {
        header('Content-Type: application/json');
        echo json_encode([
            'error' => 'Error interno en el servidor',
            'details' => $e->getMessage(),
            'file' => $e->getFile(),
            'line' => $e->getLine()
        ]);
    } else {
        echo "<h1>Error 500: " . $e->getMessage() . "</h1>";
        echo "<p>En el archivo: " . $e->getFile() . " en la línea " . $e->getLine() . "</p>";
    }
}
