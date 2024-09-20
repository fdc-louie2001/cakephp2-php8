<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
<div class="messages index">


<nav>
    Navigation Bar
</nav>

<!-- Your message content can go here -->
<p>Welcome to the messages page. Here you can view your messages.</p>

<!-- Logout button -->
<div class="logout-button">
    <?php echo $this->Html->link(
        __('Logout'), 
        array('controller' => 'users', 'action' => 'logout'), 
        array('class' => 'button')
    ); ?>
</div>
</div>
</body>
</html>