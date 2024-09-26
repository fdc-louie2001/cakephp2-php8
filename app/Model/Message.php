<?php
App::uses('AppModel', 'Model');
/**
 * Message Model
 *
 */
class Message extends AppModel {

/**
 * Validation rules
 *
 * @var array
 */
	public $validate = array(
		'body' => array(
			'notBlank' => array(
				'rule' => array('notBlank'),
				//'message' => 'Your custom message here',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
        'createdAt' => array(
			'datetime' => array(
				'rule' => array('datetime'),
				//'message' => 'Your custom message here',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),

	);

    public function beforeSave($options = array()) {
		// Set the current timestamp for 'createdAt' field if not already set
		if (empty($this->data[$this->alias]['createdAt'])) {
			$this->data[$this->alias]['createdAt'] = date('Y-m-d H:i:s');
		}
		
		return true;
	}

    public $belongsTo = [
        'Sender' => [
            'className' => 'User',
            'foreignKey' => 'senderId',
        ],
        'Receiver' => [
            'className' => 'User',
            'foreignKey' => 'receiverId',
        ]
    ];

    public function getOrCreateConversationId($user1Id, $user2Id) {
        // Logic to retrieve or create a conversation ID
        // For simplicity, this could be a hash of the user IDs or querying a Conversation model
        $conversationId = md5(min($user1Id, $user2Id) . '-' . max($user1Id, $user2Id));
    
        return $conversationId; 
    }

    
    

}
