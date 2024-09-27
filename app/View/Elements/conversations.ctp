<!-- conversation.ctp in Elements -->
<?php if ($noMessagesFound): ?>
    <p>No messages found. Please try a different search.</p>
<?php elseif (!empty($messages)): ?>
    <!-- Loop through messages and display them -->
    <?php foreach ($messages as $message): ?>
        <?php echo $this->element('conversation_card', ['message' => $message]); ?>
    <?php endforeach; ?>
<?php else: ?>
    <p>There are no messages in this conversation.</p>
<?php endif; ?>




