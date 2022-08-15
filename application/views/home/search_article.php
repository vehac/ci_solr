<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<!DOCTYPE html>
<html lang="es">
    <head>
	<meta charset="utf-8">
	<title>Home</title>
        <link rel="shortcut icon" href="/favicon-32x32.png" type="image/x-icon">
        <style>
            .style_div_input {
                display: inline-block;
            }
            .style_padding {
                padding: 14px 0px 7px 0px;
            }
        </style>
    </head>
    <body>
        <div id="container">
            <h1>Buscar Artículo</h1>
            <a href="/">Home</a>
            <a href="/home/create">Crear Artículo</a>
            <form name="form_search_article" action="/home/search" method="GET">
                <div>
                    <div class="style_padding">
                        <label class="style_label">Buscar:</label>
                        <?php if($this->session->flashdata('success')) {?>
                            <div class="style_padding"><?php echo $this->session->flashdata('success'); ?></div>
                        <?php } ?>
                        <div class="style_div_input"><input type="text" id="query" name="query" value="" autocomplete="off"/></div>
                    </div>
                    <?php if($this->session->flashdata('error')) {?>
                        <div><?php echo $this->session->flashdata('error'); ?></div>
                    <?php } ?>
                    <button type="submit">Buscar</button>
                </div>
            </form>
            <div class="style_padding">
                Total de resultado: <?php echo $total; ?>
            </div>
            <table>
                <thead>
                    <tr>
                        <td>ID</td>
                        <td>Título</td>
                        <td>Descripción</td>
                        <td>Acciones</td>
                    </tr>
                </thead>
                <tbody>
                    <?php if(count($articulos) > 0) {
                        foreach ($articulos as $articulo) { ?>
                            <tr>
                                <td><?php echo $articulo['id']; ?></td>
                                <td><?php echo $articulo['title']; ?></td>
                                <td><?php echo $articulo['description']; ?></td>
                                <td>
                                    <a href="/home/edit/<?php echo $articulo['id']; ?>">Editar</a>
                                    <a href="/home/delete/<?php echo $articulo['id']; ?>">Eliminar</a>
                                </td>
                            </tr>
                    <?php }} ?>
                </tbody>
            </table>
        </div>
    </body>
</html>
