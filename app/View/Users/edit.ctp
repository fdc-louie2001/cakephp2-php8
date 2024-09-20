<div class="users form">
    <?php echo $this->Form->create('User'); ?>
    <fieldset>
        <legend><?php echo __('Edit User'); ?></legend>
        <?php
            echo $this->Form->input('id');
            echo $this->Form->input('name');
            echo $this->Form->input('email');
            
            // Change password field to a button
            echo $this->Form->button(__('Change Password'), [
                'class' => 'btn btn-secondary', 
                'data-toggle' => 'modal', 
                'data-target' => '#changePasswordModal'
            ]);
            
            // Gender input
            echo $this->Form->input('gender', [
                'type' => 'radio', 
                'options' => ['male' => 'Male', 'female' => 'Female'], 
                'legend' => false // Hides the legend
            ]);
            
            // Birthdate input
            echo $this->Form->input('birthDate', ['type' => 'text', 'id' => 'UserBirthDate']);
            echo $this->Form->input('hobby');
        ?>
    </fieldset>
    <?php echo $this->Form->end(__('Submit')); ?>
</div>
<div class="actions">
    <h3><?php echo __('Actions'); ?></h3>
    <ul>
        <li><?php echo $this->Form->postLink(__('Delete'), ['action' => 'delete', $this->Form->value('User.id')], ['confirm' => __('Are you sure you want to delete # %s?', $this->Form->value('User.id'))]); ?></li>
        <li><?php echo $this->Html->link(__('List Users'), ['action' => 'index']); ?></li>
    </ul>
</div>

<!-- Modal for changing password -->
<div class="modal fade" id="changePasswordModal" tabindex="-1" role="dialog" aria-labelledby="changePasswordModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="changePasswordModalLabel"><?php echo __('Change Password'); ?></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <?php echo $this->Form->create(null, ['url' => ['action' => 'changePassword', $this->Form->value('User.id')]]); ?>
                <?php
                    echo $this->Form->input('new_password', [
                        'label' => 'New Password', 
                        'type' => 'password', 
                        'required' => true, 
                        'class' => 'form-control'
                    ]);
                    echo $this->Form->input('confirm_password', [
                        'label' => 'Confirm Password', 
                        'type' => 'password', 
                        'required' => true, 
                        'class' => 'form-control'
                    ]);
                ?>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal"><?php echo __('Close'); ?></button>
                <?php echo $this->Form->button(__('Save changes'), ['class' => 'btn btn-primary']); ?>
                <?php echo $this->Form->end(); ?>
            </div>
        </div>
    </div>
</div>

<script>
    $(document).ready(function() {
        $("#UserBirthDate").datepicker({
            dateFormat: "yy-mm-dd", 
            maxDate: 0,
			changeMonth: true,
			changeYear: true,

        });
    });
</script>
