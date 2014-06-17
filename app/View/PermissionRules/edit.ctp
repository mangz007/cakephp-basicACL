<div class="permissionRules form">
<?php echo $this->Form->create('PermissionRule'); ?>
	<fieldset>
		<legend><?php echo __('Edit Permission Rule'); ?></legend>
	<?php
		echo $this->Form->input('id');
		echo $this->Form->input('role_id');
		echo $this->Form->input('permission_group_id');
		echo $this->Form->input('value');
	?>
	</fieldset>
<?php echo $this->Form->end(__('Submit')); ?>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>

		<li><?php echo $this->Form->postLink(__('Delete'), array('action' => 'delete', $this->Form->value('PermissionRule.id')), array(), __('Are you sure you want to delete # %s?', $this->Form->value('PermissionRule.id'))); ?></li>
		<li><?php echo $this->Html->link(__('List Permission Rules'), array('action' => 'index')); ?></li>
		<li><?php echo $this->Html->link(__('List Roles'), array('controller' => 'roles', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Role'), array('controller' => 'roles', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Permission Groups'), array('controller' => 'permission_groups', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Permission Group'), array('controller' => 'permission_groups', 'action' => 'add')); ?> </li>
	</ul>
</div>
