<?php
$this->load->helper('form');
echo form_open('admin/remove_group');
?>
<h3>Удаление отряда</h3>
<p>
<?php echo form_hidden('group_id', $group_data->group_id); ?>
<?php echo form_submit('submit', 'Удалить отряд: '.$group_data->year.', '.$group_data->group_name) ;?>
</p>
<?php echo form_close();?>
