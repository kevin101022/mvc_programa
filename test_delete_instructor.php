<?php
require_once __DIR__ . '/model/InstructorModel.php';
try {
    // 1. Create a dummy instructor
    $model = new InstructorModel(null, 'Test', 'Delete', 'test@example.com', '123456', 1, 'Testing');
    $id = $model->create();
    echo "Instructor created with ID: $id\n";

    // 2. Try to delete it
    $model->setInstId($id);
    if ($model->delete()) {
        echo "Instructor deleted successfully.\n";
    } else {
        echo "Failed to delete instructor.\n";
    }

} catch (Exception $e) {
    echo "Error: " . $e->getMessage() . "\n";
}
