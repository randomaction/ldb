<?php $this->load->helper('url');?>
<?php $this->load->helper('form');?>
<h2><?php echo $group_data->year.', '.$group_data->name; ?></h2>
<ol>
<?php foreach ($persons as $person):?>
<li>
<?php echo anchor('admin/remove/'.$group_data->group_id.'/'.$person->person_id, '[x]'); ?>

<?php echo anchor('admin/person/'.$person->person_id.'/'.$group_data->group_id, $person->name); ?>
<ul><li>
<?php echo form_open('admin/update_photos');
echo form_hidden('person_id', $person->person_id);
echo form_hidden('group_id', $group_data->group_id); ?>
Фото:
<?php echo form_input(array('name' => 'image', 'value' => $images[$person->person_id], 'size' => 20)); ?>

Маленькое:
<?php echo form_input(array('name' => 'image_small', 'value' => $images_small[$person->person_id], 'size' => 20)); ?>

<?php echo form_submit('submit', 'Обновить');
echo form_close();?>
</li></ul>
</li>
<?php endforeach;?>
</ol>
