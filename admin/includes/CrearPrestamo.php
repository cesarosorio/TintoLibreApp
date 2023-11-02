<?php 

include 'conexion.php';
$Responsable = $_POST['employee_id'];

$R=mysqli_fetch_assoc($conexion->query("SELECT COUNT(p.id) id FROM prestamos p where p.Id_responsable = $Responsable and p.Estado != 7 "));

?>

<form method="POST" action="?contenido=prestamos" class="form-register" name="RVH">
<div class="row">
 
	<div class="col-md-6">
      <div class="form-group">
        <label>Seleccione la semilla</label>
        <select list="Semilla" class="form-control" type="text" name="Lider" required>  
          <option></option>
           <?php $Data = $conexion -> query("SELECT CS.Id_semilla, CS.Nombre_Semilla FROM conformacion_semilla CS INNER JOIN integrantes_semilla iss on iss.Id_semilla = CS.Id_Semilla WHERE CS.Estado_Semilla IN (2, 3) AND iss.Id_persona = $Responsable");
          while ($Lee = mysqli_fetch_array($Data)) { 
            echo "<option value=".$Lee['Id_semilla'].">".$Lee['Nombre_Semilla']."</option>";  
          } ?>
        </select> 
      </div>
    </div>

	<div class="col-md-6">
		<div class="form-group">
			<label>Valor del préstamo</label>
			<input class="form-control" type="number" name="ValPrestamo" required>
		</div>
	</div>

	<div class="col-md-12">
		<div class="form-group">
			<label>Justificación</label>
			<textarea class="form-control" type="text" name="Justificacion" required></textarea>
		</div>
	</div>
 	
 	<?php if ($R['id'] != 0) { ?>
		<div class="col-md-12">
			Ya tienes un préstamo vigente
 		</div>
 	<?php }else{ ?>
		<div class="col-md-12">
	  		<input type="hidden" name="Responsable" value="<?php echo $Responsable ?>">
			<input name="SolPrestamo" class="btn btn-dark btn-block" type="submit" value="Solicitar préstamo"/>
	  	</div>
  	<?php } ?>
</div>
</form>