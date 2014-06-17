<p class="spam9">
<?php
echo $this->Form->create('User');
echo $this->Form->input('name_id', array('options' => $perm_names));
echo $this->Form->input('name', array('after' => '<span>Use this to inser new name</span>'));
echo $this->Form->input('controller_id', array('options' => $controllers, 'onchange' => 'get_actions(this.value)'));
echo $this->Form->input('action_id', array('options' => $actions, 'multiple' => true));
echo $this->Form->end('Save');
?></p>
<script>
    function get_actions(val){
	$.get('/admin/users/get_actions/'+val, function(data){
	    $('#UserActionId').html(data);
	});
    }
</script>