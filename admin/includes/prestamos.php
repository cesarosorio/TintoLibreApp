<?php 

include 'conexion.php';
if (isset($_POST['SolPrestamo'])) {
    $id_semilla = $_POST['Lider'];
    $Id_responsable = $_POST['Responsable'];
    $ValPrestamo = $_POST['ValPrestamo'];

    $R=mysqli_fetch_assoc($conexion->query("SELECT cs.MontoPrestamo, (SELECT SUM(iss.Valor) FROM mv_meta_semilla iss WHERE iss.Id_usuario = $Id_responsable and iss.Id_semilla = cs.Id_Semilla ) as Ahorro FROM conformacion_semilla cs WHERE cs.Id_Semilla = $id_semilla"));

    $MontoMaximo = $R['Ahorro']*$R['MontoPrestamo'];
    if ($ValPrestamo  > $MontoMaximo) {
      ?><script languaje="javascript">
        alert("¡Solicito mas dinero del monto autorizado en la semilla, lo sentimos!");
        window.location="?contenido=menus_prestamos";
      </script> <?php
    }else{

      $Justificacion = $_POST['Justificacion'];
      date_default_timezone_set('america/bogota');
      $FechaSolicitud=date("Y-m-d H:i:s"); 

      $SolPrss = "INSERT INTO prestamos (Id_responsable, id_semilla, ValPrestamo, ValOrigin, Justificacion, FechaSolicitud, Estado, Aprobado) VALUES ($Id_responsable, $id_semilla, $ValPrestamo, $ValPrestamo, '$Justificacion', '$FechaSolicitud', 1, 2)";

      if ($conexion -> query($SolPrss)) { 

      $R=mysqli_fetch_assoc($conexion->query("SELECT u.Name FROM usuario u where u.Id_usuario = $Id_responsable"));
      $Responsable = $R['Name'];

      $p=mysqli_fetch_assoc($conexion->query("SELECT MAX(id)+1 as prestamo from prestamos"));
      $prestamo = $p['prestamo'];
      
      $DatMultas= $conexion->query("SELECT iss.Id_persona, u.Name, case when u.Correo is null then 'No' else u.Correo end as Correo from integrantes_semilla iss left join usuario u on u.Id_usuario = iss.Id_persona where iss.Id_semilla = $id_semilla"); 
      $npersona = mysqli_num_rows($DatMultas);
      $npersonas = $npersona - 1 ;
      
      $Votaciones = $conexion -> query("INSERT INTO votaciones(Id_semilla, Id_prestamo, Id_persona, Nombre, Observaciones, FechaSol, Integrantes, Estado) VALUES ($id_semilla, $prestamo, 0, 'Solicitud de prestamo', '$Justificacion', NOW(), $npersonas, 1)");

      while ($Le = mysqli_fetch_array($DatMultas)) { 
        if ($Le['Correo'] != 'No') {
          $cabeceras = 'From: admin@tusemilla.com.co';
          $asunto = utf8_decode("Tu voto cuenta, ".utf8_decode($Le['Name'])." solicitó un préstamo a la semilla.");
          $Correo = $Le['Correo'];
          $mensaje="¡Hola, ".utf8_decode($Le['Name'])."! 

Estás recibiendo este correo porque﻿ ".utf8_decode($Responsable)." ha solicitado un préstamo de $".number_format($ValPrestamo)."﻿, por la siguiente razón: ".utf8_decode($Justificacion).".

﻿De acuerdo al acta de la semilla es necesario que todos los integrantes indiquen si están de acuerdo o no en realizar este préstamo. Por tal razón, debes acceder al link que encontrarás al final de este correo e indicar si lo apruebas o no.

Te recordamos que el préstamo se aprobará si más de la mitad de los integrantes votan indicando que sí lo aprueba.

No dudes en contactarte con tu líder de semilla si tienes alguna duda.

Att: TintoLibre";


mail($Correo, $asunto, $mensaje, $cabeceras);
        }
      }
      
        ?><script languaje="javascript">
          alert("¡Se realizo con exito la solicitud!");
          window.location="?contenido=menus_prestamos";
        </script> <?php
      }else{
        ?><script languaje="javascript">
          alert("¡Algo ocurrio, intenta de nuevo!");
          window.location="?contenido=menus_prestamos";
        </script> <?php
      }

    }
} 

if (isset($_POST['AgregarVoto'])) {
  
  $opcion = $_POST['opcion'];
  $Persona = $_POST['Persona'];
  $Id_v = $_POST['Id_v'];
  $integrantes = $_POST['integrantes'];
  $Prestamo = $_POST['Prestamo'];

  $aggvoto = "INSERT INTO votaciones_part (id_votacion, id_persona, opcion, fecha) VALUES ($Id_v, '$Persona', $opcion, NOW())";

  if($conexion->query($aggvoto)){
    $R=mysqli_fetch_assoc($conexion -> query("SELECT COUNT(opcion) as res from votaciones_part where id_votacion = $Id_v and opcion = 1"));
    $res = $R['res'];
    $val = ($res == 0) ? $apr = 0 : $apr = ($res/$integrantes)*100 ;
    echo $apr;
    if ($apr >= 50) {
      $conexion -> query("UPDATE prestamos SET Aprobado = 1 WHERE id = $Prestamo");
      ?><script languaje="javascript">
          alert("¡Se agrego el voto y además, se cerro la votacion! Muchas gracias");
          window.location="../index.php?contenido=votaciones";          
        </script> <?php
    }else{
      ?><script languaje="javascript">
          alert("¡Se agrego el voto, muchas gracias!");
          window.location="../index.php?contenido=votaciones";
        </script> <?php
    }
  }else{
    ?><script languaje="javascript">
      alert("¡Ocurrio algo, intenta de nuevo mas tarde!");
      window.location="../index.php?contenido=votaciones";
    </script> <?php

  }

}
