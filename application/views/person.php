<?php
$this->load->helper('url');
$this->load->model('Lagermodel');
$url = $this->Lagermodel->replace_url($current_group == null ? null : $current_group->photo);
?>
<h2>
<?php if ($person_data != null) echo $person_data->person_name; ?>
</h2>
<div class="centered">
<ul class="applist">
<?php foreach ($groups as $group):?>
<li>
<?php echo $current_group != null && $group->year == $current_group->year ?
    $group->year : anchor('lager/person/'.$person_data->person_id.'/'.$group->year, $group->year); ?>:
<?php echo anchor('lager/view/'.$group->year.'/'.$group->group_name, $group->group_name); ?>
</li>
<?php endforeach;?>
</ul>
<?php if ($current_group != null) : ?>
<div class="photosection">
<img class="photo" src="<?php echo $url; ?>" alt="<?php echo $person_data->person_name; ?>" />
<div>
<?php echo $current_group->year; ?>
</div>
</div>
<?php endif; ?>
</div>
