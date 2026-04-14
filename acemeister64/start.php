<!doctype html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>AceMeister64</title>
    <link rel="icon" type="image/x-icon" href="meister.png">
    <link href="styles/style.css" rel="stylesheet" />
    <link href="styles/popups.css" rel="stylesheet" />
  </head>
  <body>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <div id="blanket"></div>
    <div class="popup" id="login">
      <form method="post" action="controller.php">
        <h2>Log in</h2>
        <input type="hidden" name="page" value="start" />
        <input type="hidden" name="command" value="login" />
        <input id="email" name="email" type="email" placeholder="Email" /> <br />
        <input id="password" name="password" type="password" placeholder="Password" /> <br />
        <?php if (!empty($error)) echo "<p style='color:red;'>$error</p>"; ?>
        <input type="submit" value="Log In" />
      </form>
    </div>
    <div class="popup" id="signup">
      <form method="post" action="controller.php">
        <h2>Sign up</h2>
        <input type="hidden" name="page" value="start" />
        <input type="hidden" name="command" value="signup" />
        <input id="email" name="email" type="email" placeholder="Email" /> <br />
        <input id="password" name="password" type="password" placeholder="Password" /> <br />
        <?php if (!empty($error)) echo "<p style='color:red;'>$error</p>"; ?>
        <input type="submit" value="Sign Up" />
      </form>
    </div>

    <div id="wrapper">
      <img src="/media/bauhaus-left.webp" id="bauhaus-left" />
      <div class="content">
        <img id="logo" src="media/logo.webp" />
        <div id="buttons">
          <button class="user-button" id="login-button">Log In</button>
          <button class="user-button" id="signup-button">Sign Up</button>
        </div>
      </div>
      <img src="/media/bauhaus-right.webp" id="bauhaus-right" />
    </div>
    <script>
      $("#login-button").click(function () {
        $("#login").show();
        $("#blanket").show();
      });
      $("#blanket").click(function () {
        $("#login").hide();
        $("#signup").hide();
        $("#blanket").hide();
      });
      $("#signup-button").click(function () {
        $("#signup").show();
        $("#blanket").show();
      });
    </script>
  </body>

</html>
