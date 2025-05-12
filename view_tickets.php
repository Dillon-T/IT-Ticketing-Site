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
    <title>View Ticket</title>
</head>
<body>
    <h1>View Tickets</h1>
    <div class="ticket-container">
    <?php
    $servername = "localhost";
    $username = "webapp";
    $password = "mysql";
    $dbname = "project";
    
    $conn = new mysqli($servername, $username, $password, $dbname);
    
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }
    // Fetch and display ticket information
    $sql = "SELECT * FROM tickets";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        // Output data of each row
        while ($row = $result->fetch_assoc()) {
            echo '<div class="ticket">';
            echo "TicketID: " . $row["TicketID"] . "<br>";
            echo "Author: " . $row["Author"] . "<br>";
            echo "Tech: " . $row["Tech"] . "<br>";
            echo "Subject: " . $row["Subject"] . "<br>";
            echo "Body: " . $row["Body"] . "<br>";
            echo "Status: " . $row["Status"] . "<br>";
            echo "Creation Date: " . $row["CreationDate"] . "<br><br>";
            echo '</div>';
        }
    } else {
        echo "No tickets found";
    }

    // Close database connection
    $conn->close();
    ?>
    </div>
</body>
</html>
