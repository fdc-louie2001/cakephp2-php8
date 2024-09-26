<?php
/**
 * Conversation Fixture
 */
class ConversationFixture extends CakeTestFixture {

/**
 * Table name
 *
 * @var string
 */
	public $table = 'conversation';

/**
 * Fields
 *
 * @var array
 */
	public $fields = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => null, 'unsigned' => false, 'key' => 'primary'),
		'user1' => array('type' => 'integer', 'null' => false, 'default' => null, 'unsigned' => false),
		'user2' => array('type' => 'integer', 'null' => false, 'default' => null, 'unsigned' => false),
		'createdAt' => array('type' => 'datetime', 'null' => false, 'default' => null),
		'indexes' => array(
			'PRIMARY' => array('column' => 'id', 'unique' => 1)
		),
		'tableParameters' => array('charset' => 'utf8mb4', 'collate' => 'utf8mb4_0900_ai_ci', 'engine' => 'InnoDB')
	);

/**
 * Records
 *
 * @var array
 */
	public $records = array(
		array(
			'id' => 1,
			'user1' => 1,
			'user2' => 1,
			'createdAt' => '2024-09-24 05:50:15'
		),
	);

}
