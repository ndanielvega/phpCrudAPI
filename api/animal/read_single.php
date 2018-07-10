<?php
/**
 *Devuelve un objeto json con un resultado de la tabla animal
 */

#encabezados
header('Access-Control-Allow-Origin: *'); #publico, cualquiera puede acceder a la api
header('Content-Type: application/json'); #tipo de contenido

#se incluye el modelo y la base de datos
include_once '../../config/Database.php';
include_once '../../models/Animal.php';

#se instancia la base de datos para hacer la conexión
$database = new Database();
$db = $database->connect();

#se instancia un objeto
$animal = new Animals($db);

#se obtiene el id que se quiere consultar
#   condition ? then do something : else
$animal-> id_animal = isset($_GET['id_animal']) ? $_GET['id_animal'] : die();

#se obtiene el resultado
$animal-> read_single();

#se crea el item
$animalArray = array(
    'id_animal' => $animal-> id_animal,
    'name' => $animal-> name,
    'type' => $animal-> type
);

#se convierte el resultado en json
echo json_encode($animalArray);
