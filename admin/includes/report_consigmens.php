<?php $id = $_POST["employee_id"];

$Meses[] = array('Mes' => 1, 'NombMes' => 'Enero');
$Meses[] = array('Mes' => 2, 'NombMes' => 'Febrero');
$Meses[] = array('Mes' => 3, 'NombMes' => 'Marzo');
$Meses[] = array('Mes' => 4, 'NombMes' => 'Abril');
$Meses[] = array('Mes' => 5, 'NombMes' => 'Mayo');
$Meses[] = array('Mes' => 6, 'NombMes' => 'Junio');
$Meses[] = array('Mes' => 7, 'NombMes' => 'Julio');
$Meses[] = array('Mes' => 8, 'NombMes' => 'Agosto');
$Meses[] = array('Mes' => 9, 'NombMes' => 'Septiembre');
$Meses[] = array('Mes'=> 10, 'NombMes' => 'Octubre');
$Meses[] = array('Mes'=> 11, 'NombMes' => 'Noviembre');
$Meses[] = array('Mes'=> 12, 'NombMes' => 'Diciembre');

for ($i=2022; $i <= Date("Y") ; $i++) { 
  $Anio[] = array('Anio' => $i);
  
}

if ($id == 1) { ?>
  
<form action="../admin/PHPExcel/Examples/report_consignacionmensual.php" method="POST" class="form-register">
  <div class="row">   
    <div class="col-md-6">
      <div class="form-group">
        <label>Año </label>
          <select list="Anio" class="form-control" type="text" name="Anio" required>  
            <option></option>
            <?php foreach ($Anio as $LisAnio) { 
              echo "<option value=".$LisAnio['Anio'].">".$LisAnio['Anio']."</option>";
            } ?>
          </select> 
      </div>
    </div>

    <div class="col-md-6">
      <div class="form-group">
        <label>Mes </label>
          <select list="Mes" class="form-control" type="text" name="Mes" required>  
            <option></option>
            <?php foreach ($Meses as $LisMes) { 
              echo "<option value=".$LisMes['Mes'].">".$LisMes['NombMes']."</option>";
            } ?>
          </select> 
      </div>
    </div>

    <div class="col-md-12"> 
      <input class="btn btn-dark btn-block" type="submit" value="Descargar Informe"/>
    </div>

  </div>
</form>

<?php }elseif($id == 2){ ?>

<form action="../admin/PHPExcel/Examples/report_consignacionsemilla.php" method="POST" class="form-register">
  <div class="row">   
    <div class="col-md-6">
      <div class="form-group">
        <label>Año </label>
          <select list="Anio" class="form-control" type="text" name="Anio" required>  
            <option></option>
            <?php foreach ($Anio as $LisAnio) { 
              echo "<option value=".$LisAnio['Anio'].">".$LisAnio['Anio']."</option>";
            } ?>
          </select> 
      </div>
    </div>

    <div class="col-md-6">
      <div class="form-group">
        <label>Mes </label>
          <select list="Mes" class="form-control" type="text" name="Mes" required>  
            <option></option>
            <?php foreach ($Meses as $LisMes) { 
              echo "<option value=".$LisMes['Mes'].">".$LisMes['NombMes']."</option>";
            } ?>
          </select> 
      </div>
    </div>

    <div class="col-md-12"> 
      <input class="btn btn-dark btn-block" type="submit" value="Descargar Informe"/>
    </div>

  </div>
</form>

<?php }elseif($id == 3){ ?>
  <form action="../admin/PHPExcel/Examples/report_numcuenta.php" method="POST" class="form-register">
    <div class="row">   
      <div class="col-md-12"> 
        <input class="btn btn-dark btn-block" type="submit" value="Descargar Informe"/>
      </div>
    </div>
  </form> 
<?php } ?>