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

<?php 

if (isset($_POST['VerMv'])) { 
	$Mvto = $_POST['Mvto'];
	$Usuario = $_POST['Usuario'];
	$prestamo = $_POST['prestamo'];
    $Semilla = $_POST['Semilla'];

	$R=mysqli_fetch_assoc($conexion->query("SELECT Nombre_Semilla FROM conformacion_semilla WHERE id_semilla = ".$Semilla)); 
	$Nombre_Semilla = $R['Nombre_Semilla'];

	$Cons = "SELECT mv.Id, mv.id_semilla, mv.Id_usuario, mv.Fecha, u.Name, mv.Observaciones, (mv.Valor+mv.aportesocial+(SELECT SUM(Valor_multa) from mv_multa_semilla where Id_mvto = mv.Id)) as Recaudo, mv.Comprobante FROM mv_meta_semilla mv inner join usuario u on u.Id_usuario = mv.Id_usuario WHERE mv.id_semilla = $Semilla and mv.Id = $Mvto";
    $MP = $conexion -> query ($Cons);
    $Lee = mysqli_fetch_assoc($MP);
    
    $Cons = "SELECT ue.Name Usuario, pa.Fecha_pago, pa.Concepto, pa.Valor_pago, pa.Interesesc, pa.Interesesm, pa.Capital, pa.Saldo, ul.Name Lider FROM pasociacion pa INNER JOIN usuario ue on ue.Id_usuario = pa.Id_responsable INNER JOIN usuario ul on ul.Id_usuario = pa.Lider WHERE pa.Id_prestam = $prestamo ";
    $Mvp = $conexion -> query ($Cons); 

 
?>

<ol class="breadcrumb"> 
    <li class="breadcrumb-item">Menú de opciones.</li>
    <li class="breadcrumb-item">Ver mis comprobantes.</li>
    <li class="breadcrumb-item"><strong>Semilla:</strong> <?php echo $Nombre_Semilla ?></li>
</ol>

<meta charset="utf-8">
  <table class="table table-bordered" width="100%" cellspacing="0"> 
    <thead>
      <tr align="center">
        <th align="center">Fecha</th> 
        <th align="center">Integrante</th> 
        <th align="center">Observaciones</th> 
        <th align="center">Recaudo</th> 
        <th align="center"><i class='fa fa-file-pdf-o' aria-hidden='true'></i></th> 
        <th align="center">Detalle</th>  
      </tr>
    </thead>
    <tbody>
		<?php $Cop = substr($Lee['Comprobante'], 6);
    		echo "<tr>
			<td>".$Lee['Fecha']."</td>  
			<td>".utf8_encode($Lee['Name'])."</td>  
               <td>".utf8_encode($Lee['Observaciones'])."</td>  
			<td align='right'>$".number_format($Lee['Recaudo'], 0)."</td>   
			<td aling='center'><a title='¡Click acá para ver el acta!' href='".$Cop."' target='_blank'><i class='fa fa-file-pdf-o' aria-hidden='true'></i></a></td>  
			<td><input type='button' name='view' value='Ver' id='".$Lee['Id']."' class='btn btn-dark btn-block view_data'/></td>"; 
	    echo "</tr>";  ?>
    </tbody>
</table> 

<div class="alert alert-dark" role="alert">Préstamos asociación</div>

<br>

<meta charset="utf-8">
  <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0"> 
    <thead>
      <tr align="center">
        <th align="center">#</th> 
        <th align="center">Usuario</th> 
        <th align="center">Fecha pago</th> 
        <th align="center">Concepto</th> 
        <th align="center">Valor de pago</th> 
        <th align="center">Intereses corrientes</th> 
        <th align="center">Intereses Moratorios</th> 
        <th align="center">Aporte a capital</th> 
        <th align="center">Saldo deuda</th>     
        <th align="center">Lider</th>     
      </tr>
    </thead>
    <tbody>
    <?php $nro=1; while ($LI = mysqli_fetch_array($Mvp)) { 

    echo "<tr>
        <td>".$nro++."</td>
        <td>".utf8_encode($LI['Usuario'])."</td>  
        <td>".($LI['Fecha_pago'])."</td>  
        <td>".($LI['Concepto'])."</td>   
        <td align='right'>$".number_format($LI['Valor_pago'], 0)."</td>   
        <td align='right'>$".number_format($LI['Interesesc'], 0)."</td>   
        <td align='right'>$".number_format($LI['Interesesm'], 0)."</td>   
        <td align='right'>$".number_format($LI['Capital'], 0)."</td>   
        <td align='right'>$".number_format($LI['Saldo'], 0)."</td>   
        <td>".utf8_encode($LI['Lider'])."</td>  
    </tr>"; 

    $Valor_pago = $LI['Saldo']; 

    } ?>
    </tbody> 
</table>

<br>
<div class="alert alert-dark" role="alert">Asignar movimiento</div>
<br>

<form autocomplete="off" method='POST' class='form-register'>
	<div class="row"> 
	     <div class="col-md-3">
	          <strong>Concepto: </strong>
	     </div>

	     <div class="col-md-3">
	          <input type="text" name="concepto" class="form-control" require>
	     </div>

	     <div class="col-md-3">
	          <strong>Valor de pago: </strong> 
	     </div>

	     <div class="col-md-3">
            <input type="number" name="valorpago" class="form-control" require>
	     </div>

	     <div class="col-md-12"><br></div>

	     <div class="col-md-3">
	          <strong>Intereses corrientes: </strong> 
	     </div>

	     <div class="col-md-3">
            <input type="number" name="interesesc" class="form-control" require>
	     </div>

	     <div class="col-md-3">
	          <strong>Intereses moratorios: </strong> 
	     </div>

	     <div class="col-md-3">
            <input type="number" name="interesesm" class="form-control" require>
	     </div>

	     <div class="col-md-12"><br></div>

	     <div class="col-md-3">
	          <strong>Aporte capital: </strong> 
	     </div>

	     <div class="col-md-3">
            <input type="number" name="Capital" class="form-control" require>
	     </div>
       
	     <div class="col-md-6">	        
			<input type='hidden' name='Mvto' value='<?php echo $Mvto ?>'>  
			<input type='hidden' name='Notifica' value='<?php echo $User ?>'>  
			<input type='hidden' name='Usuario' value='<?php echo $User ?>'>  
			<input type='hidden' name='prestamo' value='<?php echo $prestamo ?>'>  
			<input type='hidden' name='Semilla' value='<?php echo $Semilla ?>'>  
			<input type='hidden' name='Id_usuario' value='<?php echo $Usuario ?>'>  
			<input type='hidden' name='Fecha_pago' value='<?php echo $Lee['Fecha'] ?>'> 
			<input type='hidden' name='Valor_pagoo' value='<?php echo $Valor_pago ?>'>  
			<input name='Prestamo' class='btn btn-dark btn-block' type='submit' value='Asignar'/>
	     </div>
	     
	</div>
</form>

<br> 
<div class="row"> 
    <div class="col-md-4"></div>
    <div class="col-md-4"></div>
    <div class="col-md-4">	        
    <form action='?contenido=verMvto' method='POST' class='form-register'>
        <input type='hidden' name='Semilla' value="<?php echo $Semilla ?>">  
        <input type='hidden' name='AUser' value="<?php echo $Usuario ?>">  
        <input name='VerMv' class='btn btn-dark btn-block' type='submit' value='Volver'/>
    </form>
    </div>
</div>
<br>

<?php } 

if (isset($_POST['Prestamo'])){ 
    	
    $concepto = $_POST['concepto'];
    $valorpago = $_POST['valorpago'];
    $interesesc = $_POST['interesesc'];
    $interesesm = $_POST['interesesm'];
    $Capital = $_POST['Capital'];
    $Mvto = $_POST['Mvto'];
    $Notifica = $_POST['Notifica'];
    $prestamo = $_POST['prestamo'];
    $Semilla = $_POST['Semilla'];
    $Id_usuario = $_POST['Id_usuario'];
    $Fecha_pago = $_POST['Fecha_pago'];
    $Valor_pagoo = $_POST['Valor_pagoo'];
    $Saldo = $Valor_pagoo - $Capital;

    $sgmp = ($Saldo <= 0) ? ', Estado = 7 ' : '' ; 
	
    $Asigprestamosa = "INSERT INTO pasociacion(Id_responsable, Id_prestam, Id_mvto, Fecha_pago, Concepto, Valor_pago, Interesesc, Interesesm, Capital, Saldo, FechaRegistro, Lider, Tipo) VALUES ($Id_usuario, $prestamo, $Mvto, '$Fecha_pago', '$concepto', $valorpago, $interesesc, $interesesm, $Capital, $Saldo, NOW(), $Notifica, 2)";
    if ($conexion -> query($Asigprestamosa)) {
        $ActPrincipal = "UPDATE mv_meta_semilla SET Valor = Valor-$valorpago WHERE Id = $Mvto"; 
        $ActPrincipal2 = "UPDATE prestamos SET ValPrestamo = $Saldo $sgmp WHERE Id = $prestamo"; 
        if ($conexion -> query($ActPrincipal) AND $conexion -> query($ActPrincipal2)) { 
            ?><script languaje="javascript">
                alert("¡Se aplico el registro!");
                window.location="?contenido=verMvto";
            </script><?php 
        }
    }else{
        echo $Asigprestamosa;
        ?><script languaje="javascript">
            alert("¡Ups! algo ocurrio, por favor informar!");
            window.location="?contenido=verMvto";
        </script><?php
    }
 
}