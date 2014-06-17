<div class="permissionSets form">
<?php echo $this->Form->create('PermissionSet'); ?>
	<fieldset>
		<legend><?php echo __('Add Permission Set'); ?></legend>
	<?php
		echo $this->Form->input('permission_group_id');
		echo $this->Form->input('action');
	?>
	</fieldset>
<?php echo $this->Form->end(__('Submit')); ?>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>

		<li><?php echo $this->Html->link(__('List Permission Sets'), array('action' => 'index')); ?></li>
		<li><?php echo $this->Html->link(__('List Permission Groups'), array('controller' => 'permission_groups', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Permission Group'), array('controller' => 'permission_groups', 'action' => 'add')); ?> </li>
	</ul>
</div>
