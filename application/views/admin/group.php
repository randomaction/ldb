<?php $this->load->helper('url');?>
<?php $this->load->helper('form');?>
<h2><?php echo $group_data->year.', '.$group_data->group_name; ?></h2>
<ol>
<?php foreach ($persons as $person):?>
<li>
<?php echo anchor('admin/remove/'.$group_data->group_id.'/'.$person->person_id, '[x]'); ?>

<?php echo anchor('admin/person/'.$person->person_id.'/'.$group_data->group_id, $person->person_name); ?>
<ul><li>
<?php echo form_open('admin/update_photos');
echo form_hidden('person_id', $person->person_id);
echo form_hidden('group_id', $group_data->group_id);
echo form_hidden('year', $group_data->year); ?>
Фото:
<?php echo form_input(array('name' => 'photo', 'value' => $person->photo, 'size' => 20)); ?>

Маленькое:
<?php echo form_input(array('name' => 'photo_small', 'value' => $person->photo_small, 'size' => 20)); ?>

<?php echo form_submit('submit', 'Обновить');
echo form_close();?>
</li></ul>
</li>
<?php endforeach;?>
</ol>
