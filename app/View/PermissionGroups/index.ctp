<div class="permissionGroups index">
	<h2><?php echo __('Permission Groups'); ?></h2>
	<table cellpadding="0" cellspacing="0">
	<thead>
	<tr>
			<th><?php echo $this->Paginator->sort('id'); ?></th>
			<th><?php echo $this->Paginator->sort('name'); ?></th>
			<th class="actions"><?php echo __('Actions'); ?></th>
	</tr>
	</thead>
	<tbody>
	<?php foreach ($permissionGroups as $permissionGroup): ?>
	<tr>
		<td><?php echo h($permissionGroup['PermissionGroup']['id']); ?>&nbsp;</td>
		<td><?php echo h($permissionGroup['PermissionGroup']['name']); ?>&nbsp;</td>
		<td class="actions">
			<?php echo $this->Html->link(__('View'), array('action' => 'view', $permissionGroup['PermissionGroup']['id'])); ?>
			<?php echo $this->Html->link(__('Edit'), array('action' => 'edit', $permissionGroup['PermissionGroup']['id'])); ?>
			<?php echo $this->Form->postLink(__('Delete'), array('action' => 'delete', $permissionGroup['PermissionGroup']['id']), array(), __('Are you sure you want to delete # %s?', $permissionGroup['PermissionGroup']['id'])); ?>
		</td>
	</tr>
<?php endforeach; ?>
	</tbody>
	</table>
	<p>
	<?php
	echo $this->Paginator->counter(array(
	'format' => __('Page {:page} of {:pages}, showing {:current} records out of {:count} total, starting on record {:start}, ending on {:end}')
	));
	?>	</p>
	<div class="paging">
	<?php
		echo $this->Paginator->prev('< ' . __('previous'), array(), null, array('class' => 'prev disabled'));
		echo $this->Paginator->numbers(array('separator' => ''));
		echo $this->Paginator->next(__('next') . ' >', array(), null, array('class' => 'next disabled'));
	?>
	</div>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>
		<li><?php echo $this->Html->link(__('New Permission Group'), array('action' => 'add')); ?></li>
		<li><?php echo $this->Html->link(__('List Permission Rules'), array('controller' => 'permission_rules', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Permission Rule'), array('controller' => 'permission_rules', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Permission Sets'), array('controller' => 'permission_sets', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Permission Set'), array('controller' => 'permission_sets', 'action' => 'add')); ?> </li>
	</ul>
</div>
