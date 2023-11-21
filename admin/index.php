<?php
session_start();
header("Content-Type: text/html;charset=utf-8");
include("../conexion.php");

@$contenido=$_GET['contenido'];

if (isset($_SESSION['user'])){
  if ($_SESSION['ingresando']==1) {
    $proceso=$_SESSION['registro'];
    $consultauser ="SELECT u.Id_usuario, u.Name, u.rol as Permiso, r.Nombre_Rol FROM usuario u INNER JOIN rol r ON r.Id_Rol = u.Rol WHERE Nickname = '".$_SESSION['user']."'";
    $conuser=mysqli_query($conexion,$consultauser);
    while ($userrow = $conuser->fetch_assoc()){
      $User=$userrow['Id_usuario']; 
      $Permiso=$userrow['Permiso'];
      date_default_timezone_set('america/bogota');
      $hoyIngr = date("d/m/Y");
      $Hora_ingre=date("H:i:s"); 
      $_SESSION['ingresando']=$_SESSION['ingresando']+1;
    }
  }else{
  $proceso=$contenido;
  $consultauser ="SELECT u.Id_usuario, u.Name, u.rol as Permiso, r.Nombre_Rol FROM usuario u INNER JOIN rol r ON r.Id_Rol = u.Rol WHERE Nickname = '".$_SESSION['user']."'";
  $conuser=mysqli_query($conexion,$consultauser);
  while ($userrow = $conuser->fetch_assoc()){
    @$contenido=$_GET['contenido'];
    $User=$userrow['Id_usuario'];
    $Nombre=$userrow['Name'];
    $Permiso=$userrow['Permiso'];
    $hoyIngr = date("d/m/Y");
    date_default_timezone_set('america/bogota');
    $Hora_ingre=date("H:i:s"); 

    $_SESSION['ingresando']=$_SESSION['ingresando']+1;
}}

  $consultauser ="SELECT u.Id_usuario, u.Name, u.rol as Permiso, r.Nombre_Rol FROM usuario u INNER JOIN rol r ON r.Id_Rol = u.Rol WHERE Nickname = '".$_SESSION['user']."'";
  $conuser=mysqli_query($conexion,$consultauser);
  while ($userrow = $conuser->fetch_assoc()){
    
    
    
  $R=mysqli_fetch_assoc($conexion->query("SELECT Estado FROM control_password WHERE id_usuario = ".$User)); 
  $Estado = $R['Estado'];
  
    ?>
<!DOCTYPE html>
<html lang="es">

<head>
  <link href="../favicon.ico" rel="shortcut icon">
  <meta http-equiv="X-UA-Compatible" content="IE=edge; charset=utf-8">
  <meta http-equiv="Last-Modified" content="0">
  <meta http-equiv="Cache-Control" content="no-cache, mustrevalidate">
  <meta http-equiv="Pragma" content="no-cache">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no; charset=utf-8">
  <meta name="description" content="charset=utf-8">
  <meta name="author" content="">
    <meta charset="UTF-8">
  <title>TintoLibre</title> 
  <script src="//code.jquery.com/jquery-3.3.1.min.js"></script>

  <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content=""> 

  <!-- Bootstrap Core CSS -->
  <link href="css/bootstrap.min.css" rel="stylesheet">
	
	<!-- FullCalendar -->
	<link href='css/fullcalendar.css' rel='stylesheet' />
 
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/fancybox/3.3.5/jquery.fancybox.min.css" />
<script src="https://cdnjs.cloudflare.com/ajax/libs/fancybox/3.3.5/jquery.fancybox.min.js"></script>
  <link href="vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
  <!-- Custom fonts for this template-->
  <link href="vendor/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">
  <!-- Page level plugin CSS-->
  <link href="vendor/datatables/dataTables.bootstrap4.css" rel="stylesheet">
  <!-- Custom styles for this template-->
  <link href="css/sb-admin.css" rel="stylesheet">
<<<<<<< HEAD
  <link href="css/custom-general.css" rel="stylesheet">
=======
>>>>>>> c7e84626f70169fab3afcb5aab470f8744186c35

<style>
    
    div.dataTables_wrapper {
        width: 100%;
        overflow-x: scroll; 
    }

</style>

</head>

<body class="fixed-nav sticky-footer bg-dark" id="page-top">
  <!-- Navigation-->
  <nav class="navbar navbar-expand-lg navbar-dark bg-dark fixed-top" id="mainNav" >
    <a class="navbar-brand" href="?contenido=index">
    <img src="Documentos/Imagenes/mandala.ico" width="19px" height="19px">TintoLibre</a>
    <button class="navbar-toggler navbar-toggler-right" type="button" data-toggle="collapse" data-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="navbar-collapse collapse" id="navbarResponsive">
      <ul class="navbar-nav navbar-sidenav" id="exampleAccordion">
        <li class="nav-item" data-toggle="tooltip" data-placement="right" title="Inicio">
          <a style="color: white;" class="nav-link" href="?contenido=index">
            <i class="fa fa-fw fa-home"></i>
            <span class="nav-link-text">Inicio</span>
          </a>
        </li>
        <?php 

switch ($userrow['Permiso']){   
 
case "1":
  include ("models/Admin.php");
break;

case "2":
include ("models/LidSemilla.php");
break; 

case "3":
include ("models/Presidente.php");
break; 

case "5":
include ("models/Semilla.php");
break; 

  
} ?>
 
      </ul>
      <ul class="navbar-nav sidenav-toggler navbar-dark bg-dark">
        <li class="nav-item">
          <a class="nav-link text-center" id="sidenavToggler" data-class="navbar-fixed-left">
            <i class="fa fa-fw fa-angle-left"></i>
          </a>
        </li>
      </ul>
      <ul class="navbar-nav ml-auto">
        <li class="nav-item dropdown">
            
        </li>
        <li class="nav-item">
            <div class="input-group">
              <span class="input-group-append">
                  <a><i class="nav-link active"><?php echo utf8_encode($userrow['Name'])." - " .utf8_encode($userrow['Nombre_Rol']);}?></i></a>
              </span>
            </div>
        </li>
 
        <li class="nav-item">
          <a class="nav-link" data-toggle="modal" data-target="#exampleModal">
            <i class="fa fa-fw fa-sign-out"></i>Salir</a>
        </li>
      </ul>
    </div>
  </nav>
  <div class="content-wrapper">
    <div class="container-fluid"> 
<?php  

if ($Estado != 1) {
  @$contenido=$_GET['contenido']; 
}else{
  @$contenido='info_perso'; 
} 

switch ($contenido){  

case 'MenuLideres':
  include ("includes/Lideres/MenuLideres.php"); 
break;

case 'newlider':
  include ("includes/Lideres/newlider.php"); 
break;

case 'menusemillas':
  include ("includes/menusemillas.php"); 
break;

case 'newsemilla':
  include ("includes/Semillas/newsemilla.php"); 
break;

case 'CrearUsuario':
  include ("includes/CrearUsuario.php"); 
break;

case 'menu_mvsem':
  include ("includes/menu_mvsem.php"); 
break;

case 'upcomprobante':
  include ("includes/upcomprobante.php"); 
break;

case 'dwcomprobante':
  include ("includes/dwcomprobante.php"); 
break;

case 'viewSemilla':
  include ("includes/Semillas/viewSemillas.php"); 
break;

case 'detSemilla':
  include ("includes/Semillas/detSemilla.php"); 
break;

case 'CambiarRol':
  include ("includes/Semillas/CambiarRol.php"); 
break;

case 'MenuPSemillas':
  include ("includes/MenuPSemillas.php"); 
break;

case 'verpsemillas':
  include ("includes/verpsemillas.php"); 
break;

case 'asigMultas':
  include ("includes/asigMultas.php"); 
break;

case 'verMvto':
  include ("includes/verMvto.php"); 
break;

case 'Multas':
  include ("includes/Multas.php"); 
break;

case 'prestamos':
  include ("includes/prestamos.php"); 
break;

case 'info_perso':
  include ("includes/info_perso.php"); 
break;

case 'viewprest':
  include ("includes/viewprest.php"); 
break;

case 'menuprestamos':
  include ("includes/menuprestamos.php"); 
break;

case 'menus_prestamos':
  include ("includes/menus_prestamos.php"); 
break;

case 'detalleprestamos':
  include ("includes/detalleprestamos.php"); 
break;

case 'alertar':
  include ("includes/alertar.php"); 
break;

case 'ver_alerta':
  include ("includes/ver_alerta.php"); 
break;

case 'edit_alerta':
  include ("includes/edit_alerta.php"); 
break;

case 'votaciones':
  include ("includes/votaciones.php"); 
break;

case 'ver_votaciones':
  include ("includes/ver_votaciones.php"); 
break;

case 'menu_reportes':
  include ("includes/menu_reportes.php"); 
break;

case 'procesos_ciclonuevo':
  include ("includes/Semillas/procesos_ciclonuevo.php"); 
break;

case 'carga_incentivos':
  include ("includes/carga_incentivos.php"); 
break;

case 'edit_perso':
  include ("includes/edit_perso.php"); 
break;

case 'Inactivar_persona':
  include ("includes/Inactivar_persona.php"); 
break;

case 'pasociacion':
  include ("includes/pasociacion.php"); 
break;

default:
  $contenido="Inicio";
include ("includes/defecto.php");
}
?>
  </div> 
    <footer class="sticky-footer">
      <div class="container">
        <div class="text-center">
          <small style="font-family: Didot;"><img src="../favicon.ico" style='width: 18px; heigth: 18px'> TintoLibre - © Derechos reservados </small>
        </div>
      </div>
    </footer> 
    <a class="scroll-to-top rounded" href="#page-top">
      <i class="fa fa-angle-up"></i>
    </a> 
    <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">¿Desea cerrar su Sesion?</h5>
            <button class="close" type="button" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">×</span>
            </button>
          </div>
          <div class="modal-body">Seleccione "Salir" si realmente desea finalizar su sesión</div>
          <div class="modal-footer">
            <button class="btn btn-danger" type="submit" data-dismiss="modal">Cancelar</button>
            <form action="Cerrar_sesion.php" method="POST" class="form-register" onsubmit="return validar();" enctype="multipart/form-data" name="Cerrar">
            <input class="form-control" id="Inputipmat" type="hidden" aria-describedby="nameHelp" name="N_usuario" value="<?php echo $User;?>">
            <input class="form-control" id="Inputipmat" type="hidden" aria-describedby="nameHelp" name="N_accesos" value="<?php echo $_SESSION['ingresando'];?>">
            <input class="btn btn-dark" type="submit" name="Salir" value="Salir">
            </form>
          </div>
        </div>
      </div>
    </div> 
    <script src="vendor/jquery/jquery.min.js"></script>
    <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script> 
    <script src="vendor/jquery-easing/jquery.easing.min.js"></script> 
    <script src="vendor/chart.js/Chart.min.js"></script>
    <script src="vendor/datatables/jquery.dataTables.js"></script>
    <script src="vendor/datatables/dataTables.bootstrap4.js"></script> 
    <script src="js/sb-admin.min.js"></script> 
    <script src="js/sb-admin-datatables.min.js"></script>
    <script src="js/sb-admin-charts.min.js"></script>
  </div>
</body>

<?php
}else{
  echo '<script>window.location="../index.php";</script>';
}
  ?>
</html>