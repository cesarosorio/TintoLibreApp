<?php 
if (isset($_GET['Semilla'])) {

  $Sem = $_GET['Semilla'];
  $R=mysqli_fetch_assoc($conexion->query("SELECT Nombre_Semilla, Lider_semilla FROM conformacion_semilla WHERE id_semilla = ".$Sem)); 
  $Nombre_Semilla = $R['Nombre_Semilla'];
  $Lider_semilla = $R['Lider_semilla']; 

  $R=mysqli_fetch_assoc($conexion->query("SELECT Rol FROM integrantes_semilla iss WHERE iss.Id_persona = $User and id_semilla = ".$Sem)); 
  
  $Rol = (isset($R['Rol'])) ? $R['Rol'] : 0 ; 

  if (isset($_POST['AUser'])) {
    $segpers = "AND mv.Id_usuario = ".$_POST['AUser'];
    $P=mysqli_fetch_assoc($conexion->query("SELECT Name FROM usuario u WHERE u.Id_usuario = ".$_POST['AUser'])); 
    $Persona = $P['Name'];
    $MensajeAhorro = "<strong>Ahorro de:</strong> ".$P['Name'];
  }else{
    $segpers = " ";
    $Persona = "No elegida.";
    $MensajeAhorro = "<strong>Ahorro de:</strong> ".$Nombre_Semilla;
  }

  $Cons = "SELECT mv.Id_usuario, pp.Id prestamo, mv.Id, mv.id_semilla, us.Name Nombre, mv.Fecha, mv.Valor Ahorro, mv.AporteSocial Fondo, IFNULL(mm.Valor_multa, 0) Asociacion, IFNULL(mp.Capital, 0) Capital, IFNULL(mp.Id, 'Pr') IdPrestamo, IFNULL(mp.Intereses, 0) Intereses, IFNULL(mmi.Valor_Multa, 0) Valor_Multa, IFNULL(mmi.Id, 'Mt') IdMulta, SUBSTRING(mv.Comprobante, 7) Comprobante FROM mv_meta_semilla mv INNER JOIN usuario us ON us.Id_usuario = mv.Id_usuario LEFT JOIN multas_semilla ms ON ms.Id_semilla = mv.Id_semilla LEFT JOIN mv_multa_semilla mm ON mm.Id_multa = ms.Id AND mm.Id_mvto = mv.Id AND ms.NombreMulta = 'Otras deducciones' LEFT JOIN mv_multa_semilla mmi ON mmi.Id_multa = ms.Id AND mmi.Id_mvto = mv.Id AND ms.NombreMulta != 'Otras deducciones' LEFT JOIN mv_prestamos_sem mp ON mp.Id_mvto = mv.Id LEFT JOIN prestamos pp ON pp.Id_semilla = mv.Id_semilla AND pp.Id_responsable = mv.Id_usuario AND pp.Tipo = 2 and pp.Estado = 6 WHERE mv.Id_semilla = $Sem $segpers GROUP BY mv.Id ORDER BY mv.Fecha DESC";
  $MP = $conexion -> query ($Cons);
  $Multas = 0 ;
  $Ahorro = 0 ;

?>
 
<ol class="breadcrumb"> 
    <li class="breadcrumb-item">Menú de opciones.</li>
    <li class="breadcrumb-item">INFORMACIÓN DE MIS SEMILLAS.</li>
    <li class="breadcrumb-item active"><strong>Semilla:</strong> <?php echo $Nombre_Semilla  ?></li>
    <li class="breadcrumb-item active"><strong>Persona:</strong> <?php echo $Persona  ?></li>
</ol>


<form method='POST' class='form-register'>
  <div class="row">
   <div class="col-md-4">
      <div class="form-group">
        <label>A nombre de: </label> 
      </div>
    </div>

    <div class="col-md-4">
      <div class="form-group"> 
          <select list="AUser" class="form-control" type="text" name="AUser" required>  
            <option></option>
             <?php $Data = $conexion -> query("SELECT u.Id_usuario, CONCAT(u.Name) Nombre FROM conformacion_semilla cs inner join integrantes_semilla iss on iss.Id_semilla = cs.Id_Semilla inner join usuario u on u.Id_usuario = iss.Id_persona WHERE cs.estado_semilla in (2, 3) and iss.Estado = 1 AND cs.Id_Semilla = $Sem ORDER BY u.Name ASC");
            while ($Lee = mysqli_fetch_array($Data)) { 
              echo "<option value=".$Lee['Id_usuario'].">".$Lee['Nombre']."</option>";  
            } ?>
          </select> 
      </div>
    </div>

    <div class="col-md-4">
      <input type='hidden' name='Semilla' value="<?php echo $Sem ?>">  
      <input class='btn btn-dark btn-block' type='submit' value='Elegir persona'/>
    </form>
    </div>
</div> 


<div class="row"> 
    <div class="col-md-4"></div>
    <div class="col-md-4"></div>
    <div class="col-md-4">	        
    <form method='POST' class='form-register'>
        <input type='hidden' name='Semilla' value="<?php echo $Sem ?>">  
        <input name='VerMv' class='btn btn-dark btn-block' type='submit' value='Limpiar'/>
    </form>
    </div>
</div>

<br>

<meta charset="utf-8">
  <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0"> 
    <thead>
      <tr align="center">
        <th align="center">#</th> 
        <th align="center">Nombre</th> 
        <th align="center">Fecha</th> 
        <th align="center">Depósito</th> 
        <th align="center">Ahorro Individual</th> 
        <th align="center">Fondo Social</th> 
        <th align="center">Aporte Asociacion</th> 
        <th align="center">Préstamo</th> 
        <th align="center">Intereses préstamo</th> 
        <th align="center">Multa</th> 
        <th align="center"><i class='fa fa-file-pdf-o' aria-hidden='true'></i></th> 
        <th align="center">Alertar</th> 
        <th align="center">Multar</th>         
        <th align="center">P. Asociacion</th>         
      </tr>
    </thead>
    <tbody>
    <?php $nro=1; while ($Lee = mysqli_fetch_array($MP)) {

      $Recaudo = $Lee['Ahorro']+$Lee['Fondo']+$Lee['Asociacion']+$Lee['Capital']+$Lee['Intereses']+$Lee['Valor_Multa'];

      echo "<tr>
        <td>".$nro++."</td>
        <td>".utf8_encode($Lee['Nombre'])."</td>  
        <td>".($Lee['Fecha'])."</td>  
        <td align='right'>$".number_format($Recaudo, 0)."</td>   
        <td align='right'>$".number_format($Lee['Ahorro'], 0)."</td>   
        <td align='right'>$".number_format($Lee['Fondo'], 0)."</td>   
        <td align='right'>$".number_format($Lee['Asociacion'], 0)."</td>";
        if($Lee['IdPrestamo'] == 'Pr')
          echo "<td>Sin préstamo</td>";
        else
          echo "<td><input type='button' name='view' value='Ver' id='".$Lee['Id']."' class='btn btn-dark btn-block view_data'/></td>";
        
        echo "<td align='right'>$".number_format($Lee['Intereses'], 0)."</td>";
        if($Lee['IdMulta'] == 'Mt')
          echo "<td>Sin multa</td>";
        else
          echo "<td><input type='button' name='view' value='Ver' id='".$Lee['Id']."' class='btn btn-dark btn-block view_data'/></td>";
          
        echo "<td aling='center'><a title='¡Click acá para ver el acta!' href='".$Lee['Comprobante']."' target='_blank'><i class='fa fa-file-pdf-o' aria-hidden='true'></i></a></td>";
        if ($Rol == 2 or $Lider_semilla == $User) {
            echo "<td><form action='?contenido=alertar' method='POST' class='form-register'>
            <input type='hidden' name='Semilla' value='".$Lee['id_semilla']."'>
            <input type='hidden' name='Mvto' value='".$Lee['Id']."'>  
            <input type='hidden' name='Usuario' value='".$Lee['Id_usuario']."'>
            <input name='VerMv' class='btn btn-danger btn-block' type='submit' value='Alertar'/></form></td>";
            
            echo "<td><form action='?contenido=Multas' method='POST' class='form-register'>
            <input type='hidden' name='Semilla' value='".$Lee['id_semilla']."'>
            <input type='hidden' name='Mvto' value='".$Lee['Id']."'> 
            <input type='hidden' name='Presidente' value='".$User."'>
            <input type='hidden' name='Usuario' value='".$Lee['Id_usuario']."'>
            <input name='VerMv' class='btn btn-danger btn-block' type='submit' value='Multar'/></form></td>";

            if(!empty($Lee['prestamo'])){

              echo "<td><form action='?contenido=pasociacion' method='POST' class='form-register'>
                <input type='hidden' name='Semilla' value='".$Lee['id_semilla']."'>
                <input type='hidden' name='Mvto' value='".$Lee['Id']."'> 
                <input type='hidden' name='Presidente' value='".$User."'>
                <input type='hidden' name='prestamo' value='".$Lee['prestamo']."'>
                <input type='hidden' name='Usuario' value='".$Lee['Id_usuario']."'>
                <input name='VerMv' class='btn btn-danger btn-block' type='submit' value='Prestamo'/></form></td>";
            }else{
              echo "<td align='center'><i class='fa fa-ban' aria-hidden='true'></i></td>";
            }
        }else{
          echo "<td align='center'><i class='fa fa-ban' aria-hidden='true'></i></td>";
          echo "<td align='center'><i class='fa fa-ban' aria-hidden='true'></i></td>";
          echo "<td align='center'><i class='fa fa-ban' aria-hidden='true'></i></td>";
        }
      echo "</tr>"; 

      $Ahorro = $Ahorro + $Recaudo;
        } ?>
    </tbody>
    <tfoot>
      <td colspan="3"><?php echo $MensajeAhorro ?></td>
      <td align="right">$<?php echo number_format($Ahorro) ?></td>
      <td colspan="10"></td>
    </tfoot>
</table> 
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
                     url:"includes/DistribucionValor.php",  
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
                  <h4 class="modal-title">Detalles del depósito</h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>      
                </div>  
                <div class="modal-body" id="employee_detail">  
                </div> 
                 
           </div>  
      </div>  
 </div>

<?php }else{

}
 ?>

