<?php
App::uses('AppController', 'Controller');
/**
 * PermissionSets Controller
 *
 * @property PermissionSet $PermissionSet
 * @property PaginatorComponent $Paginator
 */
class PermissionSetsController extends AppController {

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
		$this->PermissionSet->recursive = 0;
		$this->set('permissionSets', $this->Paginator->paginate());
	}

/**
 * view method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function view($id = null) {
		if (!$this->PermissionSet->exists($id)) {
			throw new NotFoundException(__('Invalid permission set'));
		}
		$options = array('conditions' => array('PermissionSet.' . $this->PermissionSet->primaryKey => $id));
		$this->set('permissionSet', $this->PermissionSet->find('first', $options));
	}

/**
 * add method
 *
 * @return void
 */
	public function add() {
		if ($this->request->is('post')) {
			$this->PermissionSet->create();
			if ($this->PermissionSet->save($this->request->data)) {
				$this->Session->setFlash(__('The permission set has been saved.'));
				return $this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The permission set could not be saved. Please, try again.'));
			}
		}
		$permissionGroups = $this->PermissionSet->PermissionGroup->find('list');
		$this->set(compact('permissionGroups'));
	}

/**
 * edit method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function edit($id = null) {
		if (!$this->PermissionSet->exists($id)) {
			throw new NotFoundException(__('Invalid permission set'));
		}
		if ($this->request->is(array('post', 'put'))) {
			if ($this->PermissionSet->save($this->request->data)) {
				$this->Session->setFlash(__('The permission set has been saved.'));
				return $this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The permission set could not be saved. Please, try again.'));
			}
		} else {
			$options = array('conditions' => array('PermissionSet.' . $this->PermissionSet->primaryKey => $id));
			$this->request->data = $this->PermissionSet->find('first', $options);
		}
		$permissionGroups = $this->PermissionSet->PermissionGroup->find('list');
		$this->set(compact('permissionGroups'));
	}

/**
 * delete method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function delete($id = null) {
		$this->PermissionSet->id = $id;
		if (!$this->PermissionSet->exists()) {
			throw new NotFoundException(__('Invalid permission set'));
		}
		$this->request->allowMethod('post', 'delete');
		if ($this->PermissionSet->delete()) {
			$this->Session->setFlash(__('The permission set has been deleted.'));
		} else {
			$this->Session->setFlash(__('The permission set could not be deleted. Please, try again.'));
		}
		return $this->redirect(array('action' => 'index'));
	}
}
