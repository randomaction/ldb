<?php $this->load->helper('url');?>
<?php foreach ($groups as $group => $persons):?>
<h2><?php echo $group; ?></h2>
<ul>
<?php foreach ($persons as $person):?>
<li><?php echo anchor("lager/person/".$person->person_id, $person->name); ?></li>
<?php endforeach;?>
</ul>
<?php endforeach;?>
