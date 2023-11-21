<?php

$Sem = $_POST['Semilla'];
$Mvto = $_POST['Mvto'];
$Usuario = $_POST['Usuario'];

$R=mysqli_fetch_assoc($conexion->query("SELECT Nombre_Semilla, Lider_semilla FROM conformacion_semilla WHERE id_semilla = ".$Sem)); 
$Nombre_Semilla = $R['Nombre_Semilla'];
$Lider_semilla = $R['Lider_semilla'];

$MV=mysqli_fetch_assoc($conexion->query("SELECT mv.id, u.Name, mv.Valor, mv.AporteSocial, mv.Observaciones, mv.Fecha, mv.Fecha_cp, mp.Capital, mp.Intereses FROM mv_meta_semilla mv inner join usuario u on u.Id_usuario = mv.Id_usuario left join mv_multa_semilla mm on mm.Id_mvto = mv.Id left join mv_prestamos_sem mp on mp.Id_mvto = mv.Id left join multas_semilla ms on ms.Id_semilla = mv.Id_semilla WHERE mv.Id = ".$Mvto)); 

$mvto = $MV['id'];

$dt = $conexion -> query("SELECT mm.id, mm.Valor_multa, concat(ms.NombreMulta, ', ', ms.ObserMultas) as tipomulta FROM mv_multa_semilla mm inner join multas_semilla ms on ms.Id = mm.Id_multa WHERE mm.Id_mvto = $mvto");


?>

<ol class="breadcrumb"> 
    <li class="breadcrumb-item">Menú de opciones.</li> 
    <li class="breadcrumb-item">INFORMACIÓN DE MIS SEMILLAS.</li> 
    <li class="breadcrumb-item active"><strong>Semilla:</strong> <?php echo $Nombre_Semilla  ?></li>
</ol>

<form action='includes/procesoalerta.php' method='POST' class='form-register'>
	<div class="row"> 
	     <div class="col-md-3">
	          <strong>Integrante: </strong>
	     </div>

	     <div class="col-md-3">
	          <?php echo ($MV['Name']) ?>
	     </div>

	     <div class="col-md-3">
	          <strong>Observaciones: </strong> 
	     </div>

	     <div class="col-md-3">
	          <?php echo ($MV['Observaciones']) ?>
	     </div>

	     <div class="col-md-12"><br></div>

	     <div class="col-md-3">
	          <strong>Ahorro: </strong> 
	     </div>

	     <div class="col-md-3">
	          <?php echo "$".number_format(round($MV['Valor'], 0), 0) ?>
	     </div>

	     <div class="col-md-3">
	          <strong>Aporte Social: </strong> 
	     </div>

	     <div class="col-md-3">
	          <?php echo "$".number_format(round($MV['AporteSocial'], 0), 0) ?>
	     </div>

	     <div class="col-md-12"><br></div>

	     <div class="col-md-3">
	          <strong>Prestamos, capital: </strong> 
	     </div>

	     <div class="col-md-3">
	          <?php echo "$".number_format(round($MV['Capital'], 0), 0) ?>
	     </div>

	     <div class="col-md-3">
	          <strong>Prestamos, intereses: </strong> 
	     </div>

	     <div class="col-md-3">
	          <?php echo "$".number_format(round($MV['Intereses'], 0), 0) ?>
	     </div>

	     <div class="col-md-12"><br></div>


	     <?php while ($Lee = mysqli_fetch_array($dt)) { ?>
	     
	     <div class="col-md-3">
	          <strong>Multa Nro.: <?php echo $Lee['id'] ?> </strong> 
	     </div>

	     <div class="col-md-3">
	          <?php echo utf8_decode($Lee['tipomulta']) ?>
	     </div>

	     <div class="col-md-3">
	          <strong>Valor de la multa</strong> 
	     </div>

	     <div class="col-md-3">
	          <?php echo "$".number_format(round($Lee['Valor_multa'], 0), 0) ?>
	     </div>

	     <div class="col-md-12"><br></div>

	     <?php } ?>    

	     <div class="col-md-3">
	          <strong>Fecha: </strong> 
	     </div>

	     <div class="col-md-3">
	          <?php echo $MV['Fecha'] ?>
	     </div>

	     <div class="col-md-3">
	          <strong>Fecha de captura</strong> 
	     </div>

	     <div class="col-md-3">
	          <?php echo $MV['Fecha_cp'] ?>
	     </div>

	     <div class="col-md-12"><br></div>

	     <div class="col-md-12">
			<div class="form-group">
				<strong><label>Observaciones <font color="red">*</strong></font></label>
				<textarea class="form-control" type="number" name="Observaciones" required></textarea>
			</div>
	     </div>

	     <div class="col-md-12">	       
			<input type='hidden' name='Semilla' value='<?php echo $Sem ?>'>
			<input type='hidden' name='Mvto' value='<?php echo $Mvto ?>'>  
			<input type='hidden' name='Notifica' value='<?php echo $User ?>'>  
			<input name='Alertar' class='btn btn-danger btn-block' type='submit' value='Alertar'/>
	     </div>
	     
	</div>
</form>

<br> 
<div class="row"> 
    <div class="col-md-4"></div>
    <div class="col-md-4"></div>
    <div class="col-md-4">	        
    <form action='?contenido=verMvto' method='POST' class='form-register'>
        <input type='hidden' name='Semilla' value="<?php echo $Sem ?>">  
        <input type='hidden' name='AUser' value="<?php echo $Usuario ?>">  
        <input name='VerMv' class='btn btn-dark btn-block' type='submit' value='Volver'/>
    </form>
    </div>
</div>
<br>