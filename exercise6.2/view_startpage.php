<!DOCTYPE html>

<html>
<head>
    <title>TRU CS Messenger</title>
    <style>
        #layout-main {
            position:relative; top:0; left:0;
            width:100vw; height:100vh; 
        }
        #layout-main-left {
            position:absolute; top:0; left:0;
            width:50%; height:100%; 
            background-color:LightGray; 
        }
        #layout-main-right {
            position:absolute; 
            top:0; left:50%;
            width:50%; height:100%; 
            background-color:SkyBlue; 
        }
        .layout-content {
            width:80%;
            position:absolute;
            left:calc(50% - 40%);
        }
        
        .modal-window {
            width:400px; height:250px;
            border:1px solid black;
            display:none;
            background-color:White;
            position:fixed;
            top:calc(50vh - 125px); left:calc(50vw - 200px);
            z-index:999;
        }
        #blanket {
            display:none;
            width:100vw; height:100vh;
            position:fixed;
            top:0; left:0;
            z-index:998;
            opacity:0.5;
            background-color:Grey;
        }
        .modal-label-input {
            display:inline-block;
            width:100px;
            margin-left:20px;
        }
    </style>
</head>

<body style='margin:0'>

    <!-- Page Layout -->
    
    <div id='layout-main'>
        <div id='layout-main-left'>
            <div id='content-left' class='layout-content'>
                <h2>Hear what people are questioning about</h2>
                <h2>Join the conversation</h2>
                <br>
                <button id='menu-login' style='display:inline-block; width:100%; height:40px'>Login</button>
                <br>
                <br>
                <button id='menu-signup' style='display:inline-block; width:100%; height:40px'>Sign Up</button>
            </div>
        </div>
        <div id='layout-main-right'>
            <div id='content-right' class='layout-content'>
                <br>
                <img src='icons/TRU_Logo.png' width='200px' height='50px' style='margin-left:50px'>
                <br>
                <h1>See what's happening in the world</h1>
                <br>
                <h2>Join TRU Messenger</h2>
            </div>
        </div>
    </div>
    
    <script>
        let cleft = document.getElementById('content-left');
        cleft.style.top = (cleft.parentElement.offsetHeight - cleft.offsetHeight) / 2 + "px";
        window.addEventListener('resize', function() {
            let cleft = document.getElementById('content-left');
            cleft.style.top = (cleft.parentElement.offsetHeight - cleft.offsetHeight) / 2 + "px";
        });
        let cright = document.getElementById('content-right');
        cright.style.top = (cright.parentElement.offsetHeight - cright.offsetHeight) / 2 + "px";
        window.addEventListener('resize', function() {
            let cright = document.getElementById('content-right');
            cright.style.top = (cright.parentElement.offsetHeight - cright.offsetHeight) / 2 + "px";
        });
    </script>
    
    <!-- Modal Windows -->
    
    <div id='modal-login' class='modal-window'>
        <h2 style='text-align:center'>Login to TRU Messenger</h2>
        <br>
        <form method='post' action='controller.php'>
            <input type='hidden' name='page' value='StartPage'>
            <input type='hidden' name='command' value='SignIn'>
            <label class='modal-label-input' for='input-login-username'>Username:</label>
            <input id='input-login-username' type='text' name='username'>
            <br><br>
            <label class='modal-label-input' for='input-login-password'>Password:</label>
            <input id='input-login-password' type='password' name='password'>
            <br>
            <button id='submit-modal-login' type='submit' style='position:absolute; bottom:10px; left:20px'>Submit</button>
            <button id='cancel-modal-login' type='button' style='position:absolute; bottom:10px; right:20px'>Cancel</button>
        </form>
    </div>
    <div id='modal-signup' class='modal-window'>
        <h2 style='text-align:center'>Sign up to TRU Messenger</h2>
        <br>
        <form method='post' action='controller.php'>
            <input type='hidden' name='page' value='StartPage'>
            <input type='hidden' name='command' value='SignUp'>
            <label class='modal-label-input' for='input-signup-username'>Username:</label>
            <input id='input-signup-username' type='text' name='username'>
            <br><br>
            <label class='modal-label-input' for='input-signup-password'>Password:</label>
            <input id='input-signup-password' type='password' name='password'>
            <br><br>
            <label class='modal-label-input' for='input-signup-email'>Email:</label>
            <input id='input-signup-email' type='text' name='email'></br>
            <button id='submit-modal-signup' type='submit' style='position:absolute; bottom:10px; left:20px'>Submit</button>
            <button id='cancel-modal-signup' type='button' style='position:absolute; bottom:10px; right:20px'>Cancel</button>
        </form>
    </div>
    
    <div id='blanket'></div>
</body>
</html>

<script>
    document.getElementById("menu-login").addEventListener("click", function() {
        document.getElementById("blanket").style.display = "block";
        document.getElementById("modal-login").style.display = "block";
    });
    document.getElementById("cancel-modal-login").addEventListener("click", function() {
        document.getElementById("blanket").style.display = "none";
        document.getElementById("modal-login").style.display = "none";
    });

    document.getElementById("menu-signup").addEventListener("click", function() {
        document.getElementById("blanket").style.display = "block";
        document.getElementById("modal-signup").style.display = "block";
    });
    document.getElementById("cancel-modal-signup").addEventListener("click", function() {
        document.getElementById("blanket").style.display = "none";
        document.getElementById("modal-signup").style.display = "none";
    });

    document.getElementById("blanket").addEventListener("click", function() {
        document.getElementById("blanket").style.display = "none";
        document.getElementById("modal-login").style.display = "none";
        document.getElementById("modal-signup").style.display = "none";
    });
    
    function display_login_modal() {
        document.getElementById("blanket").style.display = "block";
        document.getElementById("modal-login").style.display = "block";
    }
    
    function display_signup_modal() {
        document.getElementById("blanket").style.display = "block";
        document.getElementById("modal-signup").style.display = "block";
    }
    
    function no_modal() {
        document.getElementById("blanket").style.display = "none";
        document.getElementById("modal-login").style.display = "none";
        document.getElementById("modal-signup").style.display = "none";
    }
    
</script>
