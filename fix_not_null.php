<?php
require_once 'model/Conexion.php';

try {
    $db = Conexion::getConnect();

    $sql = "ALTER TABLE instructor ALTER COLUMN centro_formacion_cent_id DROP NOT NULL;";

    $db->exec($sql);

    echo "¡Éxito! La columna 'centro_formacion_cent_id' ahora permite valores nulos.\n";
    echo "Ya puedes intentar registrar al instructor nuevamente.";
} catch (Exception $e) {
    echo "Error al modificar la base de datos: " . $e->getMessage();
}
