<?php
App::uses('AppModel', 'Model');
/**
 * Conversation Model
 *
 */
class Conversation extends AppModel {

/**
 * Use table
 *
 * @var mixed False or table name
 */
	public $useTable = 'conversation';

/**
 * Validation rules
 *
 * @var array
 */
	public $validate = array(
		
	);

	public function beforeSave($options = array()) {
		// Set the current timestamp for 'createdAt' field if not already set
		if (empty($this->data[$this->alias]['createdAt'])) {
			$this->data[$this->alias]['createdAt'] = date('Y-m-d H:i:s');
		}

		return true;
	}

	public $hasMany = ['Message'];
    public $belongsTo = [
        'Sender' => [
            'className' => 'User',
            'foreignKey' => 'sender_id',
        ],
        'Receiver' => [
            'className' => 'User',
            'foreignKey' => 'receiver_id',
        ],
    ];
}
