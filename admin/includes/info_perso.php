<?php 
error_reporting(0);
$Data = $conexion -> query("SELECT IU.CedulaTit, IU.Titular, CASE WHEN U.Genero = 'F' THEN 'Femenino' ELSE 'Masculino' END as Genero, U.Correo, U.Celular, U.FechaNacimiento, U.password, B.Id, IU.NroCuenta, IU.TipoCuenta, B.Banco FROM usuario U LEFT JOIN info_usuarios IU ON IU.Id_usuario = U.Id_usuario LEFT JOIN bancos B ON B.Id = IU.Banco WHERE U.Id_usuario = $User");
$R=mysqli_fetch_assoc($Data);
$Genero = $R['Genero'];
$Correo = $R['Correo'];
$Celular = $R['Celular'];
$FechaNacimiento = $R['FechaNacimiento'];
$password = $R['password'];
$NroCuenta = $R['NroCuenta'];
$TipoCuenta = $R['TipoCuenta'];
$Banco = $R['Banco'];
$IDBanco = $R['Id'];
$CedulaTit = $R['CedulaTit'];
$Titular = $R['Titular'];

?>
<ol class="breadcrumb"> 
    <li class="breadcrumb-item active">Informacion personal.</li>
</ol> 

<form autocomplete='off' action="includes/CambiarInformacion.php" method="POST" class="form-register">
    <div class="row">
        <div class="col-md-12" align="center"><hr></div>
        
        <div class="col-md-12" align="center"><strong><?php echo strtoupper($Nombre) ?></strong></div>
        <div class="col-md-12" align="center"><hr></div>

        <div class="col-md-2">Documento</div>
        <div class="col-md-2">
            <div class="form-group">
                <input class="form-control" type="text" value="<?php echo number_format($User) ?>" readonly> 
            </div>
        </div>
        <div class="col-md-2">Genero</div>
        <div class="col-md-2">
            <div class="form-group">
                <input class="form-control" type="text" value="<?php echo $Genero ?>" readonly> 
            </div>
        </div>
        <div class="col-md-2">Correo</div>
        <div class="col-md-2">
            <div class="form-group">
                <input class="form-control" type="email" name="correo" value="<?php echo $Correo ?>" > 
            </div>
        </div>
        
        <div class="col-md-12" align="center"><hr></div>

        <div class="col-md-2">Celular</div>
        <div class="col-md-2">
            <div class="form-group">
                <input class="form-control" type="number" name="celular" value="<?php echo $Celular ?>" > 
            </div>
        </div>
        <div class="col-md-2">Fecha nacimiento</div>
        <div class="col-md-2">
            <div class="form-group">
                <input class="form-control" type="date" name="FechaNacimiento" value="<?php echo $FechaNacimiento ?>" readonly> 
            </div>
        </div>
        <div class="col-md-2">Contraseña</div>
        <div class="col-md-2">
            <div class="form-group">
                <input class="form-control" type="password" name="password" value="<?php echo $password ?>" > 
            </div>
        </div>
        
        <div class="col-md-12" align="center"><hr></div>


        <div class="col-md-12">
            <input type="hidden" name="User" value="<?php echo $User ?>">
            <input name="CambInformacion" class="btn btn-dark btn-block" type="submit" value="Cambiar Informacion"/> 
        </div>
        
        <div class="col-md-12" align="center"><hr></div>

    </div>     
</form>  