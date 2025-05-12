<?php
session_start();
$loggedIn = isset($_SESSION['UserID']);
$username = '';
if ($loggedIn) {
    $username = $_SESSION['Username'];
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="assets/styles.css">
    <nav>
        <ul>
            <li><a href="index.php">Home</a></li>
            <li><a href="reviews.php">Reviews</a></li>
            <li><a href="contact.php">Contact Us</a></li>
            <?php require_once("db_connect.php");
           try
           {
             $pdo = new PDO($attr, $user, $password, $opts);
           }
           catch (PDOException $e)
           {
             throw new PDOException($e->getMessage(), (int)$e->getCode());
           }
           
        $userId = $_SESSION['UserID'];
        $query = "SELECT Tech FROM Users WHERE UserID = ?";
        $stmt = $pdo->prepare($query);
        $stmt->execute([$userId]);
        $isTech = $stmt->fetchColumn();

        if ($isTech == 1) {
            echo "<li><a href='create_ticket.php'>Create Ticket</a></li>";
            echo "<li><a href='view_tickets.php'>View All Tickets</a></li>";
        }
           
           ?>
        <div class= "adlogin">
        <?php if ($loggedIn): ?>
            <li><a href="logout.php">Logout (<?= $username ?>)</a></li>
        <?php else: ?>
            <li><a href="adlogin.php">Login</a></li>
        <?php endif; ?>
        </div>
        </ul>
    </nav>
    <title>Create Ticket</title>
</head>
<body>
    <h1>Create Ticket</h1>
    <form action="create_ticket.php" method="post">
        <label for="Author">Author:</label><br>
        <input type="text" id="Author" name="Author" required><br>
        <label for="Tech">Tech:</label><br>
        <input type="text" id="Tech" name="Tech" required><br>
        <label for="Subject">Subject:</label><br>
        <input type="text" name="Subject" required><br>
        <label for="Body">Body:</label><br>
        <textarea id="Body" name="Body" rows="4" required></textarea><br>
        <label for="Status">Status:</label><br>
        <select id="Status" name="Status">
            <option value="New">New</option>
            <option value="In Progress">In Progress</option>
            <option value="Completed">Completed</option>
        </select><br>
        <input type="hidden" name="CreationDate" value="<?php echo date('Y-m-d H:i:s'); ?>">
        <input type="submit" value="Submit">
    </form>
</body>
</html>
<?php
$servername = "localhost";
$username = "webapp";
$password = "mysql";
$dbname = "project";

//  connection
$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

//  form data
if(isset($_POST['Status'])) {
    $author = $_POST['Author'];
    $tech = $_POST['Tech'];
    $subject = $_POST['Subject'];
    $body = $_POST['Body'];
    $status = $_POST['Status'];
    $creationdate = $_POST['CreationDate'];

    // insert cmds
    $sql = "INSERT INTO tickets (Author, Tech, Subject, Body, Status, CreationDate) VALUES ('$author', '$tech', '$subject', '$body', '$status', '$creationdate')";

    if ($conn->query($sql) === TRUE) {
        echo "New ticket created successfully";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }

    $conn->close();
}
?>
