<!DOCTYPE html>
<html lang="en">
<head>
   
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add User</title>
    <style>
        body {
            background-color: #f8f9fa;
        }
        .form-container {
            max-width: 500px;
            margin: 50px auto;
            padding: 20px;
            background: white;
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        }
        .actions {
            margin-top: 20px;
        }
    </style>
</head>
<body>
<div class="form-container">
    <?php echo $this->Form->create('User'); ?>
    <fieldset>
        <legend><?php echo __('Add User'); ?></legend>
        <?php
            echo $this->Form->input('name', array('label' => 'Name', 'required' => true, 'class' => 'form-control'));
            echo $this->Form->input('email', array('label' => 'Email', 'required' => true, 'class' => 'form-control'));
            echo $this->Form->input('password', array('label' => 'Password', 'type' => 'password', 'required' => true, 'class' => 'form-control'));
            echo $this->Form->input('confirm_password', array('label' => 'Confirm Password', 'type' => 'password', 'required' => true, 'class' => 'form-control'));
        ?>
    </fieldset>
    
    <?php echo $this->Form->end('Register'); ?>
</div>

</body>
</html>
