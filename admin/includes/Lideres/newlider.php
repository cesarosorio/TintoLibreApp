<ol class="breadcrumb"> 
    <li class="breadcrumb-item">Menú de opciones.</li>
    <li class="breadcrumb-item active">Creacion de un nuevo usario.</li>
</ol>
  
<br>

<form autocomplete="off" action="?contenido=CrearUsuario" method="POST">
  <div class="row"> 
  
    <div class="col-md-6">
      <div class="form-group">
      	<label>Número de cedula</label>
        <input class="form-control" type="number" name="usuario" placeholder="Documento" required>
      </div>
    </div> 

    <div class="col-md-6">
      <div class="form-group">
        <label>Fecha de nacimiento</label>
        <input class="form-control" type="date" name="FechaNacimiento" required>
      </div>
    </div> 

    <div class="col-md-3">
      <div class="form-group">
      	<label>Primer Nombre</label>
        <input class="form-control" type="text" name="Name1" placeholder="Nombre 1" required>
      </div>
    </div>

    <div class="col-md-3">
      <div class="form-group">
        <label>Segundo Nombre</label>
        <input class="form-control" type="text" name="Name2" placeholder="Nombre 2" >
      </div>
    </div>

    <div class="col-md-3">
      <div class="form-group">
        <label>Primer Apellido</label>
        <input class="form-control" type="text" name="Name3" placeholder="Apellido 1" required>
      </div>
    </div>

    <div class="col-md-3">
      <div class="form-group">
        <label>Segundo Apellido</label>
        <input class="form-control" type="text" name="Name4" placeholder="Apellido 2">
      </div>
    </div>

     <div class="col-md-6">
      <div class="form-group">
        <label>Rol</label>
        <select list="rol" class="form-control" type="text" name="rol" required>  
            <?php $query = $conexion -> query ("SELECT Id_Rol, Nombre_Rol FROM rol WHERE Id_Rol NOT IN (1, 5)");
                while ($admon = mysqli_fetch_array($query)) { 
                  echo '<option value="'.$admon['Id_Rol'].'">'.$admon['Nombre_Rol'].'</option>'; 
            } ?> 
        </select>
      </div>
    </div>

    <div class="col-md-6">
      <div class="form-group">
        <label>Genero</label>
        <select list="Genero" class="form-control" type="text" name="Genero" required>  
            <?php $query = $conexion -> query ("SELECT Sigla, Nombre FROM Generos");
                while ($admon = mysqli_fetch_array($query)) { 
                  echo '<option value="'.$admon['Sigla'].'">'.$admon['Nombre'].'</option>'; 
            } ?> 
        </select>
      </div>
    </div>

    
    <div class="col-md-12">
      <input type="hidden" name="contenido" value="<?php echo $contenido; ?>">
      <input type="submit" name="CrearUsuario" class="btn btn-dark btn-block">
    </div>
  </div>
</form> 

<br>
<br>

<meta charset="utf-8">
<div class="container-fluid">
  <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0"> 
    <thead>
      <tr>
        <td>Cedula</td>
        <td>Nombre Completo</td>
        <td>Usuario</td> 
        <td>Rol</td> 
        <td>Estado</td> 
        <td>F. Nac.</td> 
        <td>Genero</td> 
        <td>Creador</td> 
        <!-- <td>Opciones</td>  -->
      </tr>
    </thead>
    <tbody>
      <?php $query = $conexion -> query ("SELECT u.Id_usuario as Cedula, u.Nickname as Usuario, u.Name as Nombre, R.Nombre_Rol, CASE WHEN u.Estado = 1 THEN 'Activo' ELSE 'Inactivo' END as Estado, u.FechaNacimiento, G.Nombre as Genero, U2.Name AS Crea FROM usuario u INNER JOIN rol R ON R.Id_Rol = u.Rol INNER JOIN generos G ON G.Sigla = u.Genero INNER JOIN usuario U2 ON U2.Id_usuario = u.LiderSemilla WHERE u.Rol NOT IN (1, 5)");
      while ($Lee = mysqli_fetch_array($query)) { 
        echo "<tr>
          <td>".$Lee['Cedula']."</td>
          <td>".$Lee['Nombre']."</td>
          <td>".$Lee['Usuario']."</td>
          <td>".$Lee['Nombre_Rol']."</td>
          <td>".$Lee['Estado']."</td>
          <td>".$Lee['FechaNacimiento']."</td>
          <td>".$Lee['Genero']."</td>
          <td>".$Lee['Crea']."</td> ";
          // <td><form action='../admin/index.php?contenido=' method='POST' name='copia' target='_self'>
          //         <input type='button' name='view' value='Editar' id='".$Lee['Cedula']."' class='btn btn-dark btn-block view_data'/>
          //   </form></td> 
        echo "</tr>";
      } ?>
    </tbody>
  </table>
</div>

<script>
 $(document).ready(function(){  
      $('#add').click(function(){  
           $('#insert').val("Insert");  
           $('#insert_form')[0].reset();  
      }); 
      $(document).on('click', '.view_data', function(){  
           var employee_id = $(this).attr("id");  
           if(employee_id != '')  
           {  
                $.ajax({  
                     url:"includes/EditarPersona.php",  
                     method:"POST",  
                     data:{employee_id:employee_id},  
                     success:function(data){  
                          $('#employee_detail').html(data);  
                          $('#dataModal').modal('show');  
                     }  
                });  
           }            
      });  
 });  
 </script>
 <div id="dataModal" class="modal fade bd-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">  
      <div class="modal-dialog modal-lg">  
           <div class="modal-content">  
                <div class="modal-header">
                  <h4 class="modal-title">Editar Persona</h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>      
                </div>  
                <div class="modal-body" id="employee_detail">  
                </div> 
                 
           </div>  
      </div>  
 </div>