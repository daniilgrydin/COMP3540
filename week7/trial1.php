<?php
    $name = "user";
    $value = "John Doe";
    if(!isset($_COOKIE[$name])) {
        echo "Cookie named '" . $name . "' is not set!<br>";
        echo "Let's set a cookie!<br>";
        setcookie($name, $value, time() + 24*60*60); // Expiration after 1 day
        echo "Submit the above code again to see if the cookie is set.";
    } else {
        echo "Cookie '" . $name . "' is set!<br>";
        echo "Value is: " . $_COOKIE[$name] . '<br>';
        echo "Let's delete the cookie!<br>";
        setcookie($name, $value, time() - 10); // past time
        echo "Submit the above code again to see if the cookie is deleted.";
    }
?>
                        