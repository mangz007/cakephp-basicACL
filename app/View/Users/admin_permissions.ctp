<h2>Permissions</h2>
<?php
// pr($groups);
echo $this->Form->create('Roles');
echo '<table class="table">';
echo '<th>Permission <i class="icon-arrow-down"></i> / Roles <i class="icon-arrow-right"></i></th>';
foreach ($roles as $v){
    echo "<th>{$v['Role']['name']}</th>";
}
echo '</tr>';
foreach($groups as $v){
    echo '<tr>';
    echo "<td>".$this->Html->link($v['PermissionGroup']['name'], array('controller' => 'users', 'action' => 'admin_view_perms_group', $v['PermissionGroup']['id']), array('data-toggle' => "modal", 'data-target' => "#myModal{$v['PermissionGroup']['id']}")).
	'<div id="myModal'.$v['PermissionGroup']['id'].'" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel'.$v['PermissionGroup']['id'].'" aria-hidden="true">
    <div class="modal-header">
	<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
	<h3 id="myModalLabel'.$v['PermissionGroup']['id'].'">&nbsp;</h3>
    </div>
    <div class="modal-body">
    </div>
</div>
    </td>';
    foreach ($roles as $vv){
	
	echo "<td>".$this->Form->input('test', array('type' => 'checkbox', 'name' => "perm[{$vv['Role']['id']}][{$v['PermissionGroup']['id']}]", 'label' => false, 'checked' => (isset($perms[$vv['Role']['id']][$v['PermissionGroup']['id']]) && $perms[$vv['Role']['id']][$v['PermissionGroup']['id']] == 1) ? true : false))."</td>";
    }
    echo '</tr>';
}
echo '</table>';
echo $this->Form->end('Save');

?>
