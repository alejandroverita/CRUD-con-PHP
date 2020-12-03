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

$registros=$base->query("SELECT * FROM DATOS_USUARIOS")->fetchAll(PDO::FETCH_OBJ);

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
  </table>
</form>
<p>&nbsp;</p>
</body>
</html>