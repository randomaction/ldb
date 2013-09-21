<?php
$this->load->helper('form');
echo form_open('admin/update_person');
?>
<p>Фамилия, имя:
<?php echo form_hidden('person_id', $person_data->person_id); ?>
<?php echo form_hidden('group_id', $group_id); ?>
<?php echo form_input(array('name' => 'person_name', 'value' => $person_data->person_name, 'size' => 20)); ?>

Выпуск:
<?php echo form_input(array('name' => 'graduation', 'value' => $person_data->graduation, 'size' => 4)); ?>

<?php echo form_submit('submit', 'Обновить');?>
</p>
<?php echo form_close();?>
