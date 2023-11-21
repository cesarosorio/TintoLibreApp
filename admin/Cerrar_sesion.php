<?php
session_start();
include("../conexion.php");
@$token=$_POST['N_usuario'];
@$Acces=$_POST['N_accesos']-1;
$hoyFin = date("d/m/Y");
date_default_timezone_set('america/bogota');
$Hora_Fin=date("H:i:s");
$RegFin=mysqli_query($conexion,"UPDATE `control_accesos` SET `Fecha_fin_sesion`='$hoyFin',`Hora_fin_sesion`='$Hora_Fin' WHERE `Id_usuario`='$token' AND `Fecha_ingreso`= '$hoyFin' AND `Item_acceso`='$Acces'");
session_destroy();
echo "<script>window.location='../index.php';</script>";
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <title>Finvault</title>
  
</head>

<body ">
</body>
</html>