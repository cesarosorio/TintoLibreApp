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

// error_reporting(0);
include 'conexion.php';

$pres = $_POST['employee_id'];

$P=mysqli_fetch_assoc($conexion->query("SELECT p.Tipo, p.Estado, p.Id, u.Name, cs.Nombre_Semilla, p.ValPrestamo, p.intereses, p.Justificacion, p.FechaSolicitud, p.FechaRespuesta, es.EstadoPrestamo FROM prestamos p INNER JOIN usuario u on u.Id_usuario = p.Id_responsable INNER JOIN conformacion_semilla cs on cs.id_semilla = p.id_semilla INNER JOIN estados_prestamos es on es.Id = p.Estado WHERE p.Id = $pres GROUP BY p.Id"));  


$R=mysqli_fetch_assoc($conexion->query("SELECT p.Aprobado, cs.id_semilla, es.Id, cs.Lider_semilla, u.Name, cs.Nombre_Semilla, p.ValPrestamo, p.Justificacion, p.FechaSolicitud, es.EstadoPrestamo FROM prestamos p INNER JOIN usuario u on u.Id_usuario = p.Id_responsable INNER JOIN conformacion_semilla cs on cs.id_semilla = p.id_semilla INNER JOIN estados_prestamos es on es.Id = p.Estado WHERE p.Id = $pres"));  

$V=mysqli_fetch_assoc($conexion->query("SELECT (SELECT SUM(mv.aportesocial) FROM mv_meta_semilla mv WHERE mv.id_semilla = cs.id_semilla GROUP BY mv.id_semilla) + (SELECT SUM(mm.Valor_multa) AS Multas FROM mv_multa_semilla mm WHERE mm.id_semilla = cs.id_semilla GROUP BY mm.id_semilla) AS FONDOI FROM conformacion_semilla cs WHERE cs.id_semilla = ".$R['id_semilla']));  
$ValorFondos = $V['FONDOI'];

$MP = $conexion->query("SELECT es.Id, es.EstadoPrestamo FROM estados_prestamos es WHERE es.Id IN (2, 3, 4) ");  
$APR = $R['Aprobado'];
$Val = ($ValorFondos < $R['ValPrestamo']) ? $a = 1 : $a =  0;


if ($a = 0) { ?>
     <h6>Lo sentimos, el prestamo por un monto de $<?php echo number_format($R['ValPrestamo'], 0, ",", ".") ?> supera a los $<?php echo number_format($ValorFondos, 0, ",", ".") ?> del fondo de ahorro de tu semilla. 😥</h6>
<?php }else{ ?>

<div class="row">
     <div class="col-md-4">
          <strong>Solicitante: </strong><?php echo utf8_encode($R['Name']) ?>
     </div>
     <div class="col-md-4">
          <strong>Semilla: </strong><?php echo utf8_encode($R['Nombre_Semilla']) ?>
     </div>
     <div class="col-md-4">
          <strong>Justificacion: </strong><?php echo utf8_encode($R['Justificacion']) ?>
     </div>
</div>
<div class="row">
     <div class="col-md-4">
          <strong>Solicitado: </strong>$<?php echo number_format($R['ValPrestamo'], 0) ?>
     </div>
     <div class="col-md-4">
          <strong>Fecha: </strong><?php echo substr($R['FechaSolicitud'], 0, 10) ?>
     </div>
     <div class="col-md-4">
          <strong>Estado: </strong><?php echo utf8_encode($R['EstadoPrestamo']) ?>
     </div>
</div>
<hr>
<?php    
if ($R['Id'] == 1 ) { ?>
     
<form autocomplete="off" action="includes/ModPrestamo.php" method="POST">
<div class="row">
<?php while($Lee=$MP->fetch_array(MYSQLI_BOTH)){
     echo "<div class='col-md-4'>
          <div class='form-group'>
               <div class='form-check'>";
               if ($Lee['Id'] == 2) {
                    echo "<input required class='form-check-input' type='radio' value=".$Lee['Id']." name='EstadoPrestamo' id='check' onchange="; ?> javascript:showContent() <?php echo ">".$Lee['EstadoPrestamo']."";

               }else{
                    echo "<input required class='form-check-input' type='radio' value=".$Lee['Id']." name='EstadoPrestamo'>".$Lee['EstadoPrestamo']."";
               }
               echo "</div>    
          </div>     
     </div>";
} ?>
</div> 
<hr>
<div id="content" style="display: none;">
     <div class="row">
          <div class='col-md-12'>
               <strong>Nota: </strong> a pesar de aprobar el prestamo he indicar las condiciones del mismo, el solicitante (<strong><?php echo utf8_encode($R['Name']) ?></strong>) tomará la decision de aceptar las reglas del juego.
               <hr>
          </div> 

          <div class='col-md-4'>
               <label>Tasa de interes %</label>
          </div> 

          <div class='col-md-8'>
               <input class="form-control" type="number" step="0.002" name="intereses">
          </div> 
     </div>
</div> 
<br> 
<?php if ($APR == 2) { ?>
  <div class="row">
   <div class='col-md-12' align="center">
        ¡Lo sentimos, aun no aprueban el voto, go go a votar!
   </div>
 </div>
<?php }else{ ?>
<div class="row">
   <div class='col-md-12'>
        <input type="hidden" name="IdPres" value="<?php echo $pres; ?>">  
        <input type="submit" name="EnvRespuesta" value="Enviar respuesta" class="btn btn-dark btn-block">
   </div>
 </div>
<?php } ?>

</form>
<?php }else{ ?>
<div class="row">
   <div class='col-md-12' align="center">Movimientos del prestamo</div>
   <div class='col-md-12'><hr></div>
   
   <div class='col-md-3'>Id</div>
   <div class='col-md-3'>Fecha</div>
   <div class='col-md-3'>Capital</div>
   <div class='col-md-3'>Intereses</div>

   <div class='col-md-12'><hr></div>

  <?php 
     if($P['Tipo'] == 1)
          $P = $conexion->query("SELECT mp.Id, mp.Fecha, mp.Capital, mp.Intereses FROM mv_prestamos_sem mp WHERE mp.Id_prestamo = $pres ");
     else
          $P = $conexion->query("SELECT mp.Id, mp.Fecha_pago Fecha, mp.Capital, mp.Interesesc Intereses FROM pasociacion mp WHERE mp.Tipo = 2 AND mp.Id_prestam = $pres ");

  
   while ($LP = mysqli_fetch_array($P)) { ?>
       <div class='col-md-3'><?php echo $LP['Id'] ?></div>
       <div class='col-md-3'><?php echo $LP['Fecha'] ?></div>
       <div class='col-md-3'>$<?php echo number_format($LP['Capital']) ?></div>
       <div class='col-md-3'>$<?php echo number_format(round($LP['Intereses'], 0), 0) ?></div>
     
   <?php } ?>

</div>

<?php } 
}

