<?php  

$ElAdmin[] = array(
    'Titulo' => 'Reportes',
    'NombrePagina' => 'menu_reportes', 
    'Icono' => '<i class="fa fa-file-excel-o" aria-hidden="true"></i>',
    
);

$ElAdmin[] = array(
    'Titulo' => 'Información Personal',
    'NombrePagina' => 'info_perso', 
    'Icono' => "<img src='Documentos/Imagenes/información-personal.ico' style='width: 17px; heigth: 17px'>",
);

$ElAdmin[] = array(
  'Titulo' => 'Administración',
  'NombrePagina' => 'edit_perso', 
  'Icono' => "<img src='Documentos/Imagenes/información-personal.ico' style='width: 17px; heigth: 17px'>",
);


$ElAdmin[] = array(
  'Titulo' => 'Carga masiva',
  'NombrePagina' => 'carga_incentivos', 
  'Icono' => '<i class="fa fa-file-excel-o" aria-hidden="true"></i>',
);
 

foreach ($ElAdmin as $Leer) {
  
  echo "<li class='nav-item' data-toggle='tooltip' data-placement='right' title='".$Leer['Titulo']."''>
    <a style='color: white;'' class='nav-link' href='?contenido=".$Leer['NombrePagina']."'>
      ".$Leer['Icono']."
      <span class='nav-link-text'>".$Leer['Titulo']."</span></a>
    </li>";

}

?>

<li class="nav-item" data-toggle="tooltip" data-placement="right" title="Menu Levels">
  
  <!-- <a style="color: white;" class="nav-link nav-link-collapse collapsed" data-toggle="collapse" href="#Manuales" data-parent="#exampleAccordion">
    <i class="fa fa-fw fa-sitemap"></i><span class="nav-link-text">Manuales de Interes</span>
  </a> -->
  
  <ul class="sidenav-second-level collapse" id="Manuales">
    <li><a style="color: white;" href="https://drive.google.com/file/d/1XbUHhHWE4_TadWfn5dCjWbZLcVbrzJoH/view?usp=sharing" target="_blanck">Manual SARLAF</a></li>
    <li><a style="color: white;" href="https://drive.google.com/file/d/1KH5vQbpuG7Ca7HwsWB-CLg32RUEiuNV6/view?usp=sharing" target="_blanck">Código de Ética</a></li>
    <li><a style="color: white;" href="https://www.mipagoamigo.com/MPA_WebSite/ServicePayments/StartPayment?id=8851&searchedCategoryId=&searchedAgreementName=TINTOLIBRE" target="_blanck">Mi Banco Amigo</a></li>
    <li><a style="color: white;" href="https://drive.google.com/file/d/1_xrbJ93_bA3nC31iM4sMC6SN4JU7aibR/view?usp=share_link" target="_blanck">Manual de ahorro</a></li>
    <li><a style="color: white;" href="https://drive.google.com/file/d/1vqiktodU2lT1vhhpj6t0qlkEkmqtqpwb/view?usp=share_link" target="_blanck">Reglamento de exclusión de la asociación</a></li>   
    
  </ul>
</li>
   