<?php
$this->load->helper('url');
$this->load->model('Lagermodel');
?>
<h2><?php echo anchor('lager/year/'.$group->year, $group->year).', '.$group->group_name; ?></h2>
<div class="centered">
<?php foreach ($persons as $person):?>
<div class="personsphoto">
<a href="<?php echo site_url('lager/person/'.$person->person_id.'/'.$group->group_id); ?>">
<img class="photo" src="<?php echo $this->Lagermodel->replace_url($person->photo_small); ?>" alt="<?php echo $person->person_name; ?>" />
</a>
<div><?php echo anchor('lager/person/'.$person->person_id.'/'.$group->group_id, $person->person_name); ?></div>
</div>
<?php endforeach;?>
</div>
