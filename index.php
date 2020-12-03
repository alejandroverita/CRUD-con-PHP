<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>CRUD</title>
<link rel="stylesheet" type="text/css" href="hoja.css">


</head>

<body>
<?php

include("conexion.php");

//ejecutar instruccion sql que devuelva todos los registros almacenados y que se almacene en un array de objetos
//$conexion=$base->query("SELECT * FROM DATOS_USUARIOS");

//fetchAll permitia varios parametros dependiendo de lo que se quiere
//$registros=$conexion->fetchAll(PDO::FETCH_OBJ); //SE ALMACENA OBJETO ARRAY


//-------------------------PAGINACION------------------------

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
$sql_total="SELECT * FROM DATOS_USUARIOS";

//Sentencia preparada que devuelve todos los registros selecionados
$resultado=$base->prepare($sql_total);

$resultado->execute(array());

//cuantos rergistros nos devuelve consulta sql

$num_filas=$resultado->rowCount(); //cuenta filas que tengo dentro del array

//averiguar cuantas paginas va a tener nuestra paginacion
$total_paginas=ceil($num_filas/$tamagno_paginas); //evuelve redonder el numero la funcion CEIL



//---------------------------------------------------------------



$registros=$base->query("SELECT * FROM DATOS_USUARIOS LIMIT $empezar_desde, $tamagno_paginas")->fetchAll(PDO::FETCH_OBJ);

if (isset($_POST["cr"])) {
  $nombre=$_POST["Nom"];
  $apellido=$_POST["Ape"];
  $direccion=$_POST["Dir"];

  $sql="INSERT INTO DATOS_USUARIOS (NOMBRE, APELLIDO, DIRECCION) VALUES (:nom, :ape, :dir)";

  $resultado=$base->prepare($sql);

  $resultado->execute(array(":nom"=>$nombre, ":ape"=>$apellido, ":dir"=>$direccion));

  header("Location:index.php");

}


?>

<h1>CRUD<span class="subtitulo">Create Read Update Delete</span></h1>

<form action ="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">

  <table width="50%" border="0" align="center">
    <tr >
      <td class="primera_fila">Id</td>
      <td class="primera_fila">Nombre</td>
      <td class="primera_fila">Apellido</td>
      <td class="primera_fila">Dirección</td>
      <td class="sin">&nbsp;</td>
      <td class="sin">&nbsp;</td>
      <td class="sin">&nbsp;</td>
    </tr> 
   

		<?php
    foreach($registros as $persona):?>

   	<tr>
      <td> <?php echo $persona->ID?></td>
      <td> <?php echo $persona->NOMBRE?></td>
      <td> <?php echo $persona->APELLIDO?></td>
      <td> <?php echo $persona->DIRECCION?></td>

<!-- pasando id por la url con ?nombre=valor- abrir php y pasarle que me escriba en la url el propiedad del objeto persona que se encuente evaluando el id -->

      <td class="bot"><a href="borrar.php?id=<?php echo $persona->ID?>"><input type='button' name='del' id='del' value='Borrar'></a></td>
      <td class='bot'><a href="editar.php?id=<?php echo $persona->ID?> & nom=<?php echo $persona->NOMBRE?> & ape=<?php echo $persona->APELLIDO?> & dir= <?php echo $persona->DIRECCION?>">
      <input type='button' name='up' id='up' value='Actualizar'></a></td>
    </tr> 

    <?php
    endforeach;
    ?>


	<tr>
	<td></td>
      <td><input type='text' name='Nom' size='10' class='centrado'></td>
      <td><input type='text' name='Ape' size='10' class='centrado'></td>
      <td><input type='text' name=' Dir' size='10' class='centrado'></td>
      <td class='bot'><input type='submit' name='cr' id='cr' value='Insertar'></td></tr>    
      <tr><td colspan="4"><?php
//-------------------------------PAGINACION-------------------------

$ant = $pagina - 1;
$sig = $pagina + 1;
if ($pagina > 1) { //Colocar anterior si la página es mayor a 1
  echo "<a href='?pagina=$ant'> Anterior </a>";
}
for ($i = 1; $i <= $total_paginas; $i++) {

  echo "<a href='?pagina= $i'>" . $i . "</a>  "; //Mandamos el valor de i a la misma página
}
if ($pagina < $total_paginas) { //Colocar siguiente siempre y cuando la página sea menor al número total de páginas
  echo "<a href='?pagina=$sig'> Siguiente </a>";
}

?>           
Pag. <?php echo " " . $pagina . " / " . $total_paginas?></td></tr>
  </table>
</form>



<p>&nbsp;</p>
</body>
</html>