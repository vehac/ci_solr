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
            .style_label {
                display: inline-block;
                width: 119px;
            }
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
            <h1>Editar Artículo</h1>
            <a href="/">Home</a>
            <a href="/home/create">Crear Artículo</a>
            <a href="/home/search">Buscar Artículo</a>
            <form name="form_edit_article" action="/home/update_article" method="POST">
                <div>
                    <?php if($this->session->flashdata('success')) {?>
                        <div class="style_padding"><?php echo $this->session->flashdata('success'); ?></div>
                    <?php } ?>
                    <div class="style_padding">
                        <label class="style_label">Título:</label>
                        <div class="style_div_input"><input type="text" id="title" name="title" value="<?php echo $title; ?>" autocomplete="off"/></div>
                    </div>
                    <div class="style_padding">
                        <label class="style_label">Descripción:</label>
                        <div class="style_div_input"><textarea id="description" name="description" rows="14" cols="49"><?php echo $description; ?></textarea></div>
                    </div>
                    <?php if($this->session->flashdata('error')) {?>
                        <div><?php echo $this->session->flashdata('error'); ?></div>
                    <?php } ?>
                        <input type="hidden" id="id" name="id" value="<?php echo $id; ?>"/>
                    <button type="submit">Editar Artículo</button>
                </div>
            </form>
        </div>
    </body>
</html>
