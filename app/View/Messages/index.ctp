
<?php echo $this->Html->css('message/style'); ?>

<!-- Navigation with Logout Button -->
<nav class="navbar navbar-expand-lg navbar-light bg-light">
    <a class="navbar-brand" href="#">Name</a>
    <form class="form-inline my-2 my-lg-0 ml-auto">
        <input class="form-control mr-sm-2" type="search" placeholder="Search messages" aria-label="Search">
        <button class="btn btn-outline-success my-2 my-sm-0" type="submit">Search</button>
    </form>
    <div class="logout-button ml-3">
        <?php echo $this->Html->link(
            __('Logout'), 
            ['controller' => 'users', 'action' => 'logout'], 
            ['class' => 'btn btn-danger']
        ); ?>
    </div>
</nav>

<!-- Main Content -->
<div class="container inbox">
    <div class="lead">
        <div class="messages-container">
            <img src="https://via.placeholder.com/50" alt="User Avatar" class="avatar">
            <div class="message-content">
                <div class="user-name">Name of the user</div>
                <div class="user-conversation">Lorem, ipsum dolor sit amet consectetur adipisicing elit. Beatae, minima modi temporibus sint quisquam quos. Quo et corrupti, corporis aliquam, cupiditate laborum sit itaque harum reiciendis reprehenderit accusantium quam exsdgsdgsdgsd.</div>
            </div>
            <div class="status-info">12:30 PM</div>
        </div>
        <!-- Repeat for more messages -->
        <div class="messages-container">
            <img src="https://via.placeholder.com/50" alt="User Avatar" class="avatar">
            <div class="message-content">
                <div class="user-name">Another</div>
                <div class="user-conversation">Lorem, ipsum dolor sit amet consectetur adipisicing elit. Beatae, minima modi temporibus sint quisquam quos. Quo et corrupti, corporis aliquam, cupiditate laborum sit itaque harum reiciendis reprehenderit accusantium quam exsdgsdgsdgsd.</div>
            </div>
            <div class="status-info">12:30 PM</div>
        </div>
        <div class="messages-container">
            <img src="https://via.placeholder.com/50" alt="User Avatar" class="avatar">
            <div class="message-content">
                <div class="user-name">Another</div>
                <div class="user-conversation">Lorem, ipsum dolor sit amet consectetur adipisicing elit. Beatae, minima modi temporibus sint quisquam quos. Quo et corrupti, corporis aliquam, cupiditate laborum sit itaque harum reiciendis reprehenderit accusantium quam exsdgsdgsdgsd.</div>
            </div>
            <div class="status-info">12:30 PM</div>
        </div>
        <div class="messages-container">
            <img src="https://via.placeholder.com/50" alt="User Avatar" class="avatar">
            <div class="message-content">
                <div class="user-name">Another</div>
                <div class="user-conversation">Lorem, ipsum dolor sit amet consectetur adipisicing elit. Beatae, minima modi temporibus sint quisquam quos. Quo et corrupti, corporis aliquam, cupiditate laborum sit itaque harum reiciendis reprehenderit accusantium quam exsdgsdgsdgsd.</div>
            </div>
            <div class="status-info">12:30 PM</div>
        </div>
        <div class="messages-container">
            <img src="https://via.placeholder.com/50" alt="User Avatar" class="avatar">
            <div class="message-content">
                <div class="user-name">Another</div>
                <div class="user-conversation">Lorem, ipsum dolor sit amet consectetur adipisicing elit. Beatae, minima modi temporibus sint quisquam quos. Quo et corrupti, corporis aliquam, cupiditate laborum sit itaque harum reiciendis reprehenderit accusantium quam exsdgsdgsdgsd.</div>
            </div>
            <div class="status-info">12:30 PM</div>
        </div>
        <div class="messages-container">
            <img src="https://via.placeholder.com/50" alt="User Avatar" class="avatar">
            <div class="message-content">
                <div class="user-name">Another</div>
                <div class="user-conversation">Lorem, ipsum dolor sit amet consectetur adipisicing elit. Beatae, minima modi temporibus sint quisquam quos. Quo et corrupti, corporis aliquam, cupiditate laborum sit itaque harum reiciendis reprehenderit accusantium quam exsdgsdgsdgsd.</div>
            </div>
            <div class="status-info">12:30 PM</div>
        </div>
        <div class="messages-container">
            <img src="https://via.placeholder.com/50" alt="User Avatar" class="avatar">
            <div class="message-content">
                <div class="user-name">Another</div>
                <div class="user-conversation">Lorem, ipsum dolor sit amet consectetur adipisicing elit. Beatae, minima modi temporibus sint quisquam quos. Quo et corrupti, corporis aliquam, cupiditate laborum sit itaque harum reiciendis reprehenderit accusantium quam exsdgsdgsdgsd.</div>
            </div>
            <div class="status-info">12:30 PM</div>
        </div>
        <div class="messages-container">
            <img src="https://via.placeholder.com/50" alt="User Avatar" class="avatar">
            <div class="message-content">
                <div class="user-name">Another</div>
                <div class="user-conversation">Lorem, ipsum dolor sit amet consectetur adipisicing elit. Beatae, minima modi temporibus sint quisquam quos. Quo et corrupti, corporis aliquam, cupiditate laborum sit itaque harum reiciendis reprehenderit accusantium quam exsdgsdgsdgsd.</div>
            </div>
            <div class="status-info">12:30 PM</div>
        </div>
        <div class="messages-container">
            <img src="https://via.placeholder.com/50" alt="User Avatar" class="avatar">
            <div class="message-content">
                <div class="user-name">Another</div>
                <div class="user-conversation">Lorem, ipsum dolor sit amet consectetur adipisicing elit. Beatae, minima modi temporibus sint quisquam quos. Quo et corrupti, corporis aliquam, cupiditate laborum sit itaque harum reiciendis reprehenderit accusantium quam exsdgsdgsdgsd.</div>
            </div>
            <div class="status-info">12:30 PM</div>
        </div>
        <div class="messages-container">
            <img src="https://via.placeholder.com/50" alt="User Avatar" class="avatar">
            <div class="message-content">
                <div class="user-name">Another</div>
                <div class="user-conversation">Lorem, ipsum dolor sit amet consectetur adipisicing elit. Beatae, minima modi temporibus sint quisquam quos. Quo et corrupti, corporis aliquam, cupiditate laborum sit itaque harum reiciendis reprehenderit accusantium quam exsdgsdgsdgsd.</div>
            </div>
            <div class="status-info">12:30 PM</div>
        </div>
    </div>
</div>