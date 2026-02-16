<?php
require_once __DIR__ . '/Conexion.php';
try {
    $db = Conexion::getConnect();

    // Check if column exists first
    $check = $db->query("SELECT column_name FROM information_schema.columns WHERE table_name = 'programa' AND column_name = 'sede_sede_id'");
    if (!$check->fetch()) {
        $db->exec("ALTER TABLE programa ADD COLUMN sede_sede_id INT");
        $db->exec("ALTER TABLE programa ADD CONSTRAINT fk_programa_sede FOREIGN KEY (sede_sede_id) REFERENCES sede(sede_id)");
        echo "Exitoso: Columna sede_sede_id agregada correctamente.";
    } else {
        echo "Información: La columna sede_sede_id ya existe.";
    }
} catch (Exception $e) {
    echo "Error: " . $e->getMessage();
}
