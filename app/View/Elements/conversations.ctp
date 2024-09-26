<!-- conversation.ctp in Elements -->
<?php foreach ($messages as $message): ?>
            <?php echo $this->element('conversation_card', ['message' => $message]); ?>
<?php endforeach; ?>


