<?php
App::uses('AppController', 'Controller');
/**
 * Messages Controller
 */
class MessagesController extends AppController
{

	/**
	 * Scaffold
	 *
	 * @var mixed
	 */
	public $scaffold;
	public $components = array('Paginator', 'Session', 'Flash');
	public $uses = ['User', 'Message'];

	public function generateConversationId($senderId, $receiverId)
	{
		// Create a unique string by concatenating the IDs
		return md5(min($senderId, $receiverId) . max($senderId, $receiverId));
	}

	public function getMessagesBetween($user1Id, $user2Id)
	{
		return $this->Message->find('all', [
			'conditions' => [
				'OR' => [
					'AND' => [
						'Message.senderId' => $user1Id,
						'Message.receiverId' => $user2Id
					],
					'AND' => [
						'Message.senderId' => $user2Id,
						'Message.receiverId' => $user1Id
					]
				]
			],
			'order' => ['Message.createdAt' => 'ASC'], // Order by creation time
			'contain' => ['Sender', 'Receiver'] // Include related user data if needed
		]);
	}


	public function index()
	{
		// Fetch the currently logged-in user's ID
		$currentUserId = AuthComponent::user('id');

		// Determine the offset and limit for the AJAX request
		$offset = $this->request->query('offset') ?: 0; // Default to 0 if not set
		$limit = 5; // Limit to 5 messages per request

		// Fetch messages where the current user is the receiver or sender
		$receivedMessages = $this->Message->find('all', [
			'conditions' => [
				'OR' => [
					'Message.receiverId' => $currentUserId,
					'Message.senderId' => $currentUserId
				]
			],
			'contain' => ['Sender', 'Receiver', 'Conversation'],
			'order' => ['Message.createdAt' => 'DESC'],
			'limit' => $limit,
			'offset' => $offset, // Use the offset for pagination
		]);

		// Group messages by conversationId
		$groupedMessages = [];
		foreach ($receivedMessages as $message) {
			$conversationId = $message['Message']['conversationId'];

			// Initialize the group for this conversation if it doesn't exist
			if (!isset($groupedMessages[$conversationId])) {
				$groupedMessages[$conversationId] = [
					'conversationId' => $conversationId,
					'messages' => [],
					'lastMessage' => '',
					'lastMessageTime' => null,
					'senderId' => null,
					'senderName' => null,
					'profilePic' => null,
				];
			}
			// Add the current message to the group's message array
			$groupedMessages[$conversationId]['messages'][] = $message['Message'];

			// Update the last message details if this message is more recent
			if (
				empty($groupedMessages[$conversationId]['lastMessageTime']) ||
				strtotime($message['Message']['createdAt']) > ($groupedMessages[$conversationId]['lastMessageTime'])
			) {
				// Update last message details
				$groupedMessages[$conversationId]['lastMessage'] = $message['Message']['body'];
				$groupedMessages[$conversationId]['lastMessageTime'] = $message['Message']['createdAt'];

				// Determine the sender and receiver
				if ($message['Message']['senderId'] === $currentUserId) {
					// If the current user is the sender, use the receiver's info
					$groupedMessages[$conversationId]['senderId'] = $message['Message']['receiverId'];
					$groupedMessages[$conversationId]['senderName'] = $message['Receiver']['name'];
					$groupedMessages[$conversationId]['profilePic'] = $message['Receiver']['profilePic'];
				} else {
					// If the current user is the receiver, use the sender's info
					$groupedMessages[$conversationId]['senderId'] = $message['Message']['senderId'];
					$groupedMessages[$conversationId]['senderName'] = $message['Sender']['name'];
					$groupedMessages[$conversationId]['profilePic'] = $message['Sender']['profilePic'];
				}
			}
		}

		// Prepare unique senders for the view from the grouped messages
		$uniqueSenders = [];
		foreach ($groupedMessages as $conversation) {
			$uniqueSenders[] = [
				'id' => $conversation['senderId'],
				'name' => $conversation['senderName'],
				'profilePic' => $conversation['profilePic'],
				'conversationId' => $conversation['conversationId'],
				'lastMessage' => $conversation['lastMessage'],
				'lastMessageTime' => $conversation['lastMessageTime'],
			];
		}
		
		// If it's an AJAX request, return only the unique senders
		if ($this->request->is('ajax')) {
		
			$this->set(compact('uniqueSenders'));
		
			$this->render('/Elements/message_list', 'ajax');
		} else {
			// Pass the grouped messages and unique senders to the view
			$this->set(compact('uniqueSenders', 'groupedMessages'));
		}
	}

	// New method to handle loading more users/messages
	public function loadMoreUsers()
{	
	
    $this->autoRender = false; // Prevent automatic rendering d
    if ($this->request->is('ajax')) {
        // Call the index method to load more messages
      
		$this->index();
        // Render the message details element
        $this->render('/Elements/message_list', 'ajax');
    }
}

	public function add()
	{
		// Fetch users for the dropdown
		$users = $this->User->find('list', [
			'fields' => ['User.id', 'User.name'],
			'order' => ['User.name' => 'ASC']
		]);

		// Check if the request is an AJAX POST request
		if ($this->request->is('ajax')) {
			$this->Message->create();

			// Get sender ID from the authenticated user
			$senderId = AuthComponent::user('id');

			// Initialize receiverId and conversationId
			$receiverId = null;
			$conversationId = isset($this->request->data['Message']['conversationId']) ? $this->request->data['Message']['conversationId'] : null;

			// If the conversationId is set, fetch the existing conversation to find the receiverId
			if (!empty($conversationId)) {
				$existingMessage = $this->Message->find('first', [
					'conditions' => ['Message.conversationId' => $conversationId],
					'fields' => ['Message.senderId', 'Message.receiverId']
				]);

				if (!empty($existingMessage)) {
					$receiverId = $existingMessage['Message']['senderId'] === $senderId ? $existingMessage['Message']['receiverId'] : $existingMessage['Message']['senderId'];
				} else {
					$receiverId = $this->request->data['Message']['user_id']; // Fallback to user_id
				}
			} else {
				// No conversationId means new conversation, receiverId comes from the form
				$receiverId = $this->request->data['Message']['user_id'];
				$conversationId = $this->generateConversationId($senderId, $receiverId); // New conversation ID
			}

			// Prepare the message data
			$data = [
				'Message' => [
					'senderId' => $senderId,
					'receiverId' => $receiverId,
					'body' => $this->request->data['Message']['body'],
					'conversationId' => $conversationId,
					'createdAt' => date('Y-m-d H:i:s'),
				]
			];

			// AJAX handling for saving the message
			if ($this->Message->save($data)) {
				// Return a success response
				$this->set('response', [
					'success' => true,
					'data' => [
						'body' => $data['Message']['body'],
						'createdAt' => date('h:i A', strtotime($data['Message']['createdAt'])),
					]
				]);
			} else {
				$errors = $this->Message->validationErrors;
				$this->set('response', [
					'success' => false,
					'errors' => $errors
				]);
			}


			$this->set('_serialize', 'response'); // Prepare response for JSON
			return; // Exit after handling AJAX request
		}

		// Always set $users to be used in the view
		$this->set(compact('users'));

		// Render the view for normal requests
		// $this->render(); // Optional, since this is the default behavior
	}


	public function replyMessage()
	{
		$this->autoRender = false;

		if ($this->request->is('ajax')) {
			$this->Message->create();
			$senderId = AuthComponent::user('id');

			// Initialize receiverId and conversationId
			$receiverId = null;
			$conversationId = isset($this->request->data['User']['conversationId']) ? $this->request->data['User']['conversationId'] : null;

			if (!empty($conversationId)) {
				$existingMessage = $this->Message->find('first', [
					'conditions' => ['Message.conversationId' => $conversationId],
					'fields' => ['Message.senderId', 'Message.receiverId']
				]);

				if (!empty($existingMessage)) {
					$receiverId = $existingMessage['Message']['senderId'] === $senderId ? $existingMessage['Message']['receiverId'] : $existingMessage['Message']['senderId'];
				} else {
					$receiverId = $this->request->data['User']['user_id']; // Fallback to user_id
				}
			} else {
				// New conversation
				$receiverId = $this->request->data['User']['user_id'];
				$conversationId = $this->generateConversationId($senderId, $receiverId); // New conversation ID
			}

			// Prepare the message data
			$data = [
				'Message' => [
					'senderId' => $senderId,
					'receiverId' => $receiverId,
					'body' => $this->request->data['User']['body'],
					'conversationId' => $conversationId,
					'createdAt' => date('Y-m-d H:i:s'),
				]
			];

			// AJAX handling for saving the message
			if ($this->Message->save($data)) {
				// Fetch the newly saved message
				$newMessage = $this->Message->findById($this->Message->id);

				// Load the View class to use element rendering
				$view = new View($this, false); // `false` disables layout rendering
				$newMessageHtml = $view->element('conversation_card', ['message' => $newMessage]);

				// Return the rendered HTML of the new message
				$this->response->type('json');
				$this->response->body(json_encode([
					'success' => true,
					'html' => $newMessageHtml, // Only the HTML of the conversation_card element
				]));
			} else {
				$errors = $this->Message->validationErrors;
				$this->response->type('json');
				$this->response->body(json_encode([
					'success' => false,
					'errors' => $errors
				]));
			}
		} else {
			$this->add();
		}
	}



	public function view($conversationId)
	{
		$limit = 5; // Limit to 5 messages per batch
		$page = $this->request->query('page') ?: 1; // Default to page 1
		$noMessagesFound = false;

		// Fetch messages with offset and limit
		$messages = $this->Message->find('all', [
			'conditions' => ['Message.conversationId' => $conversationId],
			'contain' => ['Sender', 'Receiver'],
			'order' => ['Message.createdAt' => 'DESC'],
			'limit' => $limit,
		]);

		// Count total messages to determine if there are more to load
		$totalMessages = $this->Message->find('count', [
			'conditions' => ['Message.conversationId' => $conversationId]
		]);

		// Check if more messages are available to load
		$hasMore = $limit < $totalMessages;

		$this->set(compact('messages', 'conversationId', 'hasMore', 'noMessagesFound'));

		if ($this->request->is('ajax')) {
			// Render the next batch of messages without layout for AJAX request
			$this->render('Elements/conversations');
		}
	}

	public function searchMessages($conversationId)
	{
		$this->autoRender = false; // Prevent CakePHP from rendering a default view

		// Get the search query from the request
		$searchQuery = $this->request->query('body');

		// Get the current page from the request, default to 1
		$page = $this->request->query('page') ?: 1;
		$limit = 5; // Limit to 5 messages per batch

		// Define base conditions to fetch messages for the conversation
		$conditions = ['Message.conversationId' => $conversationId];

		// If search query is not empty, add search condition
		if (!empty($searchQuery)) {
			$conditions['Message.body LIKE'] = '%' . $searchQuery . '%';
		}

		// Perform the search with pagination
		$messages = $this->Message->find('all', [
			'conditions' => $conditions,
			'contain' => ['Sender', 'Receiver'],
			'order' => ['Message.createdAt' => 'DESC'],
			'limit' => $limit,
			'page' => $page // Add pagination parameters
		]);

		// Set the variable for no messages found
		$noMessagesFound = empty($messages) && !empty($searchQuery);

		// Pass the messages and noMessagesFound variable to the element
		if ($this->request->is('ajax')) {
			$this->set(compact('messages', 'noMessagesFound'));
			$this->render('/Elements/conversations', 'ajax');
		} else {
			throw new NotFoundException(); // Handle non-AJAX request
		}
	}

	public function loadMoreMessages($conversationId)
	{

		$limit = 5; // Limit to 5 messages per batch
		$page = $this->request->query('page') ?: 1; // Default to page 1
		$offset = ($page - 1) * $limit;
		$noMessagesFound = false;

		// Fetch messages with offset and limit
		$messages = $this->Message->find('all', [
			'conditions' => ['Message.conversationId' => $conversationId],
			'contain' => ['Sender', 'Receiver'],
			'order' => ['Message.createdAt' => 'DESC'],
			'limit' => $limit,
			'offset' => $offset
		]);

		// Count total messages to determine if there are more to load
		$totalMessages = $this->Message->find('count', [
			'conditions' => ['Message.conversationId' => $conversationId]
		]);

		// Check if more messages are available to load
		$hasMore = ($offset + $limit) < $totalMessages;

		// Set variables for the view
		$this->set(compact('messages', 'conversationId', 'hasMore', 'noMessagesFound'));

		// Check if it's an AJAX request
		if ($this->request->is('ajax')) {
			// Render the 'Elements/conversations' element without layout
			$this->render('/Elements/conversations', 'ajax');
		} else {
			// Handle non-AJAX request (optional)
			throw new NotFoundException();
		}
	}



	// Delete Whole Conversation
	public function destroy($conversationId)
	{
		if ($this->request->is('post')) {
			// Fetch the currently logged-in user's ID
			$currentUserId = AuthComponent::user('id');

			// Check if the conversation exists and the user is part of it (either sender or receiver)
			$conversationExists = $this->Message->find('count', [
				'conditions' => [
					'Message.conversationId' => $conversationId,
					'OR' => [
						'Message.senderId' => $currentUserId,
						'Message.receiverId' => $currentUserId
					]
				]
			]);

			if ($conversationExists > 0) {
				// Delete all messages in the conversation
				if ($this->Message->deleteAll(['Message.conversationId' => $conversationId], false)) {
					$this->Flash->success(__('The conversation has been deleted.'));
				} else {
					$this->Flash->error(__('Failed to delete the conversation. Please try again.'));
				}
			} else {
				$this->Flash->error(__('Conversation not found or you are not a participant.'));
			}

			// Redirect the user to the inbox or another page
			return $this->redirect(['controller' => 'messages', 'action' => 'index']);
		}
	}


	//delete specific message
	public function delete()
	{
		$this->autoRender = false;

		// Check if the request is AJAX
		if ($this->request->is('ajax')) {
			$id = $this->request->data('id'); // Get the ID from POST data
			if ($this->Message->delete($id)) {
				// Set the response type to JSON
				$this->response->type('json');
				// Return success response
				$this->response->body(json_encode(['success' => true]));
			} else {
				// Handle deletion failure
				$this->response->type('json');
				$this->response->body(json_encode(['success' => false, 'error' => 'Could not delete the message.']));
			}
		} else {
			// Handle non-AJAX request (optional)
			$this->Flash->error(__('Invalid request.'));
			return $this->redirect(['action' => 'index']);
		}
	}
}
