<?php $this->load->helper('url');?>
<h2><?php echo $group_data->year.', '.$group_data->name; ?></h2>
<ul>
<?php foreach ($persons as $person):?>
<li><?php echo anchor("lager/person/".$person->person_id, $person->name); ?></li>
<?php endforeach;?>
</ul>
