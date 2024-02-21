<?php 

$cons = "SELECT v.id, case when v.Id_prestamo is null then 'Exclusion persona' else 'Aprobacion de prestamos' end as tipo, v.Nombre, v.Observaciones, v.FechaSol, v.Integrantes, p.ValPrestamo, up.Name, p.Id_responsable, (SELECT COUNT(opcion) from votaciones_part where id_votacion = v.id) as votadas FROM votaciones v left JOIN prestamos p on p.Id = v.Id_prestamo left join usuario u on u.Id_usuario = v.Id_persona left join usuario up on up.Id_usuario = p.Id_responsable inner join integrantes_semilla iss on iss.Id_semilla = v.Id_semilla inner join conformacion_semilla cs on cs.Id_Semilla = v.Id_semilla WHERE iss.Id_persona = $User or cs.Lider_Semilla = $User GROUP BY v.id ORDER BY v.id DESC";

$Query = $conexion->query($cons);


?>

<ol class="breadcrumb"> 
    <li class="breadcrumb-item">Votaciones</li>
</ol>

<meta charset="utf-8">
<div class="container-fluid">
      <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0"> 
        <thead><tr align="center"> 
            <td><strong>#</strong></td> 
            <td><strong>Tipo</strong></td>  
            <td><strong>Observaciones</strong></td>
            <td><strong>Fecha</strong></td>
            <td><strong>Responsable</strong></td>
            <td><strong>Avance</strong></td>
            <td><strong>Ver</strong></td>  
        </tr></thead>
        <tbody>
		<?php $n=1; while ($Le = mysqli_fetch_array($Query)) {
			$valueToDiv = 1;
            if ($Le['Integrantes'] > 0) {
                $valueToDiv = $Le['Integrantes'];
            }
            $val = ($Le['votadas'] == 0) ? $part = 0 : $part = ($Le['votadas']/$valueToDiv)*100 ;
            echo "<tr>
            	<td>".$n++."</td>
            	<td>".$Le['tipo']."</td> 
            	<td>".$Le['Observaciones']."</td>
            	<td>".$Le['FechaSol']."</td>
            	<td>".$Le['Name']."</td>
            	<td align='right'>".round($part, 2)."%</td>
            	<td>
					<form action='?contenido=ver_votaciones' method='POST' class='form-register'>
                        <input type='hidden' name='id_v' value='".$Le['id']."'>
						<input type='hidden' name='integrantes' value='".$Le['Integrantes']."'>
						<input name='VerVota' class='btn btn-dark btn-block' type='submit' value='Ver'/> 
					</form>  

            	</td>
            </tr>";
        } ?> 
        </tbody>
    </table>
</div>