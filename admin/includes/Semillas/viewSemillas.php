<?php $query = $conexion -> query ("SELECT C.id_semilla, C.Nombre_Semilla, C.Fecha_Creacion, u.Name AS Lider, e.Nombre_Estado as Estado, CASE WHEN C.Ultima_Modificacion IS NULL THEN 'No se ha modificado' ELSE C.Ultima_Modificacion END Modificacion FROM conformacion_semilla C INNER JOIN usuario u ON u.Id_usuario = C.Lider_Semilla INNER JOIN estadosemillas e ON e.Id_Estado = C.Estado_Semilla WHERE C.Lider_Semilla = $User"); ?>
<ol class="breadcrumb"> 
    <li class="breadcrumb-item">Menú de opciones.</li>
    <li class="breadcrumb-item active">INFORMACIÓN DE MIS SEMILLAS</li>
</ol>

<meta charset="utf-8">
<div class="container-fluid">
  <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0"> 
    <thead>
      <tr> 
        <td>Nombre</td>
        <td>Fecha de creación</td> 
        <td>Lider de la semilla</td> 
        <td>Estado</td> 
        <td>Ultima modificacion</td>  
        <td><i class='fa fa-search' aria-hidden='true'></i></td>  
      </tr>
    </thead>
    <tbody>
      <?php while ($Lee = mysqli_fetch_array($query)) { 
        echo "<tr>
          <td>".$Lee['Nombre_Semilla']."</td>
          <td>".$Lee['Fecha_Creacion']."</td>
          <td>".$Lee['Lider']."</td>
          <td>".$Lee['Estado']."</td>
          <td>".$Lee['Modificacion']."</td>
          <td style='white-space: nowrap'>
            <a href='?contenido=detSemilla&Semilla=".$Lee['id_semilla']."'><i class='fa fa-search' aria-hidden='true'></i></a>
          </td>  
        </tr>";
      } ?>
    </tbody>
  </table>
</div>
 