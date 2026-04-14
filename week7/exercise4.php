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

function delete_user($username, $password){
    global $conn;
    if(!check_password($username, $password)) return false;
    $sql = "DELETE from Users WHERE Username = '$username'";
    mysqli_query($conn, $sql);
    return true;
}
    
// ---------------------------

$username = "jdoe";
$password = "wonderfulworld";

$result = delete_user($username, $password);

if ($result)
    echo "Deleted<br>";
else
    echo "Not deleted<br>";
?>
                           