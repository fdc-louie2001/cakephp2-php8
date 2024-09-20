<?php
App::uses('AppModel', 'Model');
/**
 * User Model
 *
 */
class User extends AppModel {

/**
 * Validation rules
 *
 * @var array
 */
	public $validate = array(
		'name' => array(
			'notBlank' => array(
				'rule' => array('notBlank'),
				'message' => 'Name required',
				'required' => true,
				'allowEmpty' => false,
				'last' => false,
			),
		),
		'email' => array(
			'email' => array(
				'rule' => array('email'),
				'message' => 'Please enter a valid email address.',
				'required' => true,
				'allowEmpty' => false,
				'last' => false,
			),
			'unique' => array(
				'rule' => 'isUnique',
				'message' => 'This email is already taken.',
			)
		),
		'password' => array(
        'notBlank' => array(
            'rule' => array('notBlank'),
            'message' => 'Please enter your password.',
            'required' => true,
            'allowEmpty' => false,
            'last' => false,
        ),
        'minLength' => array(
            'rule' => array('minLength', 8),
            'message' => 'Password must be at least 8 characters long.',
        ),
		'matchPassword' => array(
    		'rule' => 'matchPasswords', // Updated method name
    		'message' => 'Passwords do not match.',
    		'last' => true // Ensure this runs after the password rule
		)
    ),
    'confirm_password' => array(
       'notBlank' => array(
            'rule' => array('notBlank'),
            'message' => 'Please enter your confirm password.',
            'required' => true,
            'allowEmpty' => false,
            'last' => false,
        ),
    ),
		'birthDate' => array(
			'datetime' => array(
				'rule' => array('datetime'),
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
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
		'lastLogin' => array(
			'datetime' => array(
				'rule' => array('datetime'),
				//'message' => 'Your custom message here',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
		'hobby' => array(
			'notBlank' => array(
				'rule' => array('notBlank'),
				//'message' => 'Your custom message here',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
	);

	/**
     * Custom validation rule to check if confirm_password matches password
     *
     * @param array $check The value to check
     * @param string $field The field name to match
     * @return bool True if valid, false otherwise
     */
	public function matchPasswords($data) {
		if($data['password'] == $this->data['User']['confirm_password']) {
			return true;
		};
		$this->invalidate('confirm_password','Passwords do not match.');
		return false;
	}

	public function beforeSave($options = array()) {
    // Set the current timestamp for 'createdAt' field if not already set
    if (empty($this->data[$this->alias]['createdAt'])) {
        $this->data[$this->alias]['createdAt'] = date('Y-m-d H:i:s');
    }

    // Set the current timestamp for 'lastLogin' field if not already set
    if (isset($this->data[$this->alias]['lastLogin']) && empty($this->data[$this->alias]['lastLogin'])) {
        $this->data[$this->alias]['lastLogin'] = date('Y-m-d H:i:s');
    }

	if(isset($this->data['User']['password'])) {
		$this->data['User']['password'] = AuthComponent::password($this->data['User']['password']);
	}

    return true;
}

	
}
