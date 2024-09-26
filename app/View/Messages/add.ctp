<?php echo $this->Html->css('message/sent'); ?>

<div class="container inbox">
    <div class="lead text-center">
        <?php
        // Create form with Message model
        echo $this->Form->create('Message', [
            'id' => 'message-form',
            'url' => ['controller' => 'messages', 'action' => 'add'],
            'class' => 'my-2 mx-auto text-center'
        ]);
           
        // User selection dropdown
        echo $this->Form->select(
            'user_id', // Field name
            $users, // Options fetched from the controller
            [
                'empty' => 'Select User', // Default option
                'class' => 'select2-search form-control mb-2', 
                'label' => false, 
                'aria-label' => 'Search People' 
            ]
        );

        // Message input field
        echo $this->Form->input('body', [
            'class' => 'message-textbox', 
            'placeholder' => 'Type your message here...',
            'label' => false // Disable label
        ]);

        // Submit button
        echo $this->Form->button(__('Send Message'), ['type' => 'submit', 'class' => 'btn btn-primary float-right']); // Align right
        echo $this->Form->end();
        ?>
    </div>
</div>

<script>
$(document).ready(function() {
    $('.select2-search').select2(); 
    $('.select2-search').on('change', function() {
        var selectedUserId = $(this).val(); // Get the selected user ID
    });

    $('#message-form').on('submit', function(e) {
        e.preventDefault();     
        var data = $(this).serialize();
        
        // Send AJAX request
        $.ajax({
            type: 'POST',
            url: $(this).attr('action'), // Use the action URL from the form
            data: data,
            success: function(response) {
                $('#message-form')[0].reset();
                console.log('Success');
                window.href.location = window.location.href = "index"
            },
            error: function() {
                alert('An error occurred. Please try again later.');
            }
        });
    });
});
</script>

