<?php 
 
$ElAdmin[] = array(
    'Titulo' => 'Lideres',
    'NombrePagina' => 'MenuLideres', 
    'Icono' => 'fa fa-fw fa-sitemap',
);

foreach ($ElAdmin as $Leer) {
  
  echo "<li class='nav-item' data-toggle='tooltip' data-placement='right' title='".$Leer['Titulo']."''>
    <a style='color: white;'' class='nav-link' href='?contenido=".$Leer['NombrePagina']."'>
      <i class='".$Leer['Icono']."'></i>
      <span class='nav-link-text'>".$Leer['Titulo']."</span>
    </a>
  </li>";

} 




        // <li class="nav-item" data-toggle="tooltip" data-placement="right" title="Menu Levels">
        //   <a style="color: white;" class="nav-link nav-link-collapse collapsed" data-toggle="collapse" href="#collapseMulti" data-parent="#exampleAccordion">
        //     <i class="fa fa-fw fa-sitemap"></i>
        //     <span class="nav-link-text">Ordenes Trabajo / OT</span>
        //   </a>
        //   <ul class="sidenav-second-level collapse" id="collapseMulti">
        //     <li>
        //       <a style="color: white;" href="?contenido=ot">Registro OT</a>
        //     </li>
        // </ul>
        // </li>
                 
        // <li class="nav-item" data-toggle="tooltip" data-placement="right" title="Reporte">
        //     <a style="color: white;" class="nav-link" href="?contenido=reporte_actividad">
        //       <i class="fa fa-user-circle"></i>
        //       <span class="nav-link-text">Reporte </span>
        // </a>
        // </li>