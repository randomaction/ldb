<?php $this->load->helper('url');?>
<h2><?php echo $year; ?></h2>
<?php foreach ($groups as $group => $persons):?>
<h3><?php echo $group; ?></h3>
<ul>
<?php foreach ($persons as $person):?>
<li><?php echo anchor("lager/person/".$person->person_id, $person->name); ?></li>
<?php endforeach;?>
</ul>
<?php endforeach;?>
