<div class="list-group-item list-group-item-action d-flex justify-content-between align-items-center">
    <div class="d-flex align-items-center w-100"
        onclick="window.location='<?php echo $this->Html->url(['controller' => 'messages', 'action' => 'view', $sender['conversationId']]); ?>'">
        <?php echo $this->Html->image($sender['profilePic'], ['width' => '50', 'height' => '50', 'class' => 'avatar']); ?>
        <div class="ml-2">
            <h6 class="mb-1"><?php echo h($sender['name']); ?></h6>
            <p class="mb-0 text-muted message-preview"><?php echo h($sender['lastMessage']); ?></p>
        </div>
    </div>
    <div>
        <small class="text-muted"><?php echo h(date('h:i A', strtotime($sender['lastMessageTime']))); ?></small>
        <?php echo $this->Form->postLink(
            __('Delete'),
            ['controller' => 'messages', 'action' => 'destroy', $sender['conversationId']],
            [
                'class' => 'btn btn-danger ml-2',
                'confirm' => 'Are you sure you want to delete this conversation?'
            ]
        ); ?>
    </div>
</div>