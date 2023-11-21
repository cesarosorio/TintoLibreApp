<?php 

/**
 * 
 */
class Ajuste{
	
	public function multas($Semilla, $TipoPago){
		require 'conexion.php'; 
		
		$Dia = Date("d");
		$RM=$conexion->query("SELECT id, Valor_Multa, Presidente FROM multas_semilla WHERE id_semilla = $Semilla AND NombreMulta = 'Pago tarde'");
		$NMu = mysqli_num_rows($RM);
		if ($NMu == 1) {
			$M = mysqli_fetch_assoc($RM);
			$Id_Multa = $M['id'];
			$Presidente = $M['Presidente'];
		
			if ($TipoPago == 2) {  
				$D = mysqli_fetch_assoc($conexion->query("SELECT quimaximo, quimaxidos FROM diasparapago WHERE id_semilla = $Semilla"));
				$quimaximo = $D['quimaximo'];
				$quimaxidos = $D['quimaxidos'];
				if($Dia >= 1 AND $Dia <= 15){
					if ($Dia > $quimaximo) {
						$Multa = 1;
					}else{
						$Multa = 0;
					}
				}else{
					if ($Dia > $quimaxidos) {
						$Multa = 1;
					}else{
						$Multa = 0;
					}
				}
			}else{
				$D = mysqli_fetch_assoc($conexion->query("SELECT mesmaximo FROM diasparapago WHERE id_semilla = $Semilla"));
				$mesmaximo = $D['mesmaximo']; 
				 
				if ($Dia > $mesmaximo) {
					$Multa = 1;
				}else{
					$Multa = 0;
				}
			}
		
		    return $Multa = array('Multa' => $Multa, 'Presidente' => $Presidente, 'Id_Multa' => $Id_Multa, 'ValMulta' => $M['Valor_Multa']); 

		}else{
		    return $Multa = array('Multa' => 0, 'Presidente' => 0, 'Id_Multa' => 0, 'ValMulta' => 0); 
		}
		

	} // Multa

	public function prestamo($Semilla, $User, $CuotaPrestamo, $Mvto){
		
		require 'conexion.php'; 
		
		$ValPrestamos="SELECT Id, intereses, ValPrestamo FROM prestamos WHERE Id_responsable = $User AND Estado = 6 AND Tipo = 1 GROUP BY Id";
		$MP = $conexion->query($ValPrestamos);
		$nprestamo = mysqli_num_rows($MP);


			    
	    if ($nprestamo == 1){
			$R = mysqli_fetch_assoc ($MP);
			$Id = $R['Id']; 
			$meactual = DATE("m");
			$ValEsteMes="SELECT Id FROM mv_prestamos_sem WHERE Id_prestamo = $Id AND MONTH(Fecha) = $meactual";
			$MV = $conexion->query($ValEsteMes);
			$cms = mysqli_num_rows($MV);

			if ($cms == 0 ) {
				$intereses = ($R['intereses'])/100; 
			}else{
				$intereses = 0;
			}

			$ValPrestamo = $R['ValPrestamo'];
			$CuoMinima = $intereses*$ValPrestamo;
			$Capital = ($CuotaPrestamo == 0) ? 0 : $CuotaPrestamo - $CuoMinima;

			$Diferencia = ($ValPrestamo-$Capital);
			if ($Diferencia < 0) {
				$Acabar = ', Estado = 7 ';
			}else{
				$Acabar = '';
			}			

			$a = "INSERT INTO mv_prestamos_sem(Id_prestamo, Id_semilla, Id_mvto, Capital, Intereses, Fecha) VALUES ($Id, $Semilla, $Mvto, $Capital, $CuoMinima, NOW())";
			if ($conexion -> query($a)){
				$act = "UPDATE prestamos SET ValPrestamo = $Diferencia $Acabar WHERE Id = $Id ";
				if ($conexion -> query($act)) {
					return $Capital+$CuoMinima;
				}
			}else{
				return 0;
			}

		}else{
			return 0;
		}

	}


}