<?php 

if (isset($_POST['VerAlerta'])) { 

$id = $_POST['id'];

$R=mysqli_fetch_assoc($conexion->query("SELECT Id_mvto FROM alertas WHERE Id = ".$id)); 
$Mvto = $R['Id_mvto']; 

$MV=mysqli_fetch_assoc($conexion->query("SELECT a.id as alert, mp.Id as idprestamo, mv.id, u.Name, mv.Valor, mv.AporteSocial, mv.Observaciones, mv.Fecha, mv.Fecha_cp, case when mp.Capital is null then 0 else mp.Capital end as Capital, case when mp.Intereses is null then 0 else mp.Intereses end as Intereses, a.Fecha FecAlerta, a.Observaciones obAlerta, uu.Name as Notifica FROM mv_meta_semilla mv inner join usuario u on u.Id_usuario = mv.Id_usuario left join mv_prestamos_sem mp on mp.Id_mvto = mv.Id inner join alertas a on a.Id_mvto = mv.Id and a.Estado = 1 inner join usuario uu on uu.Id_usuario = a.Id_notifica WHERE mv.Id = $Mvto"));  


$dt = $conexion -> query("SELECT mm.id, mm.Valor_multa, concat(ms.NombreMulta, ', ', ms.ObserMultas) as tipomulta FROM mv_multa_semilla mm inner join multas_semilla ms on ms.Id = mm.Id_multa WHERE mm.Id_mvto = $Mvto");
$nmultas = mysqli_num_rows($dt);
 
?>

<ol class="breadcrumb"> 
    <li class="breadcrumb-item">Menú de opciones.</li>
    <li class="breadcrumb-item">Alertas.</li>
    <li class="breadcrumb-item active">Alerta <strong>Nro.: <?php echo $id ?></strong></li>
</ol>	

<strong>Nota.: </strong> Es muy importante al momento de restar las cantidades, sumar correctamente al valor del ahorro, restar y demas operaciones que tengan lugar.

<br>
<br>

<form action='includes/procesoalerta.php' method='POST' class='form-register'>
	<div class="row"> 
	     <div class="col-md-3">
	          <strong>Integrante: </strong>
	     </div>

	     <div class="col-md-3">
	          <?php echo utf8_encode($MV['Name']) ?>
	     </div>

	     <div class="col-md-3">
	          <strong>Observaciones: </strong> 
	     </div>

	     <div class="col-md-3">
	        <div class="form-group"> 
				<textarea class="form-control" type="number" name="Observaciones"><?php echo ($MV['Observaciones']) ?></textarea>
			</div>
	     </div>

	     <div class="col-md-12"><hr></div>

	     <div class="col-md-3">
	          <strong>Ahorro: </strong> 
	     </div>

	     <div class="col-md-3">
	     	<div class="form-group">
				<input class="form-control" type="number" name="Valor" value='<?php echo $MV['Valor'] ?>'>
			</div>	          
	     </div>

	     <div class="col-md-3">
	          <strong>Aporte Social: </strong> 
	     </div>

	     <div class="col-md-3">
	        <div class="form-group">
				<input class="form-control" type="number" name="AporteSocial" value='<?php echo $MV['AporteSocial'] ?>'>
			</div>
	     </div>

	     <div class="col-md-12"><hr></div>

	     <div class="col-md-3">
	          <strong>Prestamos, capital: </strong> 
	     </div>

	     <div class="col-md-3">
	        <div class="form-group">
				<input class="form-control" type="number" name="Capital" value='<?php echo $MV['Capital'] ?>'>
			</div>
	     </div>

	     <div class="col-md-3">
	          <strong>Prestamos, intereses: </strong> 
	     </div>

	     <div class="col-md-3">
	        <div class="form-group">
				<input class="form-control" type="number" name="Intereses" value='<?php echo $MV['Intereses'] ?>'>
			</div>
	     </div>

	     <div class="col-md-12"><hr></div>

	    <?php $n=1; while ($Lee = mysqli_fetch_array($dt)) { ?>
	     
	     <div class="col-md-3">
	          <strong>Multa Nro.: <?php echo $Lee['id'] ?> </strong> 
	     </div>

	     <div class="col-md-3">
	          <?php echo utf8_decode($Lee['tipomulta']) ?>
	     </div>

	     <div class="col-md-3">
	          <strong>Valor de la multa</strong> 
	     </div>

	     <div class="col-md-3">
	        <div class="form-group">
				<input class="form-control" type="number" name="Valor_multa<?php echo $n ?>" value='<?php echo $Lee['Valor_multa'] ?>'>
			</div>
	     </div>

	     <input type="hidden" name="idmulta<?php echo $n ?>" value="<?php echo $Lee['id'] ?>">


	     <div class="col-md-12"><br></div>

	     <?php $n++; } ?>    

	     <div class="col-md-12"><hr></div>

	     <div class="col-md-3">
	          <strong>Fecha: </strong> 
	     </div>

	     <div class="col-md-3">
	          <?php echo $MV['Fecha'] ?>
	     </div>

	     <div class="col-md-3">
	          <strong>Fecha de captura</strong> 
	     </div>

	     <div class="col-md-3">
	          <?php echo $MV['Fecha_cp'] ?>
	     </div>

	     <div class="col-md-12"><hr></div>

	     <div class="col-md-3">
	          <strong>Notifica: </strong> 
	     </div>

	     <div class="col-md-3">
	          <?php echo $MV['Notifica'] ?>
	     </div>

	     <div class="col-md-3">
	          <strong>Fecha de notificación</strong> 
	     </div>

	     <div class="col-md-3">
	          <?php echo $MV['FecAlerta'] ?>
	     </div>

	     <div class="col-md-12"><hr></div>

	     <div class="col-md-12">
			<div class="form-group">
				<strong><label>Observaciones <font color="red">*</strong></font></label>
				<textarea class="form-control" type="number" name="Obser" readonly><?php echo ($MV['obAlerta']) ?></textarea>
			</div>
	     </div>

	     <div class="col-md-6">	        
			<input type='hidden' name='Mvto' value='<?php echo $Mvto ?>'>  
			<input type='hidden' name='Lider' value='<?php echo $User ?>'>  
			<input type='hidden' name='nmultas' value='<?php echo $nmultas ?>'>  
			<input type='hidden' name='idprest' value='<?php echo $MV['idprestamo'] ?>'>    
			<input name='Modificar' class='btn btn-dark btn-block' type='submit' value='Modificar'/>
	     </div>
</form>

	    <div class="col-md-6">	         
			<input type='button' name='view' value='Eliminar' id='<?php echo $Mvto ?>' class='btn btn-danger btn-block view_data'/>
	    </div>

	     
	</div>


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
                     url:"includes/Eliminarmvto.php",  
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
                  <h4 class="modal-title">¿Esta seguro de eliminarlo?</h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>      
                </div>  
                <div class="modal-body" id="employee_detail">  
                </div> 
                 
           </div>  
      </div>  
 </div>
<?php }
