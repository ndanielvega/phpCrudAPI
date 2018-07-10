<?php
#encabezados
header('Access-Control-Allow-Origin: *'); #publico, cualquiera puede acceder a la api
header('Content-Type: application/json'); #tipo de contenido
header('Access-Control-Allow-Methods: DELETE');
header('Access-Control-Allow-Headers: Access-Control-Allow-Headers,Content-Type,Access-Control-Allow-Methods, Authorization, X-Requested-With');

#se incluye el modelo y la base de datos
include_once '../../config/Database.php';
include_once '../../models/Animal.php';

#se instancia la base de datos para hacer la conexión
$database = new Database();
$db = $database->connect();

#se instancia un objeto
$animal = new Animals($db);

#se obtienen los datos que se van a creear
$data = json_decode(file_get_contents("php://input"));
$animal-> id_animal = $data-> id_animal;

#se eliminan los datos
if($animal->delete()) {
    echo json_encode(
        array('message' => 'Deleted')
    );
} else {
    echo json_encode(
        array('message' => 'Not deleted')
    );
}
