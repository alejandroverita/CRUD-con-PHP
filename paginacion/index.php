<?php

try{

    //almacenado en variable $base la conexion
    $base=new PDO ('mysql:host=localhost; dbname=curso_sql', 'root', '');

    //atributos de la conexion, en caso de errores podemos ver en que consiste
    $base->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    //juego de caracteres 
    $base->exec("SET CHARACTER SET UTF8");

    //sentencia SQL que devuelve registros de BBDD
    $sql_total="SELECT NOMBREARTÍCULO, SECCIÓN, PRECIO, PAÍSDEORIGEN FROM PRODUCTOS WHERE SECCIÓN='DEPORTES'";

    //Sentencia preparada que devuelve todos los registros selecionados
    $resultado=$base->prepare($sql_total);

    $resultado->execute(array());

    //Recorrer array almacenado
    while($registro=$resultado->fetch(PDO::FETCH_ASSOC)){

        echo "Nombre Artículo: " . $registro["NOMBREARTÍCULO"] . " Sección: " . $registro["SECCIÓN"] . " Precio: " . $registro["PRECIO"] . " País de origen: " . $registro["PAÍSDEORIGEN"] . "<br>";

    }


    //cerrar cursor
    $resultado->closeCursor();

} catch (Exception $e) {

    //concatena con getLine para darnos linea de error
    die ('Error' . $e->getMessage());
    echo "Linea del error" .  $e->getLine();

}








?>