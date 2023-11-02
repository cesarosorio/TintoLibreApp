<?php 

include 'conexion.php' ;
$D = ("SELECT u.Name, u.Id_usuario FROM usuario u WHERE Rol = 2");
$Data = $conexion -> query($D);

?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="">
  <meta name="author" content="">
  <title>¡Bienvenido!</title> 
  <link href="vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet"> 
  <link href="vendor/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css"> 
  <link href="css/sb-admin.css" rel="stylesheet">
</head>

<body class="bg-dark">
  <div class="container">
    <div class="card card-login mx-auto mt-5">
      <div class="card-header">Por favor, llene los campos a continuación</div>
      <div class="card-body"> 
        <form autocomplete="off" action="proceso_registro.php" method="POST">
          
          <div class="form-group">
          	<label>Número de cedula</label>
            <input class="form-control" type="number" name="usuario" placeholder="Documento" required>
          </div>

          <div class="form-group">
          	<label>Lider de semilla</label>
            <select list="Lider" class="form-control" type="text" name="Lider" required>  
              <option></option>
              <?php while ($Lee = mysqli_fetch_array($Data)) { 
                echo "<option value=".$Lee['Id_usuario'].">".$Lee['Name']."</option>";  
              } ?>
            </select> 
          </div>

          <div class="form-group">
          	<label>Nombres</label>
            <input class="form-control" type="text" name="Name1" placeholder="Nombre" required>
          </div>

          <div class="form-group">
            <label>Primer Apellido</label>
            <input class="form-control" type="text" name="Name2" placeholder="Apellidos" required>
          </div>

          <div class="form-group">
            <label>Segundo Apellido</label>
            <input class="form-control" type="text" name="Name3" placeholder="Apellidos">
          </div>

          <div class="form-group">
          	<label>Correo</label>
            <input class="form-control" type="email" name="Correo" required>
          </div>
          
          <div class="form-group">
          	<label>Fecha de Nacimiento</label>
            <input class="form-control" type="date" name="FechaNacimiento" required>
          </div>

          <div class="form-group">
            <label>Género</label>
              <select list="Genero" class="form-control" type="text" name="Genero" required>  
              <option value="F">Femenino</option> 
              <option value="M">Masculino</option>
              <option value="O">Otro</option>
            </select>
          </div>

          <input type="submit" name="" class="btn btn-dark btn-block" href=""></input>
        </form>
        <div class="text-center">
          <a class="d-block small" href="index.php">Ingresar a su cuenta</a>
        </div>
      </div>
    </div>
  </div>

  <script src="vendor/jquery/jquery.min.js"></script>
  <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
  <script src="vendor/jquery-easing/jquery.easing.min.js"></script>

</body>

</html>
