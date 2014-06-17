<?php
/**
 * Component to log data/errors into database
 */
class LogComponent extends Component {
    
    protected $Log = array();
    
    public function startup(Controller $controller){
        $this->Log = $file = ClassRegistry::init('Log');
    }
    
    public function log($name = 'CUSTOM', $message = 'Message'){
        $this->Log->save(
                array('name' => $name, 'value' => serialize($message)));
    }
    
}