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
    <title>Dillon's On-Demand Tech Support</title>
</head>
<body>
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
           
        $isTech = 0;
        if(isset($_SESSION['UserID'])) {
            $userID = $_SESSION['UserID'];
            $query = "SELECT Tech FROM Users WHERE UserID = ?";
            $stmt = $pdo->prepare($query);
            $stmt->execute([$userID]);
            $isTech = $stmt->fetchColumn();
        }

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
    <h1>Reviews</h1>
    <a href="create_review.php"><button>Add Review</button></a>
    <?php
    if (isset($_SESSION['review_added'])) {
    echo "<p>Review added successfully!</p>";
    unset($_SESSION['review_added']);
}
?>


<?php
//connection 
$connection = mysqli_connect('localhost', 'webapp', 'mysql', 'project');

if (!$connection) {
    die("Connection failed: " . mysqli_connect_error());
}

// query from reviews
$sql = "SELECT * FROM reviews";
$result = mysqli_query($connection, $sql);

if (mysqli_num_rows($result) > 0) {
    // Output data of each row
    while ($row = mysqli_fetch_assoc($result)) {
        echo "<div class='review'>";
        echo "<h2>" . "ReviewID: " . $row['ReviewID'] . "</h2>";
        echo "<p>" . "TicketID: " . $row['TicketID'] . "</p>";
        echo "<p>" . "Author: " . $row['Author'] . "</p>";
        echo "<p>" . "Date: " . $row['Date'] . "</p>";
        echo "<p>" . $row['Comment'] . "</p>";
        echo "</div>";
    }
} else {
    echo "No reviews found";
}

// Close the connection
mysqli_close($connection);
?>
<footer>
    <p>&copy; 2024 IT Ticket Support System. All rights reserved.</p>
</footer>
</body>
</html>