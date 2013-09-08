<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<title>
<?php echo $name; ?>
</title>
</head>
<body>
<h2>
<?php echo $name; ?>
</h2>
<ul>
<?php $this->load->helper('url');?>
<?php foreach ($groups as $group):?>
<li><?php $y = $group->year; $g = $group->name; echo anchor("lager/year/$y", "$y, $g"); ?></li>
<?php endforeach;?>
</ul>
</body>
</html>
