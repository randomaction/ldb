<?php
$this->load->helper('form');
echo form_open('admin/add_existing_persons');?>
<div>
<?echo form_hidden('group_id', $group_data->group_id); ?>
<h3>Добавить людей из этого выпуска</h3>
<p>
<?php foreach($suggestions as $person): ?>
<?php echo form_checkbox(array('name' => 'id'.$person->person_id, 'value' => 'add')); ?>
<?php echo $person->name; ?>
<br/>
<?php endforeach; ?>
</p>
<p>
<?php echo form_submit('submit', 'Добавить');?>
</p>
</div>
<?php echo form_close();?>
