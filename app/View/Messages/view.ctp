<!-- View.ctp in Messages -->

<!-- Main Content -->
<div class="container-sm">
    <p class="font-weight-bold text-uppercase">
        <?php
        // Check if messages are available and get the sender's name
        if (!empty($messages)) {
            if (AuthComponent::user('id') == $messages[0]['Sender']['id']) {
                // Create a link for the receiver's name with the conversationId as a parameter
                echo $this->Html->link(
                    h($messages[0]['Receiver']['name']),
                    ['controller' => 'Users', 'action' => 'view', $messages[0]['Receiver']['id']],
                    ['escape' => false] // Set to false if you want to allow HTML characters in the name
                );
            } else {
                // Display the sender's name of the first message as a link
                echo $this->Html->link(
                    h($messages[0]['Sender']['name']),
                    ['controller' => 'Users', 'action' => 'view', $messages[0]['Sender']['id']],
                    ['escape' => false] // Set to false if you want to allow HTML characters in the name
                ); // Display the sender's name
            }
        }
        ?>
    </p>
    <div class="mt-3 d-flex align-items-center">
        <!-- Message Form -->
        <?php echo $this->Form->create(null, ['id' => 'message-form', 'url' => ['controller' => 'messages', 'action' => 'replyMessage']]); ?>

        <!-- Hidden field to pass user_id and conversationId -->
        <?php echo $this->Form->hidden('user_id', ['value' => $messages[0]['Receiver']['id']]);  ?>
        <?php echo $this->Form->hidden('conversationId', ['value' => $conversationId]); ?>

        <!-- Message input field -->
        <?php echo $this->Form->input('body', [
            'type' => 'text',
            'class' => '',
            'placeholder' => 'Type your message here...',
            'label' => false
        ]); ?>

        <!-- Submit button -->
        <?php echo $this->Form->button(__('Send Message'), ['class' => 'btn btn-primary float-right']); ?>
        <?php echo $this->Form->end(); ?>
    </div>

    <div class="list-group container-sm inbox" id="messageList">
        <?php echo $this->element('conversations', ['messages' => $messages]); ?>
    </div>

    <!-- Load More Button -->
    <?php if ($hasMore): ?>
        <button id="load-more" type="button" class="btn btn-primary mt-3">Load More</button>
    <?php endif; ?>

</div>

<script>
    $(document).ready(function() {
        var currentPage = 1;

        // Load more messages when the "Load More" button is clicked
        $('#load-more').on('click', function() {
            currentPage++;
            $.ajax({
                url: '<?php echo $this->Html->url(['action' => 'view', $conversationId]); ?>',
                data: {
                    page: currentPage
                },
                success: function(response) {
                    console.log(response); // Log the response to see what is being returned
                    $('#messageList').append(response);

                    // If no more messages to load, hide the "Load More" button
                    if (response.trim() === '') {
                        $('#load-more').hide();
                    }
                },
                error: function() {
                    alert('An error occurred while loading more messages.');
                }
            });
        });

        // Handle message form submission via AJAX
        $('#message-form').on('submit', function(e) {
            e.preventDefault();
            var data = $(this).serialize();

            $.ajax({
                type: 'POST',
                url: $(this).attr('action'),
                data: data,
                dataType: 'json',
                success: function(response) {
                    $('#message-form')[0].reset();
                    if (response.success) {
                        // Prepend the new message
                        $('#messageList').prepend(response.html);
                    } else {
                        alert('Error: ' + response.errors.join(', '));
                    }
                },
                error: function() {
                    alert('An error occurred while sending the message.');
                }
            });
        });
    });
</script>




<!-- Custom CSS -->
<style>
    .inbox {
        max-height: 500px;
        overflow-y: auto;
        padding: 0 10px;
        border-radius: 8px;
        box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
    }

    .list-group-item {
        border: none;
        margin-bottom: 10px;
        clear: both;
    }

    .message-left {
        background-color: #f8f9fa;
        border-radius: 10px;
        padding: 10px;
        max-width: 50%;
        float: left;
    }

    .message-right {
        background-color: #007bff;
        color: white;
        border-radius: 10px;
        padding: 10px;
        max-width: 50%;
        float: right;
    }

    .list-group-item::after {
        content: "";
        display: table;
        clear: both;
    }
</style>