<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<title>
<?php echo $year;?> год
</title>
</head>
<body>
<ul>
<?php foreach ($persons as $person):?>
<li><?php echo $person?></li>
<?php endforeach;?>
</ul>
</body>
</html>
