<?php
class Animals{
    #Atributos para la conexión con la base de datos
    private $conn;
    private $table = 'animals';

    #atributos de animal
    public $id_animal;
    public $name;
    public $type;

    #constructor, se le pasa una instancia de $db para realizar las operaciones con la base de datos
    public function __construct($db){
        $this-> conn = $db;
    }

    #obtiene todos los resultados de la base de datos
    public function read(){
        #Se crea la consulta
        $sql = 'SELECT * FROM ' . $this->table .
                ' ORDER BY creation_date DESC';
        #Se prepara la consulta para evitar problemas de SQLInyection
        $statement = $this-> conn-> prepare($sql);
        #Se ejecuta la consulta
        $statement-> execute();

        return $statement;
    }

    #obtiene un solo resultado
    public function read_single(){
        #Se crea la consulta
        $sql = 'SELECT * FROM ' . $this->table .
                ' WHERE id_animal = ?
                  LIMIT 0,1';
        #Se prepara la consulta para evitar problemas de SQLInyection
        $statement = $this-> conn-> prepare($sql);
        #Se usa el id para la consulta
        $statement->bindParam(1, $this-> id_animal);
        #Se ejecuta la consulta
        $statement-> execute();


        #se cambian las propiedades de la instancia por las del resultado
        $row = $statement->fetch(PDO::FETCH_ASSOC);

        $this-> id_animal = $row['id_animal'];
        $this-> name = $row['name'];
        $this-> type = $row['type'];

        return $statement;
    }

    public function create(){
        #se crea la consulta
        $sql='INSERT INTO '. $this->table . '
            (name,type)
            VALUES (    :name,
                        :type)';

        #Se prepara la consulta para evitar problemas de SQLInyection
        $statement = $this-> conn-> prepare($sql);

        #limpiar los datos para mayor seguridad
        $this-> name      = htmlspecialchars(strip_tags($this-> name)) ;
        $this-> type      = htmlspecialchars(strip_tags($this-> type)) ;

        #se usan los datos para la consulta sql
        $statement->bindParam(':name', $this-> name);
        $statement->bindParam(':type', $this-> type);

        #se ejecuta la sentencia sql y se muestran los errores si es que hay
        if ($statement->execute()) {
            return true;
        }

        printf("Error: %s. \n", $statement->error);
        return false;
    }

    public function update() {
        #se crea la sentencia
        $sql = 'UPDATE ' . $this-> table . '
        SET
          name = :name,
          type = :type
        WHERE
          id_animal = :id_animal';

        #Se prepara la consulta para evitar problemas de SQLInyection
        $statement = $this-> conn-> prepare($sql);

        #limpiar los datos para mayor seguridad
        $this-> name      = htmlspecialchars(strip_tags($this->name));
        $this-> type      = htmlspecialchars(strip_tags($this->type));
        $this-> id_animal = htmlspecialchars(strip_tags($this->id_animal));

        #se usan los datos para la consulta sql
        $statement->bindParam(':name', $this-> name);
        $statement->bindParam(':type', $this-> type);
        $statement->bindParam(':id_animal', $this-> id_animal);
        #se ejecuta la sentencia sql y se muestran los errores si es que hay
        if($statement->execute()) {
        return true;
        }
        printf("Error: %s.\n", $statement->error);
        return false;
    }


    public function delete() {
        #se crea la sentencia
        $sql = 'DELETE FROM ' . $this-> table . ' WHERE id_animal = :id_animal';
        #Se prepara la consulta para evitar problemas de SQLInyection
        $statement = $this-> conn->prepare($sql);
        #limpiar los datos para mayor seguridad
        $this-> id_animal = htmlspecialchars(strip_tags($this-> id_animal));
        #se usan los datos para la consulta sql
        $statement->bindParam(':id_animal', $this->id_animal);
        #se ejecuta la sentencia sql y se muestran los errores si es que hay
        if($statement->execute()) {
        return true;
        }
        printf("Error: %s.\n", $statement->error);
        return false;
        }
}
