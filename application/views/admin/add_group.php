<?php
$this->load->helper('form');
echo form_open('admin/add_group');
?>
<h3>Добавить отряд</h3>
<p>Год:
<?php echo form_input(array('name' => 'year', 'size' => 4));?>
Название:
<?php echo form_input(array('name' => 'name', 'size' => 10));?>
<?php echo form_submit('submit', 'Добавить');?>
</p>
<?php echo form_close();?>
