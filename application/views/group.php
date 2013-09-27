<?php
$this->load->helper('url');
$this->load->model('Lagermodel');
?>
<?php if (!$leads) : ?>
<h2><?php echo anchor('view/'.$group->year, $group->year).', '.$group->group_name; ?></h2>
<?php endif; ?>
<div class="centered">
<?php foreach ($persons as $person):?>
<div class="personsphoto">
<a href="<?php echo site_url('person/'.$person->person_id.'/'.$group->year); ?>">
<?php $url = $this->Lagermodel->replace_url($person->photo_small); ?>
<img class="photo" src="<?php echo $url; ?>" alt="<?php echo $person->person_name; ?>" />
</a>
<div>
<?php
$role = $person->role == null ? '' : '<br/>'.$person->role;
echo anchor('person/'.$person->person_id.'/'.$group->year, $person->person_name).$role;
?></div>
</div>
<?php endforeach;?>
</div>
