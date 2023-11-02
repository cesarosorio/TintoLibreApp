<?php 

include '../conexion.php';
$id = $_POST['employee_id']; 

$R=mysqli_fetch_assoc($conexion->query("SELECT Id_persona, Id_semilla FROM semillas_terminadas WHERE id = $id"));
$Id_persona = $R['Id_persona'];
$Semilla = $R['Id_semilla'];

$R=mysqli_fetch_assoc($conexion->query("SELECT Name FROM usuario WHERE Id_usuario = $Id_persona"));
echo "Información para <strong>".$R['Name']."</strong>";
?>

<form method="POST" action="includes/Semillas/FuncionesSemilla.php" enctype="multipart/form-data"> 
    <div class="col-md-12"><br></div>
    <div class="col-md-12">
        <div class="form-group">
            <div class="form-check">
            <input class="form-control" type="file" name="documento" accept="application/pdf, image/*" required>
            </div>		
        </div>
    </div>

	<div class="col-md-12">
  		<input type="hidden" name="id_cierre" value="<?php echo $id ?>">
  		<input type="hidden" name="Semilla" value="<?php echo $Semilla ?>">
		<input name="upload_cierre" class="btn btn-dark btn-block" type="submit" value="Subir comprobante"/>
  	</div>
</form>