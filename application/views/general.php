<p>
<?php $this->load->helper('url');?>
<?php foreach ($years as $year):?>
<?php $y = $year->year; echo anchor("lager/view/$y", $y); ?>

<?php endforeach;?>
</p>
