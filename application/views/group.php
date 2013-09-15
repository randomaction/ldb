<?php $this->load->helper('url');?>
<h2><?php echo $group->year.', '.$group->name; ?></h2>
<div class="centered">
<?php foreach ($persons as $person):?>
<div class="personsphoto">
<a href="<?php echo site_url('lager/person/'.$person->person_id.'/'.$group->group_id); ?>">
<img class="photo" src="<?php echo $images[$person->person_id]; ?>" alt="<?php echo $person->name; ?>" />
</a>
<div><?php echo anchor('lager/person/'.$person->person_id.'/'.$group->group_id, $person->name); ?></div>
</div>
<?php endforeach;?>
</div>
