<?php
$this->load->helper('url');
$username = $this->session->userdata('username');
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link rel="stylesheet" href="<?php echo base_url('media/main.css'); ?>" type="text/css" />
<title>Летняя физическая школа</title>
</head>
<body>
<?php if ( $username != null) : ?>
<p>[<?php echo $username; ?>]

<?php echo anchor('admin', 'Администрирование'); ?>

<?php echo anchor('login/logout', 'Выйти'); ?>
</p>
<?php endif; ?>
