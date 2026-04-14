<?php
$conn = mysqli_connect("localhost", "T00712793", "T00712793136", "C354_T00712793");

function check_user($username) {  
    global $conn;
    $sql = "SELECT * FROM Users WHERE Username = '$username'";
    $result = mysqli_query($conn, $sql);
    return(mysqli_num_rows($result)>0);
}

function create_user($username, $password, $email){
    global $conn;
    if(check_user($username)) return false;
    $date = date("Y-m-d");
    $sql = "INSERT INTO Users (Username, Password, Email, Date) VALUES ('$username', '$password', '$email', '$date')";
    $result = mysqli_query($conn, $sql);
    return true;
}
    
// ---------------------------

$username = "jdoe";
$password = "wonderfulworld";
$email = "jdoe@tru.ca";

$result = create_user($username, $password, $email);

if ($result)
    echo "Succeeded<br>";
else
    echo "Failed<br>";
?>
                    
                            