<h2>
<?php if ($person_data != null) echo $person_data->name; ?>
</h2>
<ul>
<?php $this->load->helper('url');?>
<?php foreach ($groups as $group):?>
<li><?php $y = $group->year; $g = $group->name; echo anchor("lager/year/$y", "$y, $g"); ?></li>
<?php endforeach;?>
</ul>
