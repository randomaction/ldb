<?php $this->load->helper('url');?>
<h2><?php echo $year; ?></h2>
<?php foreach ($group_data as $group):?>
<div class="y">
<h3><?php echo anchor("lager/group/".$group->group_id, $group->name); ?></h3>
<ul>
<?php foreach ($groups[$group->name] as $person):?>
<li><?php echo anchor("lager/person/".$person->person_id.'/'.$group->group_id, $person->name); ?></li>
<?php endforeach;?>
</ul>
</div>
<?php endforeach;?>
