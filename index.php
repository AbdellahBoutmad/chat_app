<?php
session_start();

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['username'])) {
    $_SESSION['username'] = $_POST['username'];
    header("Location: index.php");
    exit();
}

if (!isset($_SESSION['username'])) {
    ?>
    <!DOCTYPE html>
    <html>
    <head>
        <title>Chat Application</title>
    </head>
    <body>
        <form me thod="post" action="">
            <input type="text" name="username" placeholder="Enter your username" required>
            <button type="submit">Join Chat</button>
        </form>
    </body>
    </html>
    <?php
    exit();
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Chat Application</title>
    <style>
        #chatbox {
            border: 1px solid #000;
            height: 200px;
            overflow-y: scroll;
        }
    </style>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        function loadMessages() {
            $.ajax({
                url: 'load_messages.php',
                method: 'GET',
                success: function(data) {
                    $('#chatbox').html(data);
                }
            });
        }

        $(document).ready(function() {
            loadMessages();
            setInterval(loadMessages, 1000);

            $('#send').click(function() {
                var message = $('#message').val();
                $.ajax({
                    url: 'send_message.php',
                    method: 'POST',
                    data: {message: message},
                    success: function() {
                        $('#message').val('');
                        loadMessages();
                    }
                });
            });
        });
    </script>
</head>
<body>
    <div id="chatbox"></div>
    <input type="text" id="message">
    <button id="send">Send</button>
</body>
</html>
