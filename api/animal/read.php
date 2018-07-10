<?php
/**
 *Devuelve un objeto json con todos los datos de la tabla animal
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
#se hace la consulta de los datos y su tamaño
$result = $animal-> read();
$num = $result-> rowCount();

#se muestran los datos
if ($num>0) {
    #array en el que se guardan los resultados
    $animalArray = array();
    $animalArray['data'] = array();

    while ($row = $result ->fetch(PDO::FETCH_ASSOC)) {
        #para tener cada campo de la fila como una variable
        extract($row);
        #se crea el item
        $animalItem = array(
            'id_animal' => $id_animal,
            'name' => $name,
            'type' => $type
        );
        #se agrega al array de datos
        array_push($animalArray['data'], $animalItem);
    }

    #se convierte el resultado en json
    echo json_encode($animalArray);
}else{
    echo json_encode(
        array('message'=>'No hay resultados')
    );
}
