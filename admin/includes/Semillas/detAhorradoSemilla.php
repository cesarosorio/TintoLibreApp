<?php 

$R=mysqli_fetch_assoc($conexion->query("SELECT ms.Lider_Semilla, ms.Estado_Semilla, ms.FechaCierre, es.Nombre_Estado, ms.id_semilla, ms.Nombre_Semilla, ms.Fecha_Creacion, ms.ActaSemilla, CASE WHEN ms.TipoPago = 2 THEN CONCAT('Quincenal (Días: ', d.quimaximo, ' y ', d.quimaxidos, ')') ELSE CONCAT('Mensual ', '(Día: ', d.mesmaximo, ')') END AS TipoPago, ms.aportesocial, case when ms.Ultima_Modificacion is null then 'Sin modificar' else ms.Ultima_Modificacion end as Ultima_Modificacion, ms.minimo, ms.maximo FROM conformacion_semilla ms INNER JOIN estadosemillas es on es.Id_Estado = ms.Estado_Semilla LEFT JOIN diasparapago d on d.Id_semilla = ms.Id_Semilla WHERE ms.id_semilla =  ".$_GET['Semilla']));
$id_semilla = $R['id_semilla'];
$Nombre_Semilla = $R['Nombre_Semilla'];
$Fecha_Creacion = $R['Fecha_Creacion'];
$ActaSemilla = $R['ActaSemilla'];
$Cop = substr($ActaSemilla, 6);
$TipoPago = $R['TipoPago'];
$aportesocial = $R['aportesocial'];
$Ultima_Modificacion = $R['Ultima_Modificacion']; 
$Nombre_Estado = $R['Nombre_Estado'];
$Estado_Semilla = $R['Estado_Semilla'];
$FechaCierre = $R['FechaCierre'];
$Lider_Semilla = $R['Lider_Semilla'];
$minimo = $R['minimo'];
$maximo = $R['maximo'];

$VerIntegrantes ="SELECT ins.Rol as IdRol, (SELECT SUM(m.Valor) FROM mv_meta_semilla m WHERE m.Id_semilla = ins.Id_semilla and m.Id_usuario = ins.Id_persona and m.tipo in (2, 3)) as valorah , (SELECT SUM(m.Valor) FROM mv_meta_semilla m WHERE m.Id_semilla = ins.Id_semilla and m.Id_usuario = ins.Id_persona and m.tipo = 1 ) Incentivo, u.Id_usuario, u.Name, ins.Fecha, CASE WHEN ins.Estado = 1 THEN 'Activo' ELSE 'Inactivo' END AS Estado, Meta_personal, rs.Nombre AS Rol FROM integrantes_semilla ins INNER JOIN usuario u on u.Id_usuario = ins.Id_persona INNER JOIN rol_semilla rs ON rs.Id = ins.Rol WHERE ins.id_semilla = ".$_GET['Semilla']." ORDER BY u.Name ASC";
$MP = $conexion->query($VerIntegrantes);

$VerIntegrantes ="SELECT st.id, st.Valor, SUBSTRING(st.Comprobante, 7) Comprobante, us.Name FROM semillas_terminadas st inner join usuario us on us.Id_usuario = st.Id_persona WHERE st.id_semilla = ".$_GET['Semilla']." ORDER BY us.Name ASC";
$ME = $conexion->query($VerIntegrantes);

$VerPre ="SELECT Id_persona FROM integrantes_semilla WHERE Rol = 2 AND id_semilla = ".$_GET['Semilla'];
$MPR = $conexion->query($VerPre);
$Rol = mysqli_fetch_assoc($MPR);
$nro = mysqli_num_rows($MPR);
$Val = ($nro == 0) ? $IdPersRol = 0 : $IdPersRol = $Rol['Id_persona'];

$MulSem = "SELECT mus.id_semilla, mus.NombreMulta, mus.ObserMultas, mus.Valor_Multa, mus.Fecha_Creacion, case when mus.Estado = 1 then 'Activo' else 'Inactivo' end as Estado, u.Name FROM multas_semilla mus INNER JOIN usuario u on u.Id_usuario = mus.Presidente WHERE mus.id_semilla  = ".$_GET['Semilla'];
$MU = $conexion->query($MulSem);

if ($Permiso == 2) {
    $volver = 'viewSemilla';
    $menu = 'MenuSemillas';
}else{
    $volver = 'verpsemillasreglas';
    $menu = 'menu_mvsem';
}

?>

<ol class="breadcrumb"> 
    <li class="breadcrumb-item">Menú de opciones.</li>
    <li class="breadcrumb-item">INFORMACIÓN DE MIS SEMILLAS.</li>
    <li class="breadcrumb-item active"><strong>Semilla: </strong><?php echo $Nombre_Semilla ?></li>
</ol>
<div class="d-flex flex-column w-100">
   <div class="d-flex w-100 justify-content-center text-center"><h5><strong>INTEGRANTES Y AHORRADO EN LA SEMILLA</strong></h5></div>
   <div class='col-md-12'><hr></div>
  <?php

   if ($Estado_Semilla == 4 OR $Estado_Semilla == 5) {?>
      <div class="d-flex w-100 justify-content-center">
         <div class="row">
            <div align="center" class="col-md-4"><strong>Nombre</strong></div> 
            <div align="center" class="col-md-4"><strong>Valor Entregado</strong></div> 
            <div align="center" class="col-md-4"><strong>Comprobante</strong></div> 

            <div class="col-md-12"><hr></div> 

               <?php $Nro = 0; while ($Lee=$ME->fetch_array(MYSQLI_BOTH)) { $Nro++;
               
               echo "
                  <div class='col-md-4' align='center'>".$Lee['Name']."</div>
                  <div class='col-md-4' align='right'>$".number_format($Lee['Valor'])."</div>";
                  if($Lee['Comprobante'] == NULL){
                        echo "<div class='col-md-4' align='right'><input type='button' name='view' value='Cargar soporte' id='".$Lee['id']."' class='btn btn-dark btn-block view_data_st'/></div>";
                  }else{
                        echo "<div class='col-md-4' align='center'><a title='¡Click acá para ver el acta!' href='".$Lee['Comprobante']."' target='_blank'><i class='fa fa-file-pdf-o' aria-hidden='true'></i></a></div>";
                  }

                  echo "<div class='col-md-12'><hr></div>";   
                  
                  } ?>

         </div>
         
      </div>


   
   <?php }else{?>

      <?php $Nro = 0; while ($Lee=$MP->fetch_array(MYSQLI_BOTH)) { $Nro++;
      $valorh = ($Lee['valorah'] < 0) ? 0 : number_format($Lee['valorah'], 0);
      ?>
         <div class="d-flex w-100 justify-content-center"><h5><strong><?php echo $Lee['Name'] ?></strong></h5></div>
         <div class="d-flex flex-row justify-content-between custom-row-reglas">
            <div class="d-flex w-100 justify-content-end custom-column-reglas padding-right-5 text-align-end custom-border-right-reglas"><strong>Meta</strong></div>
            <div class="d-flex w-100 justify-content-start custom-column-reglas padding-left-5"><?php echo number_format($Lee['Meta_personal']) ?></div>
         </div>
         <div class="d-flex flex-row justify-content-between custom-row-reglas">
            <div class="d-flex w-100 justify-content-end custom-column-reglas padding-right-5 text-align-end custom-border-right-reglas"><strong>Meta</strong></div>
            <div class="d-flex w-100 justify-content-start custom-column-reglas padding-left-5"><?php echo number_format($Lee['Meta_personal']) ?></div>
         </div>
         <div class="d-flex flex-row justify-content-between custom-row-reglas">
            <div class="d-flex w-100 justify-content-end custom-column-reglas padding-right-5 text-align-end custom-border-right-reglas"><strong>Valor ahorrado</strong></div>
            <div class="d-flex w-100 justify-content-start custom-column-reglas padding-left-5"><?php echo $valorh ?></div>
         </div>
         <div class="d-flex flex-row justify-content-between custom-row-reglas">
            <div class="d-flex w-100 justify-content-end custom-column-reglas padding-right-5 text-align-end custom-border-right-reglas"><strong>Incentivos ahorro</strong></div>
            <div class="d-flex w-100 justify-content-start custom-column-reglas padding-left-5"><?php echo number_format($Lee['Incentivo'], 0) ?></div>
         </div>
         <div class="d-flex flex-row justify-content-between custom-row-reglas">
            <div class="d-flex w-100 justify-content-end custom-column-reglas padding-right-5 text-align-end custom-border-right-reglas"><strong>Rol</strong></div>
            <div class="d-flex w-100 justify-content-start custom-column-reglas padding-left-5"><?php echo $Lee['Rol'] ?></div>
         </div>
         <div class="d-flex flex-row justify-content-between custom-row-reglas">
            <div class="d-flex w-100 justify-content-end custom-column-reglas padding-right-5 text-align-end custom-border-right-reglas"><strong>Estado</strong></div>
            <div class="d-flex w-100 justify-content-start custom-column-reglas padding-left-5"><?php echo $Lee['Estado'] ?></div>
         </div>
         <br>
         <div class='col-md-12'><hr></div>
      <?php 
      } 

      if ($Nro == 0) {
      echo "<div class='d-flex w-100 text-align-center justify-content-center' align='center'>No hay integrantes inscritos.</div>"; 
      } ?> 
   <?php } ?> 
</div>