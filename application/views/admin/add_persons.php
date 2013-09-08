<?php
$this->load->helper('form');
echo form_open('admin/add_persons'); ?>
<div>
<?php echo form_hidden('group_id', $group_data->group_id); ?>
<h3>Добавить людей, отсутствующих в базе</h3>
<p>Один человек на строчку. Фамилия-пробел-имя.</p>
<p>
<?php echo form_textarea(array('name' => 'persons', 'rows' => 30, 'cols' => 60));?>
</p>
<p>
<?php echo form_submit('submit', 'Добавить');?>
</p>
</div>
<?php echo form_close();?>
