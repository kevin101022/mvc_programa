<?php
// Script de depuración de Base de Datos
error_reporting(E_ALL);
ini_set('display_errors', 1);

echo "<h2>Depuración de Conexión PostgreSQL</h2>";

// 1. Verificar extensiones
echo "<h3>1. Verificando Extensiones PHP:</h3>";
$extensions = ['pdo_pgsql', 'pgsql'];
foreach ($extensions as $ext) {
    if (extension_loaded($ext)) {
        echo "✅ La extensión '$ext' está CARGADA.<br>";
    } else {
        echo "❌ La extensión '$ext' NO ESTÁ CARGADA. (Debes activarla en php.ini)<br>";
    }
}

// 2. Intentar conexión
echo "<h3>2. Probando Conexión con Conexion.php:</h3>";
try {
    // Ajustamos la ruta ya que estamos dentro de mvc_programa
    require_once 'Conexion.php';
    $db = Conexion::getConnect();
    echo "✅ Conexión establecida correctamente con la clase Conexion.<br>";

    // 3. Verificar si existe la tabla
    echo "<h3>3. Verificando Tabla 'sede':</h3>";
    $query = $db->query("SELECT EXISTS (
        SELECT FROM information_schema.tables 
        WHERE table_name = 'sede'
    )");
    $exists = $query->fetchColumn();

    if ($exists) {
        echo "✅ La tabla 'sede' SI EXISTE en la base de datos.<br>";

        // 4. Ver estructura de la tabla
        echo "<h4>Estructura de la tabla 'sede':</h4>";
        $columns = $db->query("SELECT column_name, data_type, is_nullable 
                                  FROM information_schema.columns 
                                  WHERE table_name = 'sede'")->fetchAll(PDO::FETCH_ASSOC);
        echo "<table border='1' style='border-collapse: collapse; width: 100%;'>";
        echo "<tr><th>Columna</th><th>Tipo</th><th>Nulo</th></tr>";
        foreach ($columns as $col) {
            echo "<tr><td>{$col['column_name']}</td><td>{$col['data_type']}</td><td>{$col['is_nullable']}</td></tr>";
        }
        echo "</table><br>";

        // 5. Ver contenido
        $count = $db->query("SELECT COUNT(*) FROM sede")->fetchColumn();
        echo "📊 Total de registros en 'sede': $count<br>";
    } else {
        echo "❌ La tabla 'sede' NO EXISTE. Asegúrate de haberla creado en PostgreSQL.<br>";
    }
} catch (PDOException $e) {
    echo "❌ ERROR DE PDO: " . $e->getMessage() . "<br>";
    echo "<i>Código de error: " . $e->getCode() . "</i><br>";
} catch (Exception $e) {
    echo "❌ ERROR GENERAL: " . $e->getMessage() . "<br>";
}
