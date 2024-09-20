<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add User</title>
    <?php echo $this->Html->css('user/style'); ?>
</head>
<body>
<div class="form-container">
    <?php echo $this->Form->create('User'); ?>
    <fieldset>
        <legend><?php echo __('Add User'); ?></legend>
        <?php
            echo $this->Form->input('name', ['label' => 'Name', 'required' => true, 'class' => 'form-control']);
            echo $this->Form->input('email', ['label' => 'Email', 'required' => true, 'class' => 'form-control']);
            echo $this->Form->input('password', ['label' => 'Password', 'type' => 'password', 'required' => true, 'class' => 'form-control']);
            echo $this->Form->input('confirm_password', ['label' => 'Confirm Password', 'type' => 'password', 'required' => true, 'class' => 'form-control']);
        ?>
    </fieldset>
    <?php echo $this->Form->button(__('Submit'), ['class' => 'btn btn-primary w-100']); ?>
    <?php echo $this->Form->end(); ?>
</div>
</body>
</html>
