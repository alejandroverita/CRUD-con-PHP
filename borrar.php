<?php

include("conexion.php");

$id=$_GET["id"];

//la $base que esta dentro de conexion.php
$base->query("DELETE FROM DATOS_USUARIOS WHERE ID='$id'"); //variable id que es donde hemos almacenado lo que vienen en la URL


//redirigimos al archivo index de donde partimos
header("Location:index.php");


?>