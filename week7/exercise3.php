<?php
$conn = mysqli_connect("localhost", "T00712793", "T00712793136", "C354_T00712793");

function check_password($username, $password){
    global $conn;
    $sql = "SELECT Password FROM Users WHERE Username = '$username'";
    $result = $conn->query($sql);
    if($result->num_rows == 0) return false;
    $row = $result->fetch_assoc();
    $password_stored = $row['Password'];
    return($password_stored == $password);
}
    
// ---------------------------

$username = "jdoe";
$password = "secret";

$result = check_password($username, $password);

if ($result)
    echo "Valid<br>";
else
    echo "Invalid<br>";
?>      
                            