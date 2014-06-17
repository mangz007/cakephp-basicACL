<?php
App::uses('AppController', 'Controller');
/**
 * PermissionRules Controller
 *
 * @property PermissionRule $PermissionRule
 * @property PaginatorComponent $Paginator
 */
class PermissionRulesController extends AppController {

/**
 * Components
 *
 * @var array
 */
	public $components = array('Paginator');

/**
 * index method
 *
 * @return void
 */
	public function index() {
		$this->PermissionRule->recursive = 0;
		$this->set('permissionRules', $this->Paginator->paginate());
	}

/**
 * view method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function view($id = null) {
		if (!$this->PermissionRule->exists($id)) {
			throw new NotFoundException(__('Invalid permission rule'));
		}
		$options = array('conditions' => array('PermissionRule.' . $this->PermissionRule->primaryKey => $id));
		$this->set('permissionRule', $this->PermissionRule->find('first', $options));
	}

/**
 * add method
 *
 * @return void
 */
	public function add() {
		if ($this->request->is('post')) {
			$this->PermissionRule->create();
			if ($this->PermissionRule->save($this->request->data)) {
				$this->Session->setFlash(__('The permission rule has been saved.'));
				return $this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The permission rule could not be saved. Please, try again.'));
			}
		}
		$roles = $this->PermissionRule->Role->find('list');
		$permissionGroups = $this->PermissionRule->PermissionGroup->find('list');
		$this->set(compact('roles', 'permissionGroups'));
	}

/**
 * edit method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function edit($id = null) {
		if (!$this->PermissionRule->exists($id)) {
			throw new NotFoundException(__('Invalid permission rule'));
		}
		if ($this->request->is(array('post', 'put'))) {
			if ($this->PermissionRule->save($this->request->data)) {
				$this->Session->setFlash(__('The permission rule has been saved.'));
				return $this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The permission rule could not be saved. Please, try again.'));
			}
		} else {
			$options = array('conditions' => array('PermissionRule.' . $this->PermissionRule->primaryKey => $id));
			$this->request->data = $this->PermissionRule->find('first', $options);
		}
		$roles = $this->PermissionRule->Role->find('list');
		$permissionGroups = $this->PermissionRule->PermissionGroup->find('list');
		$this->set(compact('roles', 'permissionGroups'));
	}

/**
 * delete method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function delete($id = null) {
		$this->PermissionRule->id = $id;
		if (!$this->PermissionRule->exists()) {
			throw new NotFoundException(__('Invalid permission rule'));
		}
		$this->request->allowMethod('post', 'delete');
		if ($this->PermissionRule->delete()) {
			$this->Session->setFlash(__('The permission rule has been deleted.'));
		} else {
			$this->Session->setFlash(__('The permission rule could not be deleted. Please, try again.'));
		}
		return $this->redirect(array('action' => 'index'));
	}
}
