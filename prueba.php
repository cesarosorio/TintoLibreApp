<?php
$cabeceras = 'From: admin@tusemilla.com.co';

$asunto = utf8_decode("¡Se ha creado tu cuenta en tusemilla!");
$Correo = 'danit@tintolibre.org';
$mensaje="¡Felicitaciones! Queremos confirmarte que te has inscrito en la plataforma Tusemilla con éxito. TintoLibre te agradece por atreverte a cumplir tus sueños.
 
Ahora es el momento de inscribirte a tu semilla. Para esto tienes dos opciones: 
Puedes ingresar a tu semilla tu mismo, siguiendo estas instrucciones (texto de estas instrucciones con el link al video), o 
Cuando las demás personas ahorradoras de tu semilla se inscriban, el líder de tu semilla nombre del líder, te registrará. 

No dudes en contactarte con tu líder de semilla si tienes alguna duda.

¡Te felicitamos por tener la valentía de ahorrar por tus sueños!

Att: TintoLibre";


mail($Correo, $asunto, $mensaje, $cabeceras);