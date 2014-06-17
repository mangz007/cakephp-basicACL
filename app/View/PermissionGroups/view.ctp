<div class="permissionGroups view">
<h2><?php echo __('Permission Group'); ?></h2>
	<dl>
		<dt><?php echo __('Id'); ?></dt>
		<dd>
			<?php echo h($permissionGroup['PermissionGroup']['id']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Name'); ?></dt>
		<dd>
			<?php echo h($permissionGroup['PermissionGroup']['name']); ?>
			&nbsp;
		</dd>
	</dl>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>
		<li><?php echo $this->Html->link(__('Edit Permission Group'), array('action' => 'edit', $permissionGroup['PermissionGroup']['id'])); ?> </li>
		<li><?php echo $this->Form->postLink(__('Delete Permission Group'), array('action' => 'delete', $permissionGroup['PermissionGroup']['id']), array(), __('Are you sure you want to delete # %s?', $permissionGroup['PermissionGroup']['id'])); ?> </li>
		<li><?php echo $this->Html->link(__('List Permission Groups'), array('action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Permission Group'), array('action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Permission Rules'), array('controller' => 'permission_rules', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Permission Rule'), array('controller' => 'permission_rules', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Permission Sets'), array('controller' => 'permission_sets', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Permission Set'), array('controller' => 'permission_sets', 'action' => 'add')); ?> </li>
	</ul>
</div>
<div class="related">
	<h3><?php echo __('Related Permission Rules'); ?></h3>
	<?php if (!empty($permissionGroup['PermissionRule'])): ?>
	<table cellpadding = "0" cellspacing = "0">
	<tr>
		<th><?php echo __('Id'); ?></th>
		<th><?php echo __('Role Id'); ?></th>
		<th><?php echo __('Permission Group Id'); ?></th>
		<th><?php echo __('Value'); ?></th>
		<th class="actions"><?php echo __('Actions'); ?></th>
	</tr>
	<?php foreach ($permissionGroup['PermissionRule'] as $permissionRule): ?>
		<tr>
			<td><?php echo $permissionRule['id']; ?></td>
			<td><?php echo $permissionRule['role_id']; ?></td>
			<td><?php echo $permissionRule['permission_group_id']; ?></td>
			<td><?php echo $permissionRule['value']; ?></td>
			<td class="actions">
				<?php echo $this->Html->link(__('View'), array('controller' => 'permission_rules', 'action' => 'view', $permissionRule['id'])); ?>
				<?php echo $this->Html->link(__('Edit'), array('controller' => 'permission_rules', 'action' => 'edit', $permissionRule['id'])); ?>
				<?php echo $this->Form->postLink(__('Delete'), array('controller' => 'permission_rules', 'action' => 'delete', $permissionRule['id']), array(), __('Are you sure you want to delete # %s?', $permissionRule['id'])); ?>
			</td>
		</tr>
	<?php endforeach; ?>
	</table>
<?php endif; ?>

	<div class="actions">
		<ul>
			<li><?php echo $this->Html->link(__('New Permission Rule'), array('controller' => 'permission_rules', 'action' => 'add')); ?> </li>
		</ul>
	</div>
</div>
<div class="related">
	<h3><?php echo __('Related Permission Sets'); ?></h3>
	<?php if (!empty($permissionGroup['PermissionSet'])): ?>
	<table cellpadding = "0" cellspacing = "0">
	<tr>
		<th><?php echo __('Id'); ?></th>
		<th><?php echo __('Permission Group Id'); ?></th>
		<th><?php echo __('Action'); ?></th>
		<th><?php echo __('Created'); ?></th>
		<th class="actions"><?php echo __('Actions'); ?></th>
	</tr>
	<?php foreach ($permissionGroup['PermissionSet'] as $permissionSet): ?>
		<tr>
			<td><?php echo $permissionSet['id']; ?></td>
			<td><?php echo $permissionSet['permission_group_id']; ?></td>
			<td><?php echo $permissionSet['action']; ?></td>
			<td><?php echo $permissionSet['created']; ?></td>
			<td class="actions">
				<?php echo $this->Html->link(__('View'), array('controller' => 'permission_sets', 'action' => 'view', $permissionSet['id'])); ?>
				<?php echo $this->Html->link(__('Edit'), array('controller' => 'permission_sets', 'action' => 'edit', $permissionSet['id'])); ?>
				<?php echo $this->Form->postLink(__('Delete'), array('controller' => 'permission_sets', 'action' => 'delete', $permissionSet['id']), array(), __('Are you sure you want to delete # %s?', $permissionSet['id'])); ?>
			</td>
		</tr>
	<?php endforeach; ?>
	</table>
<?php endif; ?>

	<div class="actions">
		<ul>
			<li><?php echo $this->Html->link(__('New Permission Set'), array('controller' => 'permission_sets', 'action' => 'add')); ?> </li>
		</ul>
	</div>
</div>
