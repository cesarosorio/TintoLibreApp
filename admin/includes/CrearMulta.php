<form autocomplete="off" method="POST" action="../admin/index.php?contenido=asigMultas" class="form-register" name="RVH">
<div class="row">
  	
  	<div class="col-md-6">
		<div class="form-group">
		    <label>Nombre <font color="red"><strong>*</strong></font></label>
		    <input class="form-control" type="text" name="Nombre" max="60" required>
		</div>
	</div>

	<div class="col-md-6">
		<div class="form-group">
		    <label>Valor de la multa <font color="red"><strong>*</strong></font></label>
		    <input class="form-control" type="number" name="Valor" min='1' required>
		</div>
	</div>

	<div class="col-md-12">
		<div class="form-group">
		    <label>Observaciones <font color="red"><strong>*</strong></font></label>
		    <textarea class="form-control" type="number" name="Observaciones" required></textarea>
		</div>
	</div>

  	<div class="col-md-12"> 
  		<input type="hidden" name="Semilla" value="<?php echo $_POST['employee_id'] ?>">
		<input name="Ver" class="btn btn-dark btn-block" type="submit" value="Agregar Multa"/>
  	</div>
</form>