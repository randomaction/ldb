<ul>
<?php $this->load->helper('url');?>
<?php foreach ($years as $year):?>
<li><?php $y = $year->year; echo anchor("lager/year/$y", $y); ?></li>
<?php endforeach;?>
</ul>
