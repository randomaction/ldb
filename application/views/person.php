<?php $this->load->helper('url');?>
<h2>
<?php if ($person_data != null) echo $person_data->name; ?>
</h2>
<div class="p">
<img src="<?php echo $image; ?>" alt="<?php echo $person_data->name; ?>" />
<div class="pn"><?php echo $person_data->name; ?>
<br/>
<?php echo $current_group->year.', '.$current_group->name; ?>
</div>
</div>
<ul>
<?php $this->load->helper('url');?>
<?php foreach ($groups as $group):?>
<li><?php echo anchor('lager/person/'.$person_data->person_id.'/'.$group->group_id, $group->year.', '.$group->name); ?></li>
<?php endforeach;?>
</ul>
