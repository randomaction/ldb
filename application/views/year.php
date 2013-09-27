<?php $this->load->helper('url');?>
<h2><?php echo $year; ?></h2>
<div class="centered">
<?php foreach ($group_data as $group):?>
<div class="grouplist">
<h3><?php echo anchor("view/".$group->year.'/'.$group->group_name, $group->group_name); ?></h3>
<ul>
<?php foreach ($groups['persons'][$group->group_name] as $person) : ?>
<li><?php echo anchor("person/".$person->person_id.'/'.$group->year, $person->person_name); ?></li>
<?php endforeach;?>
</ul>
<?php if (count($groups['leads'][$group->group_name]) > 0) : ?>
<hr/>
<ul>
<?php foreach ($groups['leads'][$group->group_name] as $person) : ?>
<li><?php echo anchor("person/".$person->person_id.'/'.$group->year, $person->person_name); ?></li>
<?php endforeach;?>
</ul>
<?php endif; ?>
</div>
<?php endforeach;?>
</div>
