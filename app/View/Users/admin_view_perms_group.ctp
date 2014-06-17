<?php
if(count($groups)){
    echo "Functions under {$groups['PermissionGroup']['name']}";
    if(count($groups['PermissionSet'])){
	echo '<table class="table">';
	echo '<tr><th>Function</th><th>Action</th></tr>';
	foreach($groups['PermissionSet'] as $v){
	    
	    $aco = $this->requestAction('/admin/users/get_function_name/'.$v['action']);
	    echo "<tr id=\"tr_{$v['id']}\"><td>{$aco['parent']}/{$aco['aco']}</td>";
	    echo '<td class="text-center" >'.$this->Html->link('<i class="icon-remove icon-red"></i>', array('admin' => true, 'controller' => 'users', 'action' => 'admin_remove_group_function', $v['id']), array('rel' => $v['id'], 'escape' => false, 'class' => 'remove_perm_group'), 'Are you sure want to remove the function from the group?').'</td></tr>';
	}
	echo '</table>';
    }
}
?>
<script>
$(document).ready(function(){
    $('.remove_perm_group').click(function(e){
	e.preventDefault();
	var href = $(this).attr('href');
	var id = $(this).attr('rel');
	$.get(href, function(data){
	    if(data == 1){
		$('#tr_'+id).remove();
	    }
	});
    });
});
</script>