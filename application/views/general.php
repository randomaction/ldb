<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<title>Летняя физическая школа</title>
</head>
<body>
<ul>
<?php $this->load->helper('url');?>
<?php foreach ($years as $year):?>
<li><?php $y = $year->year; echo anchor("lager/year/$y", $y); ?></li>
<?php endforeach;?>
</ul>
</body>
</html>
