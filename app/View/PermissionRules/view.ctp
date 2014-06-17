<div class="permissionRules view">
<h2><?php echo __('Permission Rule'); ?></h2>
	<dl>
		<dt><?php echo __('Id'); ?></dt>
		<dd>
			<?php echo h($permissionRule['PermissionRule']['id']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Role'); ?></dt>
		<dd>
			<?php echo $this->Html->link($permissionRule['Role']['name'], array('controller' => 'roles', 'action' => 'view', $permissionRule['Role']['id'])); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Permission Group'); ?></dt>
		<dd>
			<?php echo $this->Html->link($permissionRule['PermissionGroup']['name'], array('controller' => 'permission_groups', 'action' => 'view', $permissionRule['PermissionGroup']['id'])); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Value'); ?></dt>
		<dd>
			<?php echo h($permissionRule['PermissionRule']['value']); ?>
			&nbsp;
		</dd>
	</dl>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>
		<li><?php echo $this->Html->link(__('Edit Permission Rule'), array('action' => 'edit', $permissionRule['PermissionRule']['id'])); ?> </li>
		<li><?php echo $this->Form->postLink(__('Delete Permission Rule'), array('action' => 'delete', $permissionRule['PermissionRule']['id']), array(), __('Are you sure you want to delete # %s?', $permissionRule['PermissionRule']['id'])); ?> </li>
		<li><?php echo $this->Html->link(__('List Permission Rules'), array('action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Permission Rule'), array('action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Roles'), array('controller' => 'roles', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Role'), array('controller' => 'roles', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Permission Groups'), array('controller' => 'permission_groups', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Permission Group'), array('controller' => 'permission_groups', 'action' => 'add')); ?> </li>
	</ul>
</div>
