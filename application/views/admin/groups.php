<ul>
<?php $this->load->helper('url');?>
<?php foreach ($groups as $group) :?>
<li>
<?php echo anchor('admin/remove_group_confirm/'.$group->group_id, '[x]'); ?>

<?php echo anchor("admin/group/".$group->group_id, $group->year.', '.$group->name); echo "\n"; ?>
</li>
<?php endforeach; ?>
</ul>
