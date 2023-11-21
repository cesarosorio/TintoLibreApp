<?php
error_reporting(0);

if($Permiso == 2){
  $ListaSemillas = $conexion ->  query ("SELECT css.Id_Semilla, css.Nombre_Semilla FROM conformacion_semilla css WHERE css.Estado_Semilla IN (1, 2, 3)");
}else{
  $ListaSemillas = $conexion ->  query ("SELECT css.Id_Semilla, css.Nombre_Semilla FROM conformacion_semilla css INNER JOIN integrantes_semilla iss ON iss.Id_semilla = css.Id_Semilla WHERE iss.Id_persona = '$User' and css.Estado_Semilla IN (1, 2, 3)");
}

while ($Lee = mysqli_fetch_array($ListaSemillas)) {
  $Semillas[] = array('Id_Semilla' => $Lee['Id_Semilla'], 'Nombre_Semilla' => $Lee['Nombre_Semilla']);
}
 

$Titulos[] = array('IdTitulo' => 1, 'Titulo' => '1. Total ahorro semilla');
$Titulos[] = array('IdTitulo' => 2, 'Titulo' => '2. Total Fondo Social (aportes + multas)');
$Titulos[] = array('IdTitulo' => 3, 'Titulo' => '3. Total Prestamos');
$Titulos[] = array('IdTitulo' => 4, 'Titulo' => '4. Total intereses préstmos');
$Titulos[] = array('IdTitulo' => 5, 'Titulo' => '5. Total intereses de ahorros e incentivos '); 
$Titulos[] = array('IdTitulo' => 6, 'Titulo' => '6. Total depositos '); 

?>
<ol class="breadcrumb"> 
    <li class="breadcrumb-item">Menú de opciones.</li>
    <li class="breadcrumb-item active">Ver mis comprobantes.</li>
</ol>
 
<meta charset="utf-8">
  <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0"> 
    <thead>
      <tr>
        <th align="center"></th>
        <?php foreach ($Semillas as $vs) {
          echo '<th align="center" style="white-space: nowrap;">'.$vs['Nombre_Semilla'].'</th>';
        } ?>
      </tr>
    </thead>
    <tbody> 
      <?php foreach ($Titulos as $tt) {
        echo "<tr><td style='white-space: nowrap;'><strong>".$tt['Titulo']."</strong></td>";
        foreach ($Semillas as $sm) {
            $sm =  $sm['Id_Semilla'];
          switch ($tt['IdTitulo']) {
            case 1:
              $query = "SELECT IFNULL(SUM(Valor), 0) Dato FROM mv_meta_semilla WHERE Tipo IN (2, 3) AND Id_semilla = $sm";
            break;

            case 2:
              $query = "SELECT IFNULL(SUM(mv.AporteSocial), 0)+(SELECT IFNULL(SUM(Valor_multa), 0) FROM mv_multa_semilla WHERE Id_semilla = mv.Id_semilla) Dato FROM mv_meta_semilla mv WHERE mv.Tipo IN (2, 3) AND mv.Id_semilla =$sm";
            break;

            case 3:
              $query = "SELECT IFNULL(SUM(ValPrestamo), 0) Dato FROM prestamos WHERE Id_semilla =$sm";
            break;

            case 4:
              $query = "SELECT IFNULL(SUM(ValPrestamo), 0) Dato FROM prestamos WHERE Id_semilla =$sm";
            break;

            case 5:
              $query = "SELECT IFNULL(SUM(Valor), 0) Dato FROM mv_meta_semilla WHERE Tipo = 3 AND Id_semilla =$sm";
            break; 

            case 6:
              $query = "SELECT 
                (SELECT IFNULL(SUM(Valor), 0) Dato FROM mv_meta_semilla WHERE Tipo IN (2, 3) AND Id_semilla = $sm)+
                (SELECT IFNULL(SUM(mv.AporteSocial), 0)+(SELECT IFNULL(SUM(Valor_multa), 0) FROM mv_multa_semilla WHERE Id_semilla = mv.Id_semilla) Dato FROM mv_meta_semilla mv WHERE mv.Tipo IN (2, 3) AND mv.Id_semilla = $sm)+
                (SELECT IFNULL(SUM(ValPrestamo), 0) Dato FROM prestamos WHERE Id_semilla = $sm)+
                (SELECT IFNULL(SUM(ValPrestamo), 0) Dato FROM prestamos WHERE Id_semilla = $sm)+
                (SELECT IFNULL(SUM(Valor), 0) Dato FROM mv_meta_semilla WHERE Tipo = 3 AND Id_semilla = $sm)
              AS Dato"; 
              
            break; 
          } 

          $R=mysqli_fetch_assoc($conexion->query($query)); 
          $Dato = $R['Dato'];
          echo "<td align='right'>$".number_format($Dato, 0)."</td>";
        }
        echo "</tr>";
      }
      ?>
    </tbody> 
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
                  <h4 class="modal-title">Movimientos del valor</h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>      
                </div>  
                <div class="modal-body" id="employee_detail">  
                </div> 
                 
           </div>  
      </div>  
 </div>