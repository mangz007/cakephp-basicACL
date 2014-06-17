<?php
App::uses('AppController', 'Controller');
/**
 * PermissionGroups Controller
 *
 * @property PermissionGroup $PermissionGroup
 * @property PaginatorComponent $Paginator
 */
class PermissionGroupsController extends AppController {

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
		$this->PermissionGroup->recursive = 0;
		$this->set('permissionGroups', $this->Paginator->paginate());
	}

/**
 * view method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function view($id = null) {
		if (!$this->PermissionGroup->exists($id)) {
			throw new NotFoundException(__('Invalid permission group'));
		}
		$options = array('conditions' => array('PermissionGroup.' . $this->PermissionGroup->primaryKey => $id));
		$this->set('permissionGroup', $this->PermissionGroup->find('first', $options));
	}

/**
 * add method
 *
 * @return void
 */
	public function add() {
		if ($this->request->is('post')) {
			$this->PermissionGroup->create();
			if ($this->PermissionGroup->save($this->request->data)) {
				$this->Session->setFlash(__('The permission group has been saved.'));
				return $this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The permission group could not be saved. Please, try again.'));
			}
		}
	}

/**
 * edit method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function edit($id = null) {
		if (!$this->PermissionGroup->exists($id)) {
			throw new NotFoundException(__('Invalid permission group'));
		}
		if ($this->request->is(array('post', 'put'))) {
			if ($this->PermissionGroup->save($this->request->data)) {
				$this->Session->setFlash(__('The permission group has been saved.'));
				return $this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The permission group could not be saved. Please, try again.'));
			}
		} else {
			$options = array('conditions' => array('PermissionGroup.' . $this->PermissionGroup->primaryKey => $id));
			$this->request->data = $this->PermissionGroup->find('first', $options);
		}
	}

/**
 * delete method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function delete($id = null) {
		$this->PermissionGroup->id = $id;
		if (!$this->PermissionGroup->exists()) {
			throw new NotFoundException(__('Invalid permission group'));
		}
		$this->request->allowMethod('post', 'delete');
		if ($this->PermissionGroup->delete()) {
			$this->Session->setFlash(__('The permission group has been deleted.'));
		} else {
			$this->Session->setFlash(__('The permission group could not be deleted. Please, try again.'));
		}
		return $this->redirect(array('action' => 'index'));
	}
}
