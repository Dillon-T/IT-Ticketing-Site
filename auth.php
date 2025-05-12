<?php
// error_reporting(E_ALL);
// ini_set('display_errors', 1);
session_start();
// require_once('db_connect.php');
$servername = "localhost";
$username = "webapp";
$password = "mysql";
$dbname = "project";

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// form data
$username = $_POST['Username'];
$password = $_POST['Password'];

$stmt = $conn->prepare("SELECT UserID, Username, Password FROM Users WHERE Username = ?");
$stmt->bind_param("s", $username);
$stmt->execute();
$result = $stmt->get_result();
$user = $result->fetch_assoc();

if ($result->num_rows == 1 && password_verify($password, $user['Password'])) {
    $_SESSION['UserID'] = $user['UserID'];
    $_SESSION['Username'] = $user['Username'];
    header("Location: index.php");
    exit();
} else {
    // $_SESSION['login_error'] = "Invalid username or password";
    echo "<a href='adlogin.php'><button>Back to Login</button></a>";
    echo '<br>';
    echo "<strong>Invalid username or password</strong>";
    // echo "SELECT UserID, Username FROM Users WHERE Username = ? AND Password = ?";
    // echo $username . " " . $password;
    // <button= adlogin.php");
    exit();
}

$stmt->close();
$conn->close();
?>

    