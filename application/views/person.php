<?php $this->load->helper('url');?>
<h2>
<?php if ($person_data != null) echo $person_data->name; ?>
</h2>
<div class="centered">
<ul class="applist">
<?php foreach ($groups as $group):?>
<li>
<?php echo $current_group != null && $group->group_id == $current_group->group_id ?
    $group->year : anchor('lager/person/'.$person_data->person_id.'/'.$group->group_id, $group->year); ?>:
<?php echo anchor('lager/group/'.$group->group_id, $group->name); ?>
</li>
<?php endforeach;?>
</ul>
<?php if ($current_group != null) : ?>
<div class="photosection">
<img class="photo" src="<?php echo $image; ?>" alt="<?php echo $person_data->name; ?>" />
<div>
<?php echo $current_group->year.', '.$current_group->name; ?>
</div>
</div>
<?php endif; ?>
</div>
