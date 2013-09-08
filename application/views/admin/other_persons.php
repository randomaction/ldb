<?php
$this->load->helper('form');
echo form_open('admin/add_other_person');
echo form_hidden('group_id', $group_data->group_id);
?>
<h3>Добавить людей из другого выпуска</h3>
<p>
<?php foreach($others as $person) {
    $listitem['id'.$person->person_id] = $person->name. ' ('.$person->graduation.')';
}?>
<?php echo form_dropdown('other', $listitem); ?>
<?php echo form_submit('submit', 'Добавить');?>
</p>
<?php echo form_close();?>