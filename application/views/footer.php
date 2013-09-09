<?php $this->load->helper('url'); ?>
<p>
<?php if (isset($admin) && $admin == true): ?>
<?php echo anchor('admin', 'Администрирование'); ?>
<br/>
<?php endif; ?>
<?php echo anchor('lager', 'На главную'); ?>
</p>
</body>
</html>
