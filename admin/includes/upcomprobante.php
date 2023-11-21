<script type="text/javascript">
  function showContent() {
      element = document.getElementById("content");
      check = document.getElementById("check");
      if (check.checked) {
          element.style.display='block';
      }
      else {
          element.style.display='none';
      }
  }
</script>

<?php 

 

if ($Permiso == 2){
  $menu = 1;
  $Data = $conexion -> query("SELECT DISTINCT CS.id_semilla, CS.Nombre_Semilla FROM conformacion_semilla CS INNER JOIN integrantes_semilla ISS ON ISS.id_semilla = CS.id_semilla WHERE CS.Estado_Semilla IN (2, 3) AND (ISS.Id_persona = $User OR CS.Lider_Semilla = $User)"); 
}else{
  $menu = 2;
  $Data = $conexion -> query("SELECT DISTINCT CS.id_semilla, CS.Nombre_Semilla FROM conformacion_semilla CS INNER JOIN integrantes_semilla ISS ON ISS.id_semilla = CS.id_semilla WHERE CS.Estado_Semilla IN (2, 3) AND ISS.Id_persona = $User ");
}

?>
<ol class="breadcrumb"> 
    <li class="breadcrumb-item">Menú de opciones.</li>
    <li class="breadcrumb-item active">Cargar mis comprobantes.</li>
</ol>


<?php if (!isset($_POST['CargarSemilla'])) { ?>

<form method="POST" class="form-register" >
  
<div class="row">
  
  <div class="col-md-4">
    <div class="form-group">
      <label>Seleccione la semilla</label> 
    </div>
  </div>

  <div class="col-md-8">
    <div class="form-group">
      <select list="Semilla" class="form-control" type="text" name="Lider" required>  
        <option></option>
          <?php while ($Lee = mysqli_fetch_array($Data)) { 
            echo "<option value=".$Lee['id_semilla'].">".$Lee['Nombre_Semilla']."</option>";  
          } ?>
      </select> 
    </div>
  </div>

  <div class="col-md-12"> 
      <input name="CargarSemilla" class="btn btn-dark btn-block" type="submit" value="Continuar"/>   
  </div>

</div>


<?php }else{  
$semilla = $_POST['Lider']; 

$R=mysqli_fetch_assoc($conexion->query("SELECT ms.Lider_Semilla, ms.Nombre_Semilla, ms.minimo, ms.maximo FROM conformacion_semilla ms  WHERE ms.id_semilla = $semilla") );
$Nombre_Semilla = $R['Nombre_Semilla'];
$minimo = $R['minimo'];
$maximo = $R['maximo']*1.15;
$Lider_Semilla = $R['Lider_Semilla'];


if($menu == 1 AND $Lider_Semilla == $User){

    $R=mysqli_fetch_assoc($conexion->query("SELECT ms.Nombre_Semilla, ms.minimo, ms.maximo, iss.Rol FROM conformacion_semilla ms inner join integrantes_semilla iss on iss.Id_semilla = ms.Id_Semilla WHERE ms.id_semilla = $semilla and ms.Lider_Semilla = $User") );

}else{
    $R=mysqli_fetch_assoc($conexion->query("SELECT ms.Nombre_Semilla, ms.minimo, ms.maximo, iss.Rol FROM conformacion_semilla ms inner join integrantes_semilla iss on iss.Id_semilla = ms.Id_Semilla WHERE ms.id_semilla = $semilla and iss.Id_persona = $User") );
}

$Rol = $R['Rol'];

 
?>

<form action="includes/Funciones/CargaArchivos.php" method="POST" class="form-register" enctype="multipart/form-data">
    <div class="row"> 
    <?php 

    if ($menu == 1 OR $Rol == 2) { ?>
      
    <div class="col-md-6">
      <div class="form-group">
        <label>A nombre de: </label>
          <select list="AUser" class="form-control" type="text" name="AUser" required>  
            <option></option>
             <?php $Data = $conexion -> query("SELECT u.Id_usuario, CONCAT(cs.Nombre_Semilla, ' - ', u.Name) Nombre FROM conformacion_semilla cs inner join integrantes_semilla iss on iss.Id_semilla = cs.Id_Semilla inner join usuario u on u.Id_usuario = iss.Id_persona WHERE cs.Id_Semilla = $semilla ORDER BY u.Name ASC");
            while ($Lee = mysqli_fetch_array($Data)) { 
              echo "<option value=".$Lee['Id_usuario'].">".$Lee['Nombre']."</option>";  
            } ?>
          </select> 
      </div>
    </div>

    <div class="col-md-3">
      <div class="form-group">
        <label>Valor consignado</label>
        <input class="form-control" type="number" name="Valor" min='<?php echo $minimo ?>' max='<?php echo $maximo ?>' required>
      </div>
    </div>

    <div class="col-md-3">
      <div class="form-group">
        <label>Fecha de la consignación</label>
        <input class="form-control" type="date" name="Fecha" required>
      </div>
    </div>

    <?php }else{ ?>

      <input type="hidden" name="AUser" value="<?php echo $User ?>">

      <div class="col-md-6">
        <div class="form-group">
          <label>Valor consignado</label>
          <input class="form-control" type="number" name="Valor" min='<?php echo $minimo ?>' max='<?php echo $maximo ?>' required>
        </div>
      </div>

      <div class="col-md-6">
        <div class="form-group">
          <label>Fecha de la consignación</label>
          <input class="form-control" type="date" name="Fecha" required>
        </div>
      </div>
    
    <?php } ?>
  

    <div class="col-md-12">
      <div class="form-group">
        <label>Observaciones</label>
        <textarea class="form-control" type="date" name="Observaciones"></textarea>
      </div>
    </div> 


    <div class="col-md-4">
      <div class="form-group">
        <label>¿Aportará cuota de algún préstamo?</label>
          <input type="checkbox" name="check" id="check" value="1" onchange="javascript:showContent()" /> 
      </div>
    </div> 

    <div class="col-md-8">
      <div id="content" style="display: none;"> 
        <div class="form-group">
          <input class="form-control" type="number" name="CuotaPrestamo">
        </div> 
      </div>
    </div>
    
    <div class="col-md-6">
      <div class="form-group">
        <label>Semilla Elegida</label>
        <input class="form-control" type="text" readonly value="<?php echo $Nombre_Semilla ?>">
      </div>
    </div>    

    <div class="col-md-6">
      <div class="form-group">
        <label>Comprobante (.PDF, .JEPG, .PNG)</label>
        <input accept="application/pdf, image/*" class="form-control" type="file" name="Comprobante" required>
      </div>
    </div>

    <div class="col-md-12"> 
      <input type="hidden" name="Lider" value="<?php echo $semilla ?>">
      <input name="IngresarComprobante" class="btn btn-dark btn-block" type="submit" value="Cargar comprobante"/>
    </div>


    </div>
</form>

<?php } ?>