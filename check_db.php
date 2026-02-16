<?php
require_once __DIR__ . '/Conexion.php';
try {
    $db = Conexion::getConnect();
    $stmt = $db->query("SELECT column_name, data_type FROM information_schema.columns WHERE table_name = 'programa'");
    $columns = $stmt->fetchAll(PDO::FETCH_ASSOC);
    header('Content-Type: application/json');
    echo json_encode($columns, JSON_PRETTY_PRINT);
} catch (Exception $e) {
    echo "Error: " . $e->getMessage();
}
