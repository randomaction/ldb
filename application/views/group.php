<?php $this->load->helper('url');?>
<h2><?php echo $group->year.', '.$group->name; ?></h2>
<div class="g">
<?php foreach ($persons as $person):?>
<div class="p1">
<a href="<?php echo site_url('lager/person/'.$person->person_id.'/'.$group->group_id); ?>">
<img src="<?php echo $images[$person->person_id]; ?>" alt="<?php echo $person->name; ?>" />
<div class="pn"><?php echo $person->name; ?></div>
</a>
</div>
<?php endforeach;?>
</div>
