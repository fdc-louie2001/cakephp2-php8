<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Conversation</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/5.1.3/css/bootstrap.min.css">
    <style>
        body {
            background-color: #f8f9fa; /* Light background for contrast */
        }
        .container {
            margin-top: 20px;
            max-width: 600px; /* Limit the width of the chat */
            border-radius: 10px;
            overflow: hidden;
            background-color: white;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        }
        .message {
            padding: 10px;
            border-radius: 8px;
            margin-bottom: 10px;
            display: flex; /* Use flexbox for alignment */
            align-items: flex-start; /* Align items to the top */
        }
        .message.sent {
            background-color: #e1ffc7; /* Light green for sent messages */
            align-self: flex-end; /* Align to the right */
            justify-content: flex-end; /* Align to the right */
        }
        .message.received {
            background-color: #f1f1f1; /* Light gray for received messages */
            align-self: flex-start; /* Align to the left */
        }
        .avatar {
            width: 40px; /* Avatar width */
            height: 40px; /* Avatar height */
            border-radius: 50%; /* Circular avatar */
            margin-right: 10px; /* Space between avatar and text */
        }
        .message-time {
            font-size: 0.75rem;
            color: gray;
            margin-top: 5px; /* Space above time */
        }
        .messages {
            padding: 20px;
            max-height: 400px;
            overflow-y: auto; /* Enable vertical scrolling */
        }
        .input-area {
            padding: 10px;
            border-top: 1px solid #ddd;
            display: flex; /* Use flexbox for input area */
        }
        .input-area input {
            flex-grow: 1; /* Allow input to take up remaining space */
            margin-right: 10px; /* Space between input and button */
        }
    </style>
</head>
<body>
    <div class="container">
        <h2 class="text-center">Conversation with [User Name]</h2>
        <div class="messages d-flex flex-column">
            <div class="message sent">
                <div>
                    <p>Hello!</p>
                    <div class="message-time">12:01 PM</div>
                </div>
            </div>
            <div class="message received">
                <img src="https://via.placeholder.com/40" alt="User Avatar" class="avatar">
                <div>
                    <p>Hi there!</p>
                    <div class="message-time">12:02 PM</div>
                </div>
            </div>
            <div class="message sent">
                <div>
                    <p>How are you?</p>
                    <div class="message-time">12:03 PM</div>
                </div>
            </div>
            <div class="message received">
                <img src="https://via.placeholder.com/40" alt="User Avatar" class="avatar">
                <div>
                    <p>I'm good, thanks!</p>
                    <div class="message-time">12:04 PM</div>
                </div>
            </div>
            <!-- Add more messages as needed -->
        </div>
        <div class="input-area">
            <input type="text" class="form-control" placeholder="Type your message..." aria-label="Message">
            <button class="btn btn-primary">Send</button>
        </div>
    </div>
</body>
</html>
