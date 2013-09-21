<?php
$this->load->helper('form');
echo form_open($action);
?>
<p>Имя:
<?php echo form_input(array('name' => 'username', 'size' => 10));?>

Пароль:
<?php echo form_password(array('name' => 'password', 'size' => 10));?>
<?php echo form_submit('submit', $label);?>
</p>
<?php echo form_close();?>
