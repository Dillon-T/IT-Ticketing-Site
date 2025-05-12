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
    <link rel="stylesheet" href="assets/styles.css">
<head>
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
            echo "<li><a href='view_mytickets.php'>View My Tickets</a></li>";
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
<div class="container">
        <h1>Hello Please Login</h1>
        <div class="login-form">
            <h2>Login</h2>
            <form action="auth.php" method="post">
                <input type="text" name="Username" placeholder="Username" required><br>
                <input type="password" name="Password" placeholder="Password" required><br>
                <input type="submit" value="Login">
            </form>
        </div>
    </div>
</body>
<footer>
    <p>&copy; 2024 Dillon's On-Demand Tech Support. All rights reserved.</p>
</footer>
</html>