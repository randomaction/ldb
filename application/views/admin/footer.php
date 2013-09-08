<?php $this->load->helper('url');
if (!isset($link) || $link != false) echo anchor('admin', 'Администрирование');
echo anchor('lager', 'На главную'); ?>
</body>
</html>
