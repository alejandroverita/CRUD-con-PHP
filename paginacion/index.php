<?php

try{

    //almacenado en variable $base la conexion
    $base=new PDO ('mysql:host=localhost; dbname=curso_sql', 'root', '');

    //atributos de la conexion, en caso de errores podemos ver en que consiste
    $base->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    //juego de caracteres 
    $base->exec("SET CHARACTER SET UTF8");

    //variable para almacenar cuantos registrros queremos guardar por pagina
    $tamagno_paginas=3;

    //Ejecuta bloque si es que se ha pasado parametro "pagina por la URL
    if (isset ($_GET["pagina"])) {
        if ($_GET["pagina"]==1) {

            header ("Location:index.php");
        } 
        else {
            $pagina=$_GET["pagina"]; //guardar temporalmente el numero de la pagina es esa variable
        }
    } 
    else {
        //Variable para mostrar el numero de pagina donde nos encontramos
        $pagina=1;
    }

    $empezar_desde=($pagina-1)*$tamagno_paginas;

    //sentencia SQL que devuelve registros de BBDD. Saber cuantos regisros nos devuelve la consulta
    $sql_total="SELECT NOMBREARTÍCULO, SECCIÓN, PRECIO, PAÍSDEORIGEN FROM PRODUCTOS WHERE SECCIÓN='DEPORTES'";

    //Sentencia preparada que devuelve todos los registros selecionados
    $resultado=$base->prepare($sql_total);

    $resultado->execute(array());

    //cuantos rergistros nos devuelve consulta sql

    $num_filas=$resultado->rowCount(); //cuenta filas que tengo dentro del array

    //averiguar cuantas paginas va a tener nuestra paginacion
    $total_paginas=ceil($num_filas/$tamagno_paginas); //evuelve redonder el numero la funcion CEIL

    echo "Numero de registros de la consulta: " . $num_filas . "<br>";
    echo "Mostramos " . $tamagno_paginas . " registros por pagina <br>";
    echo "Mostrando la pagina " . $pagina . " de " . $total_paginas . "<br>";

    //Recorrer array almacenado
    //while($registro=$resultado->fetch(PDO::FETCH_ASSOC)){

        //echo "Nombre Artículo: " . $registro["NOMBREARTÍCULO"] . " Sección: " . $registro["SECCIÓN"] . " Precio: " . $registro["PRECIO"] . " País de origen: " . $registro["PAÍSDEORIGEN"] . "<br>";

   // } 

    //cerrar cursor
    $resultado->closeCursor();

    //almacenar instruccion sql con el limite. 2da consulta para ue nos lo muestre en pantalla
    $sql_limite="SELECT NOMBREARTÍCULO, SECCIÓN, PRECIO, PAÍSDEORIGEN FROM PRODUCTOS WHERE SECCIÓN='DEPORTES' LIMIT $empezar_desde, $tamagno_paginas";
    $resultado=$base->prepare($sql_limite);

    $resultado->execute(array());
    
    while($registro=$resultado->fetch(PDO::FETCH_ASSOC)){

        echo "Nombre Artículo: " . $registro["NOMBREARTÍCULO"] . " Sección: " . $registro["SECCIÓN"] . " Precio: " . $registro["PRECIO"] . " País de origen: " . $registro["PAÍSDEORIGEN"] . "<br>";

    } 
    
} catch (Exception $e) {

    //concatena con getLine para darnos linea de error
    die ('Error' . $e->getMessage());
    echo "Linea del error" .  $e->getLine();

}


//-------------------------------PAGINACION-------------------------


for ($i=1; $i<=$total_paginas; $i++) {

    echo " <a href='?pagina=" . $i . "'>" . $i . "</a>  ";

}


?>