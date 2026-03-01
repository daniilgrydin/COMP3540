<?php
?>

<!DOCTYPE html>

<html>
<head>
    <title>TRU CS Messenger</title>

    <style>
        /* Layout */
        
        #layout-navigation {
            position: absolute;
            top: 20px;
            left: 0;
            width:180px;
            text-align: right;
        }
        
        #layout-main {
            position: absolute;
            top: 20px;
            left: 220px;
            width: calc(100vw - 200px - 100px - 40px - 2px);
        }
        
        #vertical-line-0 {
            position: absolute;
            top: 0;
            left: 200px;
            border-left: 1px solid LightGray;
            height: 100vh;
        }
        
        #vertical-line-1 {
            position: absolute;
            top: 0;
            right: 100px;
            border-left: 1px solid LightGray;
            height: 100vh;
        }

        /* Navigation images */
        
        .nav-image {
            width:40px;
            height:40px;
            padding:5px;
        }
        .nav-image:hover {
            background-color: LightGray;
            cursor: pointer;
        }
        
    </style>
</head>

<body style='margin:0'>
    <div id='layout-navigation'>
        <img src='icons/TRU_Logo.png' width='150px' height='80px' >
        <br>
        <br>
        <img id='nav-search-friends' class='nav-image' title='Search a friend' src='icons/search.png' width='50px' height='50px' >
        <br>
        <img id='nav-send-message' class='nav-image' title='Send a message' src='icons/send.png'>
        <br>
        <img id='nav-read-messages' class='nav-image' title='Read messages' src='icons/email.png'>
        <br>
        <br>
        <img id='nav-logout' class='nav-image' title='Account' src='icons/human.png'></img>
        <form id='form-logout' method="POST" action="controller.php" style="display:none;">
            <input type='hidden' name='page' value='MainPage'>
            <input type='hidden' name='command' value='SignOut'>
        </form>
    </div>
    
    <div id="vertical-line-0"></div>
    
    <div id='layout-main'>
    </div>
    
    <div id="vertical-line-1"></div>
    
</body>
</html>

<script>
    document.getElementById('nav-logout').addEventListener('click', function() {
        document.getElementById('form-logout').submit();
    });
</script>
