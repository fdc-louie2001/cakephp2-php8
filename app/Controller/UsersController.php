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
        if ($this->User->save($this->request->data)) {
            $this->Flash->success(__('The user has been saved.'));
            return $this->redirect(array('action' => 'index'));
        } else {
            $this->Flash->error(__('The user could not be saved. Please, try again.'));
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

        $this->authUser($id);

    if ($this->request->is(['post', 'put'])) {
        $this->User->id = $id;

        // Handle profile picture upload
        if (!empty($this->request->data['User']['profilePic']['name'])) {
            $file = $this->request->data['User']['profilePic'];
            $uploadPath = WWW_ROOT . 'img' . DS . 'uploads' . DS;

            // Ensure the uploads directory exists
            if (!file_exists($uploadPath)) {
                mkdir($uploadPath, 0755, true);
            }

            // Generate a unique filename
            $filename = time() . '_' . basename($file['name']);
            $fullPath = $uploadPath . $filename;

            // Move the uploaded file
            if (move_uploaded_file($file['tmp_name'], $fullPath)) {
                $this->request->data['User']['profilePic'] = 'uploads/' . $filename; // Save the relative path
            } else {
                $this->Flash->error(__('Unable to upload the profile picture.'));
            }
        } else {
            // If no new file is uploaded, retain the existing profile picture
            unset($this->request->data['User']['profilePic']); // Make sure this is not set to an array
        }


        // Save the user data
        if ($this->User->save($this->request->data)) {
            $this->Flash->success(__('The user has been saved.'));
            return $this->redirect('/messages/index');
        } else {
            $this->Flash->error(__('The user could not be saved. Please, try again.'));
        }
    } else {
        // Load existing user data into $this->request->data
        $options = ['conditions' => ['User.' . $this->User->primaryKey => $id]];
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


    public function change_password() {
        $this->autoRender = false; // Disable view rendering
    
        // Check if the request is POST
        if ($this->request->is('post')) {
            $userId = $this->Auth->user('id'); // Get the currently logged-in user ID
            $user = $this->User->findById($userId);
    
            if (!$user) {
                echo json_encode(['status' => 'error', 'message' => 'User not found']);
                return;
            }
    
            $currentPassword = $this->request->data['currentPassword'];
            $newPassword = $this->request->data['newPassword'];
    

            // Verify current password
            if (AuthComponent::password($currentPassword) !== $user['User']['password']) {
                echo json_encode(['status' => 'error', 'message' => 'Current password is incorrect']);
                return;
            }

            // Update the password with the new one
            $this->User->id = $userId; // Set the user ID
            $this->User->saveField('password', $newPassword); // Save new password
    
            echo json_encode(['status' => 'success', 'message' => 'Password updated successfully']);
        } else {
            echo json_encode(['status' => 'error', 'message' => 'Invalid request']);
        }
    
        // Set response type to JSON
        $this->response->type('application/json');
    }
    
    public function authUser($id = null) {
        
        if(AuthComponent::user('id') != $id) {
            return $this->redirect('/');
        }

    }
}
