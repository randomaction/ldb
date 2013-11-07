<ul class="columns">
<?php foreach ($persons as $person):?>
<li><?php echo anchor('person/'.$person->person_id, $person->person_name); ?></li>
<?php endforeach;?>
</ul>
