<?php echo $this->Html->css('message/inbox'); ?>

<!-- Navigation with Logout Button -->

<!-- Main Content -->
<div class="container  mt-3">
    <div class="d-flex justify-content-between align-items-center py-2">
        <h5 class="mb-0">Message History</h5>
        <?php echo $this->Html->link(
            'Create Message',
            ['controller' => 'messages', 'action' => 'add'],
            ['class' => 'btn btn-secondary']
        ); ?>
    </div>

    <div id="messageList inbox">
        <?php echo $this->element('message_list', ['uniqueSenders' => $uniqueSenders]); ?>
    </div>

    <button id="seeMore" class="btn btn-secondary mt-3" style="display: <?php echo count($uniqueSenders) >= 5 ? 'block' : 'none'; ?>;">
        See More
    </button>
</div>

<script>
$(document).ready(function() {
    let offset = 5; // Starting offset for loading more users

    $('#seeMore').on('click', function() {
        $.ajax({
            url: '<?php echo $this->Html->url(['controller' => 'messages', 'action' => 'loadMoreUsers']); ?>',
            type: 'GET',
            data: { offset: offset },
            dataType: 'html',
            success: function(data) {
                console.log(data);
                // Append the new messages to the list
                $('#message-container').append(data);
                offset += 5; 

              
                if ($(data).find('.list-group-item').length < 5) {
                    $('#seeMore').hide();
                }
            },
            error: function() {
                alert('Could not load more messages. Please try again.');
            }
        });
    });
});
</script>

