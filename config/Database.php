<?php
class Database{

    #parametros para la conexión con la base de datos

    private $host = 'localhost';
    private $dbName = 'apitest';
    private $username = 'root';
    private $password = '';
    private $conn;

    #función para conectarse a la base de datos
    function connect(){
        $this-> conn = null;

        try {
            #se intenta realizar la conexión
            $this-> conn = new PDO('mysql:host=' . $this-> host . ';dbname=' . $this-> dbName,
                                    $this-> username,
                                    $this-> password);
            #para mostrar los errores de consultas
            $this-> conn-> setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            #$this-> conn-> setAttribute( PDO::ATTR_EMULATE_PREPARES, false );
            return $this-> conn;

        } catch (PDOExepction $e) {
            #muestra un mensaje si hay un error
            echo 'Connection error' . $e-> getMessage();
        }

    }
}
