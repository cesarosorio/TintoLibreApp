<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link href="ccs/bootstrap.min.css" rel="stylesheet">
	<script src="js/jquery-2.2.0.min.js"></script>
	<script src="js/bootstrap.min.js"></script>
	<title>Inicio</title>
	<link rel="stylesheet" href="css/styles.css">
</head>
<header><h1>LOGOTIPO</h1></header>
<body>
		<?php
		include "modules/navegacion.php";
		?>			
		<section>
			<?php
			$mvc = new CrrController();
			$mvc -> enlacesPaginasController();
			?>
		</section>
</body>
</html>