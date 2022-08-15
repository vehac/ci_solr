<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<!DOCTYPE html>
<html lang="es">
    <head>
	<meta charset="utf-8">
	<title>Home</title>
        <link rel="shortcut icon" href="favicon-32x32.png" type="image/x-icon">
    </head>
    <body>
        <div id="container">
            <h1>Sorl</h1>
            <p>Solr versión: 8.11.2</p>
            <p>Solarium versión: <?php echo $version; ?></p>
            <p>Ping: <?php echo isset($data['status']) ? $data['status'] : 'FAIL'; ?></p>
            <a href="/home/create">Crear Artículo</a>
            <a href="/home/search">Buscar Artículo</a>
        </div>
    </body>
</html>
