<div class="list-group-item" data-id="<?php echo $message['Message']['id']; ?>">
    <div type="button"
        onmousedown="startDeleteTimer(<?php echo $message['Message']['id']; ?>)"
        onmouseup="cancelDeleteTimer()"
        onmouseleave="cancelDeleteTimer()"
        class="delete-message-button <?php echo $message['Message']['senderId'] === AuthComponent::user('id') ? 'message-right delete-message list-group-item-primary pointer-right' : 'message-left pointer-left'; ?>">
        <p class="message-content" onclick="this.classList.toggle('expanded');"><?php echo h($message['Message']['body']); ?></p>
        <small class="text-dark"><?php echo h(date('h:i A', strtotime($message['Message']['createdAt']))); ?></small>
    </div>
</div>

<style>
    .pointer-right {
        cursor: pointer;
    }

    .pointer-left {
        cursor: pointer;
    }

    .pointer-right:hover {
        background-color: #2950b9;
    }

    .pointer-left:hover {
        background-color: #b5b5b5;
    }

    .message-content {
        max-height: 1.2em;
        cursor: pointer;
        overflow: hidden;
        text-overflow: ellipsis;
        white-space: nowrap;
    }

    .message-content.expanded {
        white-space: normal;
        max-height: none;
    }
</style>

<script>
    let deleteTimer;
    let isDeleting = false;
    let messageIdToDelete;

    function startDeleteTimer(messageId) {
        messageIdToDelete = messageId; 
        deleteTimer = setTimeout(() => {
            if (!isDeleting) {
                isDeleting = true;
                deleteMessage(messageIdToDelete);
            }
        }, 2000); // Hold for 2 seconds
    }

    function cancelDeleteTimer() {
        clearTimeout(deleteTimer);
        isDeleting = false;
        messageIdToDelete = null; 
    }

    function deleteMessage(messageId) {
        if (confirm('Are you sure you want to delete this message?')) {
            $.ajax({
                type: 'POST',
                url: '<?php echo $this->Html->url(array('action' => 'delete')); ?>',
                data: {
                    id: messageId
                },
                dataType: 'json',
                success: function(response) {
                    if (response.success) {
                        
                        $('.list-group-item[data-id="' + messageId + '"]').fadeOut(400, function() {
                            $(this).remove(); 
                        });
                    } else {
                        alert('Error: ' + (response.error || 'Could not delete the message.'));
                    }
                },
                error: function() {
                    alert('An error occurred while deleting the message.');
                }
            });
        } else {
            cancelDeleteTimer();
        }
    }
</script>