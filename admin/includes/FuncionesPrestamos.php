<?php 

include 'conexion.php';

if (isset($_POST['SolPrestamo'])) {
    $id_semilla = $_POST['Lider'];
    $ValPrestamo = $_POST['ValPrestamo'];
    $Id_responsable = $_POST['Responsable'];
    $Justificacion = $_POST['Justificacion']; 
    
    $SolPrss = "INSERT INTO prestamos (Id_responsable, id_semilla, ValPrestamo, Justificacion, FechaSolicitud, Estado) VALUES ($Id_responsable, $id_semilla, $ValPrestamo, '$Justificacion', NOW(), 1)";
    if ($conexion -> query($SolPrss)) { 
        ?><script languaje="javascript">
            alert("¡Se realizo con exito la solicitud!");
            window.location.href="../../admin/index.php?contenido=prestamos"; 
        </script> <?php
    }else{
        ?><script languaje="javascript">
            window.location.href="../../admin/index.php?contenido=prestamos"; 
            alert("¡Algo ocurrio, intenta de nuevo!");
        </script> <?php
    }
 
}