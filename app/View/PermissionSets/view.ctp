<div class="permissionSets view">
<h2><?php echo __('Permission Set'); ?></h2>
	<dl>
		<dt><?php echo __('Id'); ?></dt>
		<dd>
			<?php echo h($permissionSet['PermissionSet']['id']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Permission Group'); ?></dt>
		<dd>
			<?php echo $this->Html->link($permissionSet['PermissionGroup']['name'], array('controller' => 'permission_groups', 'action' => 'view', $permissionSet['PermissionGroup']['id'])); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Action'); ?></dt>
		<dd>
			<?php echo h($permissionSet['PermissionSet']['action']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Created'); ?></dt>
		<dd>
			<?php echo h($permissionSet['PermissionSet']['created']); ?>
			&nbsp;
		</dd>
	</dl>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>
		<li><?php echo $this->Html->link(__('Edit Permission Set'), array('action' => 'edit', $permissionSet['PermissionSet']['id'])); ?> </li>
		<li><?php echo $this->Form->postLink(__('Delete Permission Set'), array('action' => 'delete', $permissionSet['PermissionSet']['id']), array(), __('Are you sure you want to delete # %s?', $permissionSet['PermissionSet']['id'])); ?> </li>
		<li><?php echo $this->Html->link(__('List Permission Sets'), array('action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Permission Set'), array('action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Permission Groups'), array('controller' => 'permission_groups', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Permission Group'), array('controller' => 'permission_groups', 'action' => 'add')); ?> </li>
	</ul>
</div>
