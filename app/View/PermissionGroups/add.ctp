<div class="permissionGroups form">
<?php echo $this->Form->create('PermissionGroup'); ?>
	<fieldset>
		<legend><?php echo __('Add Permission Group'); ?></legend>
	<?php
		echo $this->Form->input('name');
	?>
	</fieldset>
<?php echo $this->Form->end(__('Submit')); ?>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>

		<li><?php echo $this->Html->link(__('List Permission Groups'), array('action' => 'index')); ?></li>
		<li><?php echo $this->Html->link(__('List Permission Rules'), array('controller' => 'permission_rules', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Permission Rule'), array('controller' => 'permission_rules', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Permission Sets'), array('controller' => 'permission_sets', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Permission Set'), array('controller' => 'permission_sets', 'action' => 'add')); ?> </li>
	</ul>
</div>
