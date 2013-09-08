<?php $this->load->helper('url'); ?>
<p>
<?php if (!isset($link) || $link != false) echo anchor('admin', 'Администрирование');?>
<br/>
<?php echo anchor('lager', 'На главную'); ?>
</p>
</body>
</html>
