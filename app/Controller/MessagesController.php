<?php
App::uses('AppController', 'Controller');

/**
 * Messages Controller
 *
 * @property Message $Message
 * @property PaginatorComponent $Paginator
 */
class MessagesController extends AppController {

    /**
     * Components
     *
     * @var array
     */
    public $components = array('Paginator');

    /**
     * Index method
     *
     * @return void
     */
    public function index() {
        // // Paginate and set messages for the view
        // $this->Message->recursive = 0;
        // $this->set('messages', $this->Paginator->paginate());
    }
    
}
