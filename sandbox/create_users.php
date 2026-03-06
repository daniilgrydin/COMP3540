<?php
$conn = mysqli_connect("localhost", "T00712793", "T00712793136", "C354_T00712793");
if (mysqli_connect_errno())
    echo "Failed to connect: " . mysqli_connect_error();
else {
    try {
        $sql = "CREATE TABLE Users(
    Id INT AUTO_INCREMENT PRIMARY KEY,
    Username VARCHAR(50) NOT NULL,
    Password VARCHAR(255) NOT NULL,
    Email VARCHAR(100) NOT NULL,
    DATE VARCHAR(8) NOT NULL
)";
        if (mysqli_query($conn, $sql))
            echo "Table Users created";
        else
            echo "Table Users not created";
    }
    catch(mysqli_sql_exception $e) {
        echo "Something wrong with the SQL statement? Aready created?";
    }
    mysqli_close($conn);
}