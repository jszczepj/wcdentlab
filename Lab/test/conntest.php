<!DOCTYPE html>
<html>
<body>
<?php
$servername = "localhost";
$username = "dentalimplantsmi_lab";
$password = "Lab2020lab05+";
$dbname = "dentalimplantsmi_dental";

// Create connection
$conn = mysqli_connect($servername, $username, $password, $dbname);
// Check connection
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

$sql = "SELECT USER_ID, USER_PWD, USER_ROLE FROM user_tbl";
$result = mysqli_query($conn, $sql);

if (mysqli_num_rows($result) > 0) {
    // output data of each row
    while($row = mysqli_fetch_assoc($result)) {
        echo "UserName: " . $row["USER_ID"]. " - UserPassword Role: " . $row["USER_PWD"]. " " . $row["USER_ROLE"]. "<br>";
    }
} else {
    echo "0 results";
}

mysqli_close($conn);
?>

</body>
</html>
