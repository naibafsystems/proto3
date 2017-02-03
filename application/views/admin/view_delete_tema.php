<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>

<h1>Eliminar Tema</h1>

Estas seguro de eliminar el tema: <strong><?php echo $datos_tema[0]->tema; ?></strong><br />

<?php $input_con_id = array(
        'con_id'   => $datos_tema[0]->id_tema
        );
?>

<?php echo form_open(); ?>
<?php echo form_hidden($input_con_id); ?>
<?php echo form_submit('btn_enviar','Si Deseo Eliminarlo') ?>

<?php echo form_close(); ?><br />
