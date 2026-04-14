<?php
$conn = mysqli_connect("localhost", "T00712793", "T00712793136", "C354_T00712793");

function check_user($username) {  
    global $conn;
    $sql = "SELECT * FROM Users WHERE Username = '$username'";
    $result = mysqli_query($conn, $sql);
    return(mysqli_num_rows($result)>0);
}
    
// ---------------------------

$username = "jdoe";

$result = check_user($username);

if ($result)
    echo "The username exists.<br>";
else
    echo "The username does not exist.<br>";
?>
                            