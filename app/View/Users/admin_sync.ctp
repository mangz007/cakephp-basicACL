<?php

if ((isset($missing_aco_nodes) && count($missing_aco_nodes)) || (isset($nodes_to_prune) && count($nodes_to_prune))) {
    echo '<p class="text-error">All nodes not synced properly. Please sync them.</p>';
    
    if(isset($missing_aco_nodes) && count($missing_aco_nodes)){
	echo '<p> Following new functions found';
	echo '<ul>';
	foreach($missing_aco_nodes as $v){
	    echo "<li>$v</li>";
	}
	echo '</ul>';
	echo '</p>';
    }
    
    if(isset($nodes_to_prune) && count($nodes_to_prune)){
	echo '<p> Following functions are missing they will be pruned';
	echo '<ul>';
	foreach($nodes_to_prune as $v){
	    echo "<li>$v</li>";
	}
	echo '</ul>';
	echo '</p>';
    }
    
    echo $this->Form->create('User');
    echo $this->Form->input('test', array('type' => 'hidden'));
    echo $this->Form->submit('Sync All', array('class' => 'btn btn-danger'));
    echo $this->Form->end();
} else {
    echo '<p class="text-success">All nodes synced</p>';
}


