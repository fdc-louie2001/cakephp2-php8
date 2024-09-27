<div class="list-group" id="message-container">
    <?php if (empty($uniqueSenders)) : ?>
        <p>No Conversations</p>
    <?php else : ?>
        <?php foreach ($uniqueSenders as $sender) : ?>
           <?php echo $this->element('message_details', ['sender' => $sender]); ?>
        <?php endforeach; ?>
    <?php endif; ?>
</div>


