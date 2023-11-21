<?php

session_start();
include("conexion.php");
if (isset($_SESSION['user'])){
  echo '<script>window.location="admin/index.php";</script>';
}else{ ?>

<!DOCTYPE html>
<html lang="es">

<head><meta charset="euc-jp">
  
  <meta http-equiv="X-UA-Compatible" content="IE=edge; charset=ISO-8859-1">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="">
  <meta name="author" content="José Luis Casilimas Martinez.">
  <meta http-equiv="Last-Modified" content="0">
  <meta http-equiv="Cache-Control" content="no-cache, mustrevalidate">
  <meta http-equiv="Pragma" content="no-cache">
  <title>TintoLibre</title> 
  <link href="favicon.ico" rel="shortcut icon">
  <link rel="manifest" href="/manifest.json">
  <meta name="msapplication-TileColor" content="#ffffff">
  <meta name="msapplication-TileImage" content="/ms-icon-144x144.png">
  <meta name="theme-color" content="#ffffff">
  <link href="vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet"> 
  <link href="vendor/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css"> 
  <link href="css/sb-admin.css" rel="stylesheet">
</head>

<body background="Vista/modules/images/bg-01.png" >
  
  <div class="container">
    <div class="card card-login mx-auto mt-5">
      <div class="card-header" align="center">Ingreso de integrantes</div>
      <div class="card-body">
        <form action="proceso_conex.php" method="POST">
          <div class="form-group">
            <label>Usuario o número de documento</label>
            <input name= "usuario" class="form-control" type="text" placeholder="Usuario">
          </div>
          <div class="form-group">
            <label>Contrasena</label>
            <input name="password" class="form-control" type="password" placeholder="Contraseña">
            <input type="hidden" id="Ingreso" name="Ingreso" value="Ingreso_al_sistema">
          </div>
          <!-- <div class="form-group">
            <div class="form-check">
              <label class="form-check-label">
                <?php //<input class="form-check-input" type="checkbox">Recordar Contraseña</label>?>
            </div>
          </div> -->
          <input type="submit" name="login" class="btn btn-dark btn-block" value="Ingresar"/>
        </form>
        <br>
        <form action="registronuevo.php" method="POST">
          <input type="submit" name="registro" class="btn btn-dark btn-block" value="Registrarse"/>
        </form>
       <!--  <div class="text-center">
          <a class="d-block small" href="forgot-password.php">Olvido su Constrasena?</a>
        </div> -->
      </div>
    </div>
  </div> 
  <script src="vendor/jquery/jquery.min.js"></script>
  <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script> 
  <script src="vendor/jquery-easing/jquery.easing.min.js"></script>
</body>
<?php } ?>
</html>