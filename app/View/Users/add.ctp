<?php echo $this->Html->css('user/style'); ?>
<div class="form-container">
    <?php echo $this->Form->create('User', ['id' => 'userForm']); ?>
    <fieldset>
        <legend><?php echo __('Add User'); ?></legend>
        <?php
            echo $this->Form->input('name', ['label' => 'Name', 'class' => 'form-control', 'id' => 'name']);
            echo '<div id="nameError" class="alert alert-danger" style="display: none;"></div>'; // Error message for name

            echo $this->Form->input('email', ['label' => 'Email', 'class' => 'form-control', 'id' => 'email']);
            echo '<div id="emailError" class="alert alert-danger" style="display: none;"></div>'; // Error message for email

            echo $this->Form->input('password', ['label' => 'Password', 'type' => 'password', 'class' => 'form-control', 'id' => 'password']);
            echo '<div id="passwordError" class="alert alert-danger" style="display: none;"></div>'; // Error message for password

            echo $this->Form->input('confirm_password', ['label' => 'Confirm Password', 'type' => 'password', 'class' => 'form-control', 'id' => 'confirm_password']);
            echo '<div id="confirmPasswordError" class="alert alert-danger" style="display: none;"></div>'; // Error message for confirm password
        ?>
    </fieldset>
    <?php echo $this->Form->button(__('Submit'), ['class' => 'btn btn-primary w-100']); ?>
    <?php echo $this->Form->end(); ?>
</div>


<script>
$(document).ready(function() {
    $('#userForm').on('submit', function(event) {
        event.preventDefault(); // Prevent form submission

        // Clear previous error messages
        $('.alert-danger').hide().empty(); // Hide all error messages

        let errors = [];

        // Validate Name
        const name = $('#name').val().trim();
        if (name === '') {
            $('#nameError').show().html('Name is required.');
            errors.push('Name is required.');
        }

        // Validate Email
        const email = $('#email').val().trim();
        if (email === '') {
            $('#emailError').show().html('Email is required.');
            errors.push('Email is required.');
        } else if (!validateEmail(email)) {
            $('#emailError').show().html('Please provide a valid email address.');
            errors.push('Please provide a valid email address.');
        }

        // Validate Password
        const password = $('#password').val().trim();
        if (password === '') {
            $('#passwordError').show().html('Password is required.');
            errors.push('Password is required.');
        }

        // Validate Confirm Password
        const confirmPassword = $('#confirm_password').val().trim();
        if (confirmPassword === '') {
            $('#confirmPasswordError').show().html('Confirm Password is required.');
            errors.push('Confirm Password is required.');
        } else if (confirmPassword !== password) {
            $('#confirmPasswordError').show().html('Passwords do not match.');
            errors.push('Passwords do not match.');
        }

        // If there are no errors, submit the form
        if (errors.length === 0) {
            this.submit();
        }
    });

    // Email validation function
    function validateEmail(email) {
        const regex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
        return regex.test(email);
    }
});
</script>
