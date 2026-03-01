<?php
if (!isset($display_modal_window)) $display_modal_window = 'none';
?>

<!DOCTYPE html>
<html>
<head>
<title>TRU CS Messenger</title>

<style>
:root {
    --navigation-width: 400px;
    --modal-width: 500px;
    --modal-height: 300px;
    --distance: 50px;
    font-family: 'Courier New', Courier, monospace;
}
#layout {
    position: relative;
    height: 100vh;
    width: 100vw;
}
#navigation {
    position: absolute;
    height: 100%;
    width: var(--navigation-width);
    background-color: Grey;
}
#content {
    position: absolute;
    left: var(--navigation-width);
    height: 100%;
    width: calc(100% - var(--navigation-width));
    background-color: skyblue;
}
#blanket {
    display: none;
    position: absolute;
    top: 0;
    background-color: Grey;
    opacity: 0.5;
    width: 100%;
    height: 100%;
    z-index: 998;
}
.modal {
    display: none;
    width: var(--modal-width);
    height: var(--modal-height);
    position: absolute;
    left: calc(50% - var(--modal-width) / 2);
    top: calc(50% - var(--modal-height) / 2);
    border: 1px solid black;
    background-color: White;
    z-index: 999;
}
button {
    width: calc(100% - 2 * var(--distance));
    margin-left: var(--distance);
    height: 60px;
}
h1 {
    width: calc(100% - 2 * var(--distance));
    padding-left: var(--distance);
    text-align: center;
}
img {
    padding-top: var(--distance);
    padding-left: var(--distance);
    width: calc(100% - 2 * var(--distance));
}
#content p {
    margin-top: 30%;
    font-size: 24pt;
    padding-left: var(--distance);
}
input[type="text"],
input[type="password"] {
    width: 50%;
    margin-left: 40px;
}
.modal-footer {
    position: absolute;
    bottom: 20px;
    width: 100%;
}
</style>
</head>

<body style="margin:0">

<div id="layout">

    <!-- Navigation -->
    <div id="navigation">
        <img src="TRU_Logo.png">
        <h1>Join TRU Messenger</h1>
        <button id="menuitem-login">Log In</button>
    </div>

    <!-- Content -->
    <div id="content">
        <p>
            See what's happening in the world<br>
            Hear what people are questioning about<br>
            Join the conversation
        </p>
    </div>

    <!-- Blanket -->
    <div id="blanket"></div>

    <!-- LOGIN MODAL -->
    <div id="box-login" class="modal">
        <h2 style="margin-left:40px;">Login to TRU Messenger</h2>

        <form method="post" action="controller.php">
            <input type="hidden" name="page" value="StartPage">
            <input type="hidden" name="command" value="SignIn">

            Username:
            <input type="text" name="username">
            <?php if (!empty($error_msg_username)) echo $error_msg_username; ?>
            <br><br>

            Password:
            <input type="password" name="password">
            <?php if (!empty($error_msg_password)) echo $error_msg_password; ?>

            <div class="modal-footer">
                <input type="button" value="Cancel" id="login-cancel-button">
                <input type="submit" value="Submit">
            </div>
        </form>
    </div>

</div>

<script>
let blanket = document.getElementById("blanket");
let login = document.getElementById("box-login");

function open_login() {
    blanket.style.display = "block";
    login.style.display = "block";
}

function close_all() {
    blanket.style.display = "none";
    login.style.display = "none";
}

document.getElementById("menuitem-login")
        .addEventListener("click", open_login);

document.getElementById("login-cancel-button")
        .addEventListener("click", close_all);

document.getElementById("blanket")
        .addEventListener("click", close_all);

<?php
if ($display_modal_window === 'signin') {
    echo "open_login();";
}
?>
</script>

</body>
</html>