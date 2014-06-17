<?php

App::uses('AppController', 'Controller');

/**
 * Users Controller
 *
 * @property User $User
 * @property PaginatorComponent $Paginator
 */
class UsersController extends AppController {
    
    
    /**
     * Components
     *
     * @var array
     */
    public $components = array('Paginator', 'AclManager');
    
    
    
    
    public function beforeFilter() {
        parent::beforeFilter();
        $this->Auth->allow('login');
    }
    
    /*     * ******************** Lines By Mangesh Chimote **************************** */

    public function login() {
        if ($this->Session->read('Auth.User')) {
            $this->Session->setFlash('You are logged in!');
            return $this->redirect('/');
        }
        if ($this->request->is('post')) {
            if ($this->Auth->login()) {
                return $this->redirect($this->Auth->redirect());
            }
            $this->Session->setFlash(__('Your username or password was incorrect.'));
        }
    }

    public function logout() {
        $this->Session->setFlash('Good-Bye');
        $this->redirect($this->Auth->logout());
    }

    

    /**
     * index method
     *
     * @return void
     */
    public function index() {
        $this->User->recursive = 0;
        $this->set('users', $this->Paginator->paginate());
    }

    /**
     * view method
     *
     * @throws NotFoundException
     * @param string $id
     * @return void
     */
    public function view($id = null) {
        if (!$this->User->exists($id)) {
            throw new NotFoundException(__('Invalid user'));
        }
        $options = array('conditions' => array('User.' . $this->User->primaryKey => $id));
        $this->set('user', $this->User->find('first', $options));
    }

    /**
     * add method
     *
     * @return void
     */
    public function add() {
        if ($this->request->is('post')) {
            $this->User->create();
            if ($this->User->save($this->request->data)) {
                $this->Session->setFlash(__('The user has been saved.'));
                return $this->redirect(array('action' => 'index'));
            } else {
                $this->Session->setFlash(__('The user could not be saved. Please, try again.'));
            }
        }
        $roles = $this->User->Role->find('list');
        $this->set(compact('roles'));
    }

    /**
     * edit method
     *
     * @throws NotFoundException
     * @param string $id
     * @return void
     */
    public function edit($id = null) {
        if (!$this->User->exists($id)) {
            throw new NotFoundException(__('Invalid user'));
        }
        if ($this->request->is(array('post', 'put'))) {
            if ($this->User->save($this->request->data)) {
                $this->Session->setFlash(__('The user has been saved.'));
                return $this->redirect(array('action' => 'index'));
            } else {
                $this->Session->setFlash(__('The user could not be saved. Please, try again.'));
            }
        } else {
            $options = array('conditions' => array('User.' . $this->User->primaryKey => $id));
            $this->request->data = $this->User->find('first', $options);
        }
        $roles = $this->User->Role->find('list');
        $this->set(compact('roles'));
    }

    /**
     * delete method
     *
     * @throws NotFoundException
     * @param string $id
     * @return void
     */
    public function delete($id = null) {
        $this->User->id = $id;
        if (!$this->User->exists()) {
            throw new NotFoundException(__('Invalid user'));
        }
        $this->request->allowMethod('post', 'delete');
        if ($this->User->delete()) {
            $this->Session->setFlash(__('The user has been deleted.'));
        } else {
            $this->Session->setFlash(__('The user could not be deleted. Please, try again.'));
        }
        return $this->redirect(array('action' => 'index'));
    }
    
    /**
     *  Code below this line is for permissions. Edit below at your own risk
     */
    public function admin_sync($run = null) {
        if ($this->request->is('post') || $this->request->is('put')) {
            $prune_logs = $this->AclManager->prune_acos();
            $create_logs = $this->AclManager->create_acos();
            $this->set('create_logs', $create_logs);
            $this->set('prune_logs', $prune_logs);
            $this->set('run', true);
        } else {
            $nodes_to_prune = $this->AclManager->get_acos_to_prune();
            $missing_aco_nodes = $this->AclManager->get_missing_acos();

            $this->set('nodes_to_prune', $nodes_to_prune);
            $this->set('missing_aco_nodes', $missing_aco_nodes);

            $this->set('run', false);
        }
    }

    public function admin_add_user_permissions() {
        $this->loadModel('Aco');
        $this->loadModel('PermissionSet');
        $this->loadModel('PermissionGroup');

        if ($this->request->is('post') || $this->request->is('put')) {
// 	    pr($this->request->data);exit;
            if (isset($this->request->data['User']['action_id'])) {
                if (!empty($this->request->data['User']['name_id'])) {
                    $permission_group_id = $this->request->data['User']['name_id'];
                }
                if (!empty($this->request->data['User']['name'])) {
                    $permission_group_save_arr = array('PermissionGroup' => array($this->request->data['User']['name']));
                    $this->PermissionGroup->create();
                    $permission_group_save = $this->PermissionGroup->save($permission_group_save_arr);
                    $permission_group_id = $permission_group_save['PermissionGroup']['id'];
                }
                $flag = true;
                foreach ($this->request->data['User']['action_id'] as $v) {
                    $savearr = array(
                        'PermissionSet' => array(
                            'permission_group_id' => $permission_group_id,
                            'action' => $v,
                        )
                    );
                    $this->PermissionSet->create();
                    if ($this->PermissionSet->save($savearr)) {
                        
                    } else {
                        $flag = false;
                    }
                }

                if ($flag) {
                    $this->Session->setFlash('Added Permission group', 'success');
                    $this->redirect($this->here);
                } else {
                    $this->Session->setFlash('Failed submission', 'error');
                    $this->redirect($this->here);
                }
            } else {
                $this->Session->setFlash('No action passed. Nothing saved', 'error');
            }
        }

        $controllers = $this->Aco->find('list', array('fields' => array('id', 'alias'), 'conditions' => array('Aco.parent_id' => 1)));
        $keys = array_keys($controllers);
        $actions = $this->Aco->find('list', array('fields' => array('id', 'alias'), 'conditions' => array('Aco.parent_id' => $keys[0])));
        $action_keys = array_keys($actions);
        $matching = $this->PermissionSet->find('list', array('fields' => array('id', 'action'), 'conditions' => array('PermissionSet.action' => $action_keys)));
        if (count($matching)) {
            foreach ($matching as $v) {
//                unset($actions[$v]);
            }
        }
        $perm_names = $this->PermissionGroup->find('list', array('fields' => array('id', 'name')));
        $this->set('controllers', $controllers);
        $this->set('actions', $actions);
        $this->set('perm_names', $perm_names);
    }

    public function admin_get_actions($id) {
        $this->autoRender = false;
        $this->loadModel('Aco');
        $this->loadModel('PermissionSet');
        $actions = $this->Aco->find('list', array('fields' => array('id', 'alias'), 'conditions' => array('Aco.parent_id' => $id)));
        $action_keys = array_keys($actions);
        $matching = $this->PermissionSet->find('list', array('fields' => array('id', 'action'), 'conditions' => array('PermissionSet.action' => $action_keys)));
        if (count($matching)) {
            foreach ($matching as $v) {
//                unset($actions[$v]);
            }
        }
        asort($actions);
        foreach ($actions as $k => $v) {
            echo "<option value=\"$k\">$v</option>";
        }
    }

    public function admin_permissions() {
        $this->loadModel('Role');
        $this->loadModel('PermissionSet');
        $this->loadModel('PermissionRule');
        $this->loadModel('PermissionGroup');
        if ($this->request->is('post') || $this->request->is('put')) {
            foreach ($this->request->data['perm'] as $k => $v) {
                $group = $this->User->Role;
                if ($k == 1) {
                    $group->id = $k;
                    $this->Acl->allow($group, 'controllers');
                    foreach ($v as $kk => $vv) {
                        $exist = array();
                        $exist = $this->PermissionRule->find('first', array('conditions' => array('role_id' => $k, 'permission_group_id' => $kk)));
                        if (isset($exist['PermissionRule']['id'])) {
                            $exist['PermissionRule']['value'] = 1;
                            $this->PermissionRule->save($exist);
                        } else {
                            $exist = array();
                            $exist['PermissionRule'] = array('value' => 1, 'role_id' => $k, 'permission_group_id' => $kk);
                            $this->PermissionRule->create();
                            $this->PermissionRule->save($exist);
                        }
                    }
                } else {

                    $group->id = $k;
                    $this->Acl->deny($group, 'controllers');
                    foreach ($v as $kk => $vv) {
                        $details = array();
                        $exist = array();
                        $exist = $this->PermissionRule->find('first', array('conditions' => array('role_id' => $k, 'permission_group_id' => $kk)));
                        if (isset($exist['PermissionRule']['id'])) {
                            $exist['PermissionRule']['value'] = $vv;
                            $this->PermissionRule->save($exist);
                        } else {
                            $exist = array();
                            $exist['PermissionRule'] = array('value' => $vv, 'role_id' => $k, 'permission_group_id' => $kk);
                            $this->PermissionRule->create();
                            $this->PermissionRule->save($exist);
                        }
                        if ($vv == 1) {
                            $details = $this->_get_group_details($kk);
                            foreach ($details as $fn) {
                                $this->Acl->allow($group, "controllers/{$fn['parent']}/{$fn['aco']}");
                            }
                        } else {
                            $details = $this->_get_group_details($kk);
                            foreach ($details as $fn) {
                                $this->Acl->deny($group, "controllers/{$fn['parent']}/{$fn['aco']}");
                            }
                        }
                    }
                }
            }
            $this->Session->setFlash('Permissions saved', 'success');
            $this->redirect(array('controller' => 'users', 'action' => 'admin_permissions', 'admin' => true));
        }
        $rules = $this->PermissionRule->find('all');
        $perms = array();
        foreach ($rules as $v) {
            $perms[$v['PermissionRule']['role_id']][$v['PermissionRule']['permission_group_id']] = $v['PermissionRule']['value'];
        }

        $this->Role->recursive = -1;
        $roles = $this->Role->find('all');
        $groups = $this->PermissionGroup->find('all');

        $this->set('rules', $rules);
        $this->set('roles', $roles);
        $this->set('groups', $groups);
        $this->set('perms', $perms);
    }

    public function admin_view_perms_group($id = null) {
        $this->loadModel('PermissionGroup');
        $this->loadModel('PermissionSet');
        if ($this->request->is('Ajax')) {
            $this->layout = 'ajax';
        }
        $this->PermissionGroup->bindModel(array('hasMany' => array('PermissionSet' => array('className' => 'PermissionSet'))));
        $group = array();
        if ($id) {
            $group = $this->PermissionGroup->findById($id);
        }
        $this->set('groups', $group);
    }

    public function admin_get_function_name($id) {
        $this->autoRender = false;
        $this->loadModel('Aco');
        $base_aco = $this->Aco->findById($id);
        $parent_aco = $this->Aco->findById($base_aco['Aco']['parent_id']);
        return array('parent' => $parent_aco['Aco']['alias'], 'aco' => $base_aco['Aco']['alias']);
    }

    public function admin_remove_group_function($id) {
        $this->autoRender = false;
        $this->loadModel('PermissionSet');
        if ($this->PermissionSet->delete($id)) {
            echo 1;
        } else {
            echo 0;
        }
    }

    private function _get_group_details($id) {
        $this->loadModel('PermissionGroup');
        $this->loadModel('PermissionSet');
        $this->PermissionGroup->bindModel(array('hasMany' => array('PermissionSet' => array('className' => 'PermissionSet'))));
        $group = array();
        $retArr = array();
        if ($id) {
            $group = $this->PermissionGroup->findById($id);
        }

        if (count($group['PermissionSet'])) {
            foreach ($group['PermissionSet'] as $v) {
                if (isset($permisssion_groups[$v['action']])) {
                    $retArr[] = $permisssion_groups[$v['action']];
                } else {
                    $permisssion_groups[$v['action']] = $this->admin_get_function_name($v['action']);
                    $retArr[] = $permisssion_groups[$v['action']];
                }
            }
        }
        return $retArr;
    }

    /**
     *  Permission code ends
     */
    
}
