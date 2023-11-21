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

    function showContent1() {
        element1 = document.getElementById("content1");
        check1 = document.getElementById("check1");
        if (check1.checked) {
            element1.style.display='block';
        }
        else {
            element1.style.display='none';
        }
    }

    function showContent2() {
        element2 = document.getElementById("content2");
        check2 = document.getElementById("check2");
        if (check2.checked) {
            element2.style.display='block';
        }
        else {
            element2.style.display='none';
        }
    }

</script>

<ol class="breadcrumb"> 
    <li class="breadcrumb-item">Menú de opciones.</li>
    <li class="breadcrumb-item active">Creacion de una nueva semilla.</li>
</ol>

<form enctype="multipart/form-data" autocomplete="off" action="includes/Semillas/CrearSemilla.php" method="POST">
  <div class="row"> 
  
    <div class="col-md-8">
      <div class="form-group">
        <label>Nombre de la semilla</label>
        <input class="form-control" type="text" name="NomSemilla" required>
      </div>
    </div>  

    <div class="col-md-4">
      <div class="form-group">
        <label>Cierre de semilla</label>
        <input class="form-control" type="date" name="FechaCierre" required>
      </div>
    </div> 

    <div class="col-md-2">
      <div class="form-group">
        <label>Quincenal</label>
          <input type="checkbox" name="check1" id="check1" value="2" onchange="javascript:showContent1()" /> 
      </div>
    </div> 

    <div id="content1" style="display: none;">
      <div class="row">  
        <div class="col-md-2">
          <div class="form-group">
            <label>Q1</label>
          </div>
        </div> 

        <div class="col-md-4">
          <div class="form-group">
             <select name="quimaximo" class="form-control" type="number"> 
                <option value=""></option>
                <option value="1">1</option>
                <option value="2">2</option>
                <option value="3">3</option>
                <option value="4">4</option>
                <option value="5">5</option>
                <option value="6">6</option>
                <option value="7">7</option>
                <option value="8">8</option>
                <option value="9">9</option>
                <option value="10">10</option>
                <option value="11">11</option>
                <option value="12">12</option>
                <option value="13">13</option>
                <option value="14">14</option>
                <option value="15">15</option>
              </select>
          </div>
        </div> 

        <div class="col-md-2">
          <div class="form-group">
            <label>Q2</label>
          </div>
        </div> 

        <div class="col-md-4">
          <div class="form-group">
             <select name="quimaxidos" class="form-control" type="number"> 
                <option value=""></option>
                <option value="16">16</option>
                <option value="17">17</option>
                <option value="18">18</option>
                <option value="19">19</option>
                <option value="20">20</option>
                <option value="21">21</option>
                <option value="22">22</option>
                <option value="23">23</option>
                <option value="24">24</option>
                <option value="25">25</option>
                <option value="26">26</option>
                <option value="27">27</option>
                <option value="28">28</option>
                <option value="29">29</option>
                <option value="30">30</option>
              </select>
          </div>
        </div> 

      </div>
    </div> 

    <div class="col-md-3">
      <div class="form-group">
        <label>Mensual</label>
          <input type="checkbox" name="check2" id="check2" value="1" onchange="javascript:showContent2()" /> 
      </div>
    </div>  

    <div id="content2" style="display: none;">
      <div class="row">  
        
        <div class="col-md-2">
          <div class="form-group">
            <label>M1</label>
          </div>
        </div> 

        <div class="col-md-8">
          <div class="form-group">
              <select name="mesmaximo" class="form-control" type="number"> 
                <option value=""></option>
                <option value="1">1</option>
                <option value="2">2</option>
                <option value="3">3</option>
                <option value="4">4</option>
                <option value="5">5</option>
                <option value="6">6</option>
                <option value="7">7</option>
                <option value="8">8</option>
                <option value="9">9</option>
                <option value="10">10</option>
                <option value="11">11</option>
                <option value="12">12</option>
                <option value="13">13</option>
                <option value="14">14</option>
                <option value="15">15</option>
                <option value="16">16</option>
                <option value="17">17</option>
                <option value="18">18</option>
                <option value="19">19</option>
                <option value="20">20</option>
                <option value="21">21</option>
                <option value="22">22</option>
                <option value="23">23</option>
                <option value="24">24</option>
                <option value="25">25</option>
                <option value="26">26</option>
                <option value="27">27</option>
                <option value="28">28</option>
                <option value="29">29</option>
                <option value="30">30</option>
              </select>
          </div>
        </div> 
      
      </div>
    </div>

    <div class="col-md-12"><br></div>

    <div class="col-md-6">
      <div class="form-group">
        <label>Mínimo de consignación</label>
          <input class="form-control" type="number" name="minimo" required>
      </div>
    </div>

    <div class="col-md-6">
      <div class="form-group">
        <label>Máximo de consignación</label>
          <input class="form-control" type="number" name="maximo" required>
      </div>
    </div>

    <div class="col-md-12"><br></div>

    <div class="col-md-4">
      <div class="form-group">
        <label>Líder de la semilla</label>
        <select list="rol" class="form-control" type="text" name="LiderSemilla" required>  
            <?php $query = $conexion -> query ("SELECT Id_usuario, Name FROM usuario WHERE Rol = 2 AND Id_usuario != $User");
                echo "<option value='".$User."'>".$Nombre."</option>"; 
                while ($admon = mysqli_fetch_array($query)) { 
                  echo '<option value="'.$admon['Id_usuario'].'">'.$admon['Name'].'</option>'; 
            } ?> 
        </select>
      </div>
    </div>

    <div class="col-md-4">
      <div class="form-group">
        <label>Monto máximo para préstamos</label>
          <input class="form-control" type="number" name="MontoPrestamo" step="0.002" required>
      </div>
    </div>

    <div class="col-md-4">
      <div class="form-group">
        <label>Multa por pago tarde</label>
          <input class="form-control" type="number" name="MultaPagoTarde" >
      </div>
    </div>    

    <div class="col-md-6">
      <div class="form-group">
        <label>¿Aporte social?</label>
        <input type="checkbox" name="check" id="check" value="1" onchange="javascript:showContent()" /> 
          <div id="content" style="display: none;">
            <label>Por favor, indicar el valor del monto.</label>
            <input class="form-control" type="number" step="0.002" name="aportesocial">
          </div>
      </div>
    </div> 

    <div class="col-md-6">
      <div class="form-group">
        <label>Acta de conformación de semilla (.PDF, .JPG, .PNG)</label>
        <input accept="application/pdf, image/jpg, image/png" class="form-control" type="file" name="Acta" required>
      </div>
    </div>
 
    <div class="col-md-12">
      <input type="hidden" name="Presidente" value="<?php echo $User; ?>">
      <input type="submit" name="Crear" class="btn btn-dark btn-block">
    </div>
  </div>
</form> 

