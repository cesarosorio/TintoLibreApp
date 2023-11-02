<?php

if(isset($_POST['employee_id'])){
    $Documento = $_POST['employee_id'];

    ?>

        <button class="btn btn-danger btn-block" type="submit" data-dismiss="modal">No</button>
        <br>
        <form action='?contenido=Inactivar_persona' method='POST' class='form-register'> 
        <input type='hidden' value="<?php echo $Documento; ?>" name="Documento" >
        
        <input class="btn btn-success btn-block" type="submit" name="Si" value="Sí">
        </form>
<?php 

}

if(isset($_POST['Si'])){
    $Documento = $_POST['Documento'];
    $User; 
    $R=mysqli_fetch_assoc($conexion->query("SELECT Estado FROM usuario WHERE Id_usuario  = $Documento")); 
    echo $Estado = $R['Estado'];
    
    $Tipo = ($Estado == 1) ? 2 : 1 ;
    $NEstado = ($Estado == 1) ? 0 : 1;

    $conexion->query("INSERT INTO admin_personal (Id_usuario, Tipo, Lider, Fecha) VALUES ($Documento, $Tipo, $User, NOW())");
    $Cambio = "UPDATE usuario SET Estado = $NEstado, FechaInac = NOW() WHERE Id_usuario = $Documento";

    if($conexion->query($Cambio)){
        ?><script languaje="javascript">
            window.location.href="../../../admin/index.php?contenido=edit_perso"; 
            alert("¡Se cambio la información correctamente!");
        </script><?php
    }else{ 
        ?><script languaje="javascript">
            window.location.href="../../../admin/index.php?contenido=edit_perso"; 
            alert("¡Error!");
        </script><?php    
    }

}
