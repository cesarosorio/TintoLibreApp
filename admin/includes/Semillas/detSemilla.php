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
    $volver = 'verpsemillas';
    $menu = 'menu_mvsem';
}

?>

<ol class="breadcrumb"> 
    <li class="breadcrumb-item">Menú de opciones.</li>
    <li class="breadcrumb-item">INFORMACIÓN DE MIS SEMILLAS.</li>
    <li class="breadcrumb-item active"><strong>Semilla: </strong><?php echo $Nombre_Semilla ?></li>
</ol>

<div class="row"> 
  <div class="col-md-12" align="center"><strong>INFORMACIÓN DE LA SEMILLA</strong></div>
  
  <div class="col-md-12" align="center"><hr></div>

    <div class="col-md-3"><strong>Nombre</strong></div>
    <div class="col-md-3" align='center'><?php echo $Nombre_Semilla ?></div>
    <div class="col-md-3"><strong>Fecha de creación</strong></div>
    <div class="col-md-3" align='center'><?php echo $Fecha_Creacion ?></div>

  <div class="col-md-12" align="center"><hr></div>

    <div class="col-md-3"><strong>Día(s) límite de pago</strong></div>
    <div class="col-md-3" align='center'><?php echo $TipoPago ?></div>
    <div class="col-md-3"><strong>Aporte Social</strong></div>
    <div class="col-md-3" align='center'>$<?php echo number_format($aportesocial, 0) ?></div>

  <div class="col-md-12" align="center"><hr></div>

    <div class="col-md-3"><strong>Mínimo de consignación</strong></div>
    <div class="col-md-3" align='center'>$<?php echo number_format($minimo, 0) ?></div>
    <div class="col-md-3"><strong>Máximo de consignación</strong></div>
    <div class="col-md-3" align='center'>$<?php echo number_format($maximo, 0) ?></div>

  <div class="col-md-12" align="center"><hr></div>


    <div class="col-md-3"><strong>Acta de conformación</strong></div>
    <div class="col-md-3" align='center'><a title='¡Click acá para ver el acta!' href='<?php echo $Cop ?>' target='_blank'><i class='fa fa-file-pdf-o' aria-hidden='true'></i></a></div>
    <div class="col-md-3"><strong>Fecha de cierre de semilla</strong></div>
    <div class="col-md-3" align='center'><?php echo $FechaCierre ?></div>

  <div class="col-md-12" align="center"><hr></div>

    <div class="col-md-3"><strong>Estado de la semilla </strong></div>
    <div class="col-md-3" align='center'><?php echo $Nombre_Estado ?></div>
    <div class="col-md-3"><strong>Última modificación</strong></div>
    <div class="col-md-3" align='center'><?php echo $Ultima_Modificacion ?></div>

  <div class="col-md-12" align="center"><br></div>

</div>

<div class="alert alert-dark" role="alert">Acciones en la semilla</div>
<div class="row"> 
<?php if ($Lider_Semilla != $User)  { ?>
    <div class="col-md-12" align="center">No posee permisos de modificación de semillas </div> 
    <div class="col-md-12" align="center"><br></div>     
</div> 
<?php }else{

    if ($Estado_Semilla == 1) { ?>
        <div class="col-md-4">
            <input type='button' name='view' value='Incorporar persona' id='<?php echo $id_semilla ?>' class='btn btn-dark btn-block view_data'/>
        </div> 

        <div class="col-md-4">
            <input type='button' name='view' value='Modificar semilla' id='<?php echo $id_semilla ?>' class='btn btn-dark btn-block view_data2'/>
        </div>

        <div class="col-md-4">
            <input type='button' name='view' value='Cambiar Estado de la semilla' id='<?php echo $id_semilla ?>' class='btn btn-dark btn-block view_data3'/>
        </div>
    <?php }elseif($Estado_Semilla == 4 OR $Estado_Semilla == 5) { ?>
        <div class="col-md-12" align="center">
            No se pueden puede modificar la semilla en este estado
        </div> 
    <?php }else{ ?>
        <div class="col-md-8" align="center">
            No se pueden puede modificar la semilla en este estado
        </div>

        <div class="col-md-4">
            <input type='button' name='view' value='Cambiar Estado de la semilla' id='<?php echo $id_semilla ?>' class='btn btn-dark btn-block view_data3'/>
        </div> 
    <?php } ?>    
</div> 
<br>

<div class="alert alert-dark" role="alert">Integrantes de la semilla</div>

<?php } 

if ($Estado_Semilla == 4 OR $Estado_Semilla == 5) {?>

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


 
<?php }else{?>

    
<div class="row">
  <div align="center" class="col-md-3"><strong>Nombre</strong></div>
  <div align="center" class="col-md-1"><strong>Meta</strong></div> 
  <div align="center" class="col-md-1"><strong>Valor ahorrado</strong></div>
  <div align="center" class="col-md-1"><strong>Incentivos ahorro</strong></div>
  <div align="center" class="col-md-1"><strong>Rol</strong></div>
  <div align="center" class="col-md-1"><strong>Estado</strong></div>
  <div align="center" class="col-md-2"><strong>Editar</strong></div>
  <div align="center" class="col-md-2"><strong>Multar</strong></div> 
  
  <div class="col-md-12"><hr></div> 
  
  <?php $Nro = 0; while ($Lee=$MP->fetch_array(MYSQLI_BOTH)) { $Nro++;
  $valorh = ($Lee['valorah'] < 0) ? 0 : number_format($Lee['valorah'], 0);
  echo "
    <div class='col-md-3' align='center'>".$Lee['Name']."</div>
    <div class='col-md-1' align='right'>$".number_format($Lee['Meta_personal'])."</div>
    <div class='col-md-1' align='right'>$".$valorh."</div>
    <div class='col-md-1' align='right'>$".number_format($Lee['Incentivo'], 0)."</div>
    <div class='col-md-1' align='center'>".$Lee['Rol']."</div>
    <div class='col-md-1' align='center'>".$Lee['Estado']."</div>";
    if ($Estado_Semilla == 1 AND $Lider_Semilla == $User) {
        echo "<div class='col-md-2'><form action='../admin/index.php?contenido=CambiarRol' method='POST' class='form-register'>
            <input type='hidden' name='Cedula' value='".$Lee['Id_usuario']."'>
            <input type='hidden' name='Sen' value='".$_GET['Semilla']."'>
            <input name='CambRol' class='btn btn-dark btn-block' type='submit' value='Editar'/></form>
        </div>";    
    }elseif($Lider_Semilla != $User){
        echo "<div class='col-md-2'>No posee permisos de edición</div>";
    }else{
        echo "<div class='col-md-2' align='center'><i class='fa fa-ban' aria-hidden='true'></i></div>";
    }
    if ($User == $IdPersRol OR $Lider_Semilla == $User AND $Estado_Semilla == 2 OR $Estado_Semilla == 3) {
        echo "<div class='col-md-2'><form action='?contenido=verMvto' method='POST' class='form-register'>
            <input type='hidden' name='Semilla' value='".$_GET['Semilla']."'>
            <input type='hidden' name='Ruta' value='detSemilla'>
            <input type='hidden' name='Presidente' value='".$User."'>
            <input name='VerMv' class='btn btn-danger btn-block' type='submit' value='Multar'/></form></div>";
    }else{
        echo "<div class='col-md-2' align='center'><i class='fa fa-ban' aria-hidden='true'></i></div>";
    }
    
  echo "<div class='col-md-12'><hr></div>";
} 

if ($Nro == 0) {
  echo "<div class='col-md-12' colspan='8' align='center'>No hay integrantes inscritos.</div>"; 
} ?> 

</div>
<?php if ($Estado_Semilla == 2 OR $Estado_Semilla == 3) { ?>  
  <br>
  <form action='?contenido=verMvto' method='POST' class='form-register'>
    <input type='hidden' name='Semilla' value="<?php echo $_GET['Semilla'] ?>">  
    <input name='VerMv' class='btn btn-dark btn-block' type='submit' value='Ver movimientos'/>
  </form>
  <br>
<?php } ?>

<?php } ?>    
<div class="alert alert-dark" role="alert">Multas a la semilla</div>

<div class='row'>

  <div class='col-md-1' align="center"><strong>Nro</strong></div>
  <div class='col-md-3' align="center"><strong>Presidente</strong></div>
  <div class='col-md-2' align="center"><strong>Nombre</strong></div>
  <div class='col-md-3' align="center"><strong>Observación</strong></div>
  <div class='col-md-1' align="center"><strong>Valor</strong></div>
  <div class='col-md-1' align="center"><strong>Fecha de creación</strong></div>
  <div class='col-md-1' align="center"><strong>Estado</strong></div>
    
  <div class='col-md-12' align="center"><hr></div>

  <?php $Nro = 0; while ($Lee=$MU->fetch_array(MYSQLI_BOTH)) { $Nro++;
    echo "
        <div class='col-md-1' align='center'>".$Nro."</div>
        <div class='col-md-3'>".($Lee['Name'])."</div>
        <div class='col-md-2'>".($Lee['NombreMulta'])."</div>
        <div class='col-md-3'>".($Lee['ObserMultas'])."</div>
        <div class='col-md-1' align='right'>$".number_format($Lee['Valor_Multa'], 0)."</div>
        <div class='col-md-1' align='right'>".$Lee['Fecha_Creacion']."</div>
        <div class='col-md-1'>".$Lee['Estado']."</div>
    
        <div class='col-md-12'><hr></div>";
    }

    if ($IdPersRol == $User OR $Lider_Semilla == $User AND $Estado_Semilla == 1) {
    echo "
        <div class='col-md-12'>
        <form action='?contenido=asigMultas' method='POST'>
          <input type='hidden' name='Semilla' value='".$_GET['Semilla']."'>
          <input type='submit' class='btn btn-dark btn-block' name='Ver' value='Agregar Multa'/>
        </form></div>";

}elseif($Nro == 0){
  echo "<div class='col-md-12' align='center'>No hay multas creadas al momento.</div>";
} ?>

  <div class='col-md-12' align='center'><hr></div>

     <?php if($Estado_Semilla == 4){ ?>
          <div class='col-md-12' align='center'>
          <form action='?contenido=procesos_ciclonuevo' method='POST'>
          <input type='hidden' name='Semilla' value='<?php echo $_GET['Semilla']; ?>'>
          <input type='submit' class='btn btn-dark btn-block' name='nuevociclo' value='Crear nuevo Ciclo'/>
          </form>
          </div>
     <?php } ?>


</div>

<br>

<script>
 $(document).ready(function(){  
      $('#add').click(function(){  
           $('#insert').val("Insert");  
           $('#insert_form')[0].reset();  
      }); 
      $(document).on('click', '.view_data', function(){  
           var employee_id = $(this).attr("id");  
           if(employee_id != '')  
           {  
                $.ajax({  
                     url:"includes/Semillas/AggIntegSem.php",  
                     method:"POST",  
                     data:{employee_id:employee_id},  
                     success:function(data){  
                          $('#employee_detail').html(data);  
                          $('#dataModal').modal('show');  
                     }  
                });  
           }            
      });  
 });  
 </script>
 <div id="dataModal" class="modal fade bd-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">  
      <div class="modal-dialog modal-lg">  
           <div class="modal-content">  
                <div class="modal-header">
                  <h4 class="modal-title">Agregar persona a la semilla <?php echo $Nombre_Semilla ?></h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>      
                </div>  
                <div class="modal-body" id="employee_detail">  
                </div> 
                 
           </div>  
      </div>  
 </div>

 <script>
 $(document).ready(function(){  
      $('#add').click(function(){  
           $('#insert').val("Insert");  
           $('#insert_form')[0].reset();  
      }); 
      $(document).on('click', '.view_data2', function(){  
           var employee_id = $(this).attr("id");  
           if(employee_id != '')  
           {  
                $.ajax({  
                     url:"includes/Semillas/EstMetaGr.php",
                     method:"POST",  
                     data:{employee_id:employee_id},  
                     success:function(data){  
                          $('#employee_detail2').html(data);  
                          $('#dataModal2').modal('show');  
                     }  
                });  
           }            
      });  
 });  
 </script>
 <div id="dataModal2" class="modal fade bd-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">  
      <div class="modal-dialog modal-lg">  
           <div class="modal-content">  
                <div class="modal-header">
                  <h4 class="modal-title">Modificar la semilla <?php echo $Nombre_Semilla ?></h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>      
                </div>  
                <div class="modal-body" id="employee_detail2">  
                </div> 
                 
           </div>  
      </div>  
 </div>

<script>
 $(document).ready(function(){  
      $('#add').click(function(){  
           $('#insert').val("Insert");  
           $('#insert_form')[0].reset();  
      }); 
      $(document).on('click', '.view_data3', function(){  
           var employee_id = $(this).attr("id");  
           if(employee_id != '')  
           {  
                $.ajax({  
                     url:"includes/Semillas/CambiarEstado.php",
                     method:"POST",  
                     data:{employee_id:employee_id},  
                     success:function(data){  
                          $('#employee_detail3').html(data);  
                          $('#dataModal3').modal('show');  
                     }  
                });  
           }            
      });  
 });  
 </script>
 <div id="dataModal3" class="modal fade bd-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">  
      <div class="modal-dialog modal-lg">  
           <div class="modal-content">  
                <div class="modal-header">
                  <h4 class="modal-title">¿Esta seguro de cambiar el estado de la semilla?</h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>      
                </div>  
                <div class="modal-body" id="employee_detail3">  
                </div> 
                 
           </div>  
      </div>  
 </div>

 <script>
 $(document).ready(function(){  
      $('#add').click(function(){  
           $('#insert').val("Insert");  
           $('#insert_form')[0].reset();  
      }); 
      $(document).on('click', '.view_data_st', function(){  
           var employee_id = $(this).attr("id");  
           if(employee_id != '')  
           {  
                $.ajax({  
                     url:"includes/Semillas/Comprobante_cierre.php",
                     method:"POST",  
                     data:{employee_id:employee_id},  
                     success:function(data){  
                          $('#employee_detail_st').html(data);  
                          $('#dataModal_st').modal('show');  
                     }  
                });  
           }            
      });  
 });  
 </script>
 <div id="dataModal_st" class="modal fade bd-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">  
      <div class="modal-dialog modal-lg">  
           <div class="modal-content">  
                <div class="modal-header">
                  <h4 class="modal-title">Agregar comprobante de cierre</h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>      
                </div>  
                <div class="modal-body" id="employee_detail_st">  
                </div> 
                 
           </div>  
      </div>  
 </div>
