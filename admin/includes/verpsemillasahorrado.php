<?php

//error_reporting(0);
$query = $conexion -> query ("SELECT C.id_semilla, C.Nombre_Semilla, C.FECHA_CREACION, U.NAME AS LIDER, E.NOMBRE_ESTADO AS ESTADO, CASE WHEN C.ULTIMA_MODIFICACION IS NULL THEN 'NO SE HA MODIFICADO' ELSE C.ULTIMA_MODIFICACION END MODIFICACION, IG.ROL FROM conformacion_semilla C INNER JOIN usuario U ON U.ID_USUARIO = C.LIDER_SEMILLA INNER JOIN estadosemillas E ON E.ID_ESTADO = C.ESTADO_SEMILLA INNER JOIN integrantes_semilla IG ON IG.ID_SEMILLA = C.ID_SEMILLA WHERE C.Estado_Semilla IN (1, 2, 3) AND IG.ID_PERSONA = $User"); ?>

<ol class="breadcrumb"> 
    <li class="breadcrumb-item">Menú de opciones.</li>
    <li class="breadcrumb-item active">Ver semillas.</li>
</ol>

<meta charset="utf-8">
<div class="container-fluid">
  <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0"> 
    <thead>
      <tr> 
        <td>Nombre</td> 
        <td><i class='fa fa-search' aria-hidden='true'></i></td>  
      </tr>
    </thead>
    <tbody>
      <?php while ($Lee = mysqli_fetch_array($query)) { 
        echo "<tr>
          <td>".$Lee['Nombre_Semilla']."</td>
          <td style='white-space: nowrap'>
            <a href='?contenido=detAhorradoSemilla&Semilla=".$Lee['id_semilla']."'><i class='fa fa-search' aria-hidden='true'></i></a>
          </td>  
        </tr>";
      } ?>
    </tbody>
  </table>
</div>
 