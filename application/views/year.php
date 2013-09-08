<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<title>
<?php echo $year;?> год
</title>
</head>
<body>
<?php foreach ($groups as $group => $persons):?>
<h2><?php echo $group; ?></h2>
<ul>
<?php foreach ($persons as $person):?>
<li><?php echo $person->name; ?></li>
<?php endforeach;?>
</ul>
<?php endforeach;?>
</body>
</html>
