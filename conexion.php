<?php
//hacer conexion con libreria PDO
try{

    //almacenado en variable $base la conexion
    $base=new PDO ('mysql:host=localhost; dbname=curso_sql', 'root', '');

    //atributos de la conexion, en caso de errores podemos ver en que consiste
    $base->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    //juego de caracteres 
    $base->exec("SET CHARACTER SET UTF8");

} catch (Exception $e) {

    //concatena con getLine para darnos linea de error
    die ('Error' . $e->getMessage());
    echo "Linea del error" .  $e->getLine();

}






?>