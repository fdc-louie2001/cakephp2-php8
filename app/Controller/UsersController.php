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
	public $components = array('Paginator','Session','Flash');

	public function beforeFilter()
	{
		$this->Auth->allow('add','index');
	}

/**
 * index method
 *
 * @return void
 */

 public function login() {
    if ($this->request->is('post')) {
        if ($this->Auth->login()) {
			 // Get the logged-in user's ID
			 $userId = $this->Auth->user('id');
			 // Check if a user is logged in
			 if ($userId) {
				 // Set the user's ID to update the correct record
				 $this->User->id = $userId;
		 
				 // Attempt to update the 'lastLogin' field
				 $this->User->saveField('lastLogin', date('Y-m-d H:i:s'));
			 }
            return $this->redirect($this->Auth->redirectUrl());
        } else {
            $this->Session->setFlash('Invalid username or password, try again');
        }
    }
}

// UsersController.php
public function logout() {
    // Flash message for logout success
    $this->Flash->success(__('You have been logged out.'));

    // Log out the user and redirect to the login page
    $this->Auth->logout();
    return $this->redirect(array('controller' => 'users', 'action' => 'login'));
}



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

        // Set the request data for validation
        $this->User->set($this->request->data);
            // Attempt to save the user
            if ($this->User->save($this->request->data)) {
                $this->Flash->success(__('The user has been saved.'));
                return $this->redirect(array('action' => 'index'));
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
		if (!$this->User->exists($id)) {
			throw new NotFoundException(__('Invalid user'));
		}
		if ($this->request->is(array('post', 'put'))) {
			if ($this->User->save($this->request->data)) {
				$this->Flash->success(__('The user has been saved.'));
				return $this->redirect(array('action' => 'index'));
			} else {
				$this->Flash->error(__('The user could not be saved. Please, try again.'));
			}
		} else {
			$options = array('conditions' => array('User.' . $this->User->primaryKey => $id));
			$this->request->data = $this->User->find('first', $options);
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
		if (!$this->User->exists($id)) {
			throw new NotFoundException(__('Invalid user'));
		}
		$this->request->allowMethod('post', 'delete');
		if ($this->User->delete($id)) {
			$this->Flash->success(__('The user has been deleted.'));
		} else {
			$this->Flash->error(__('The user could not be deleted. Please, try again.'));
		}
		return $this->redirect(array('action' => 'index'));
	}
}
