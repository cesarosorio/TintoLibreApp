$conexion = new mysqli("database","tintoLibreApp","Ac1dl0v3!","tintoLibreApp");
if ($conexion -> connect_errno)
{
	die("Fallo conexion:(".$conexion -> mysqli_connect_errno().")".$conexion -> mysqli_connect_errno());
}


		date_default_timezone_set('America/Bogota');
		$dia = date("d")+1;
		include 'includes/conexion.php';

		$NS=$conexion->query("SELECT Id_semilla from diasparapago where quimaximo = $dia or quimaxidos = $dia or mesmaximo = $dia");
		while ($e = mysqli_fetch_array($NS)) {
			$ConsultaList = $conexion->query("SELECT iss.Id_semilla, u.id_usuario, u.Name, case when u.correo is null then 'No' else u.correo end AS Correo FROM integrantes_semilla iss left join usuario u on u.Id_usuario = iss.Id_persona and u.Rol = 5 WHERE iss.Id_semilla = ".$e['Id_semilla']);
			
			while ($Le = mysqli_fetch_array($ConsultaList)) {

				$cabeceras = 'From: admin@tusemilla.com.co';
				$asunto="No olvides tu ahorro, as".utf8_decode('í')." estar".utf8_decode('á')."s m".utf8_decode('á')."s cerca de tu meta.";
		        $Correo = $Le['Correo'];
				$mensaje ="Hola soñador(a) ".utf8_decode($Le['Name'])."

Te recordamos que tienes un día para hacer el depósito de dinero en la cuenta y registrarlo en tusemilla.com.co para que estés cada vez más cerca de cumplir tu meta. 

No dudes en contactarte con tu líder de semilla si tienes alguna duda.

Att: TintoLibre"; 
mail($Correo, $asunto, $mensaje, $cabeceras);
			}
		}
		
echo "Ok";
	
	
		date_default_timezone_set('America/Bogota');
		$dia = date("d")-1;
		include 'includes/conexion.php';

		$NS=$conexion->query("SELECT Id_semilla from diasparapago where quimaxidos = $dia or mesmaximo = $dia");
		$arry[] = mysqli_fetch_array($NS);


		foreach ($arry as $e ) {
			$ConsultaList = $conexion->query("SELECT cs.Nombre_Semilla, iss.Meta_personal, iss.Id_semilla, u.id_usuario, u.Name, case when u.correo is null then 'No' else u.correo end AS Correo FROM integrantes_semilla iss left join usuario u on u.Id_usuario = iss.Id_persona and u.Rol = 5 inner JOIN conformacion_semilla cs on cs.Id_Semilla = iss.Id_semilla WHERE iss.Id_semilla = ".$e['Id_semilla']);

			while ($Le = mysqli_fetch_array($ConsultaList)) {

				if ($Le['Correo'] != 'No') {

					$semilla = $Le['Id_semilla'];
					$Persona = $Le['id_usuario'];
					$Meta = $Le['Meta_personal'];
					$Nombre_Semilla = $Le['Nombre_Semilla'];

					$R=mysqli_fetch_assoc($conexion->query("SELECT SUM(Valor) AS d  FROM mv_meta_semilla mv WHERE mv.Id_usuario = $Persona and Id_semilla = $semilla"));
					$Valor = $R['d'];

					$RR=mysqli_fetch_assoc($conexion->query("SELECT SUM(AporteSocial) as c FROM mv_meta_semilla mv WHERE mv.Id_usuario = $Persona and Id_semilla = $semilla")); 
					$Aporte = $RR['c'];

					$Val = ($Meta == 0 OR $Valor == 0) ? $Por = 0 : $Por = ($Valor/$Meta)*100 ;

					$cabeceras = 'From: admin@tusemilla.com.co';
			     	$asunto = utf8_decode("Tu semilla ".utf8_decode($Nombre_Semilla)." ha alcanzado ")." ".number_format($Aporte, 0);
			      	$Correo = $Le['Correo'];
			      	$mensaje="¡Hola, ".utf8_decode($Le['Name'])."! 

Queremos informarte que durante este mes tu has ahorrado ".number_format($Aporte+$Valor).", que corresponde al ".number_format(round($Por, 2), 2)."% del sueño de tu meta. 

Continúa ahorrando, cada vez estás más cerca de alcanzar tu meta.

Att: TintoLibre";

mail($Correo, $asunto, $mensaje, $cabeceras);

					
				}		

			}

		}
echo "ok resumen"; 