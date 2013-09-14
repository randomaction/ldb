<?php $this->load->helper('url');?>
<h2><?php echo $group->year.', '.$group->name; ?></h2>
<div class="g">
<?php foreach ($persons as $person):?>
<div class="p1">
<img src="<?php echo base_url('media/son_of_an_atom.jpg') ?>" alt="<?php echo $person->name; ?>" />
<div class="pn"><?php echo anchor("lager/person/".$person->person_id.'/'.$group->group_id, $person->name); ?></div>
</div>
<?php endforeach;?>
</div>
