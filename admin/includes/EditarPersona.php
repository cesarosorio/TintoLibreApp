<?php

require 'conexion.php';

if(isset($_POST["employee_id"])){ 

	$Dato=$_POST["employee_id"];

	$ADMON = "SELECT u.Id_usuario as Cedula, u.Nickname as Usuario, u.Name as Nombre, R.Nombre_Rol, CASE WHEN u.Estado = 1 THEN 'Activo' ELSE 'Inactivo' END as Estado, u.FechaNacimiento, G.Nombre as Genero, U2.Name AS Crea FROM usuario u INNER JOIN Rol R ON R.Id_Rol = U.Rol INNER JOIN Generos G ON G.Sigla = U.Genero INNER JOIN usuario U2 ON U2.Id_usuario = U.LiderSemilla WHERE u.Id_usuario = $Dato ";
	$siguiente=$conexion->query($ADMON);
	$final=mysqli_fetch_assoc($siguiente);
	$Id_usuario=$final['Cedula'];
	$Name=$final['Nombre'];
	$Nickname=$final['Usuario']; ; 
	$Estado=$final['Estado'];
    
?>
<form action="../admin/index.php?contenido=EditarPersona" method="POST" class="form-register" name="RVH">

<div class="row">
  	<div class="col-md-6">

		<div class="form-group">
	        <label for="exampleInputEmail1">Documento del usuario</label>
	        <input class="form-control" id="exampleInputEmail1" type="number" aria-describedby="emailHelp" name="Cedula" value="<?php echo $Id_usuario ?>" readonly>
	    </div>

	    <div class="form-group">
	        <label for="exampleInputEmail1">Nombre completo</label>
	        <input class="form-control" id="exampleInputEmail1" type="text" aria-describedby="emailHelp" name="Name" value="<?php echo $Name ?>" required>
	    </div>

		     
	</div>
  	<div class="col-md-6">
		 
	    <div class="form-group">
	        <label for="exampleInputEmail1">Estado</label>
	        <select class='form-control'  name='Estado'>
	            <option value="<?php echo $Estado ?>">Cambiar el estado ...</option>
	            <option value='1'>Activo</option> 
	            <option value='0'>Inactivo</option>  
	        </select>
	    </div> 
	</div>
</div> 
    <input type="hidden" name="contenido" value="<?php echo $contenido; ?>">
    <input name="EditPersona" class="btn btn-dark btn-block" type="submit" value="Editar personal"/>
</form>
<br>    
<button type='button' class='btn btn-danger btn-block' data-dismiss='modal'>¡Cancelar!</button>
 

<?php } ?>

