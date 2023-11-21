<?php 

$Persona = $_POST['Cedula'];
$Semilla = $_POST['Sen'];

if (isset($_POST['cambiopersona'])) {
	$Rol = $_POST['Rol'];
	$Meta_personal = $_POST['Meta_personal'];

	$ActInte = "UPDATE integrantes_semilla SET Rol = $Rol, Meta_personal = $Meta_personal WHERE Id_persona = $Persona AND id_semilla = $Semilla";
	if ($conexion -> query($ActInte) ) { ?>
		<script languaje="javascript">
            window.location="../admin/index.php?contenido=detSemilla&Semilla=<?php echo $Semilla ?>";
            alert("¡Se determino con exito el usuario!");
        </script>
	<?php }else{
		echo $ActInte;
	}

}


$R=mysqli_fetch_assoc($conexion->query("SELECT rs.Id FROM rol_semilla rs inner join integrantes_semilla iss on iss.Rol = rs.Id WHERE iss.id_semilla = $Semilla and iss.Id_persona = ".$Persona));
$Id = $R['Id'];

$R=mysqli_fetch_assoc($conexion->query("SELECT u.Name FROM usuario u WHERE u.Id_usuario = ".$Persona));
$Name = $R['Name'];

$VerRolesSemilla ="SELECT Id, Nombre FROM rol_semilla ";
$MP = $conexion->query($VerRolesSemilla);

$R=mysqli_fetch_assoc($conexion->query("SELECT ms.Nombre_Semilla FROM conformacion_semilla ms WHERE ms.id_semilla = ".$Semilla)); 
$Nombre_Semilla = $R['Nombre_Semilla'];

?>

<ol class="breadcrumb"> 
    <li class="breadcrumb-item">Menú de opciones.</li>
    <li class="breadcrumb-item">INFORMACIÓN DE MIS SEMILLAS.</li>
    <li class="breadcrumb-item"><?php echo $Semilla ?>"><?php echo $Nombre_Semilla ?></li>
    <li class="breadcrumb-item active">Modificacion de usuario: <?php echo $Name ?></li>
</ol>

<form method="POST" class="form-register" name="RVH">
<div class="row">
	<div class="col-md-6">
		<div class="form-group">
		    <label>Rol</label>
			<?php while ($Lee=$MP->fetch_array(MYSQLI_BOTH)) {  
				if ($Lee['Id'] != 0) {
					if ($Lee['Id'] == $Id) { ?> 
						<div class="form-group">
							<div class="form-check">
						  		<input required class="form-check-input" type="radio" value="<?php echo $Lee['Id'] ?>" name="Rol" checked><?php echo $Lee['Nombre'] ?>
							</div>	
						</div>	
					<?php }else{ ?> 
						<div class="form-group">
							<div class="form-check">
						  		<input class="form-check-input" type="radio" value="<?php echo $Lee['Id'] ?>" name="Rol"><?php echo $Lee['Nombre'] ?>
							</div>		
						</div>
					<?php } 
				}
			} ?>
		</div>
	</div>
	
  	<div class="col-md-6">
		<div class="form-group">
		    <label>Meta personal</label>
		    <input class="form-control" type="number" name="Meta_personal" required>
		</div>
	</div>
	<div class="col-md-12">
		<input type="hidden" name="Cedula" value="<?php echo $Persona ?>">
		<input type="hidden" name="Sen" value="<?php echo $Semilla ?>">
  		<input name="cambiopersona" class="btn btn-dark btn-block" type="submit" value="Cambiar Información"/>
  	</div>
 </div>
</form>