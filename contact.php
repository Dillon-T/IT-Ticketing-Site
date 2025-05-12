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
    <title>Contact Us</title>
</head>
<body>
    <header>
        <h1>Contact Us</h1>
    </header>
    <section class="contact-info">
        <div class="contact-item">
            <h2>General Inquiries</h2>
            <p>Email: dillontalactac@gmail.com</p>
            <p>Phone: +1 301-885-8833</p>
        </div>
        <div class="contact-item">
            <h2>Technical Support</h2>
            <p>Email: dillontalactac@gmail.com</p>
            <p>Phone: +1 301-885-8833</p>
        </div>
    </section>
    <section class="map">
       <div class="maap">
        <h2>Our HQ</h2>
       <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d6010.505814715899!2d-73.80760424820889!3d41.12900465918325!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x89c2bf71fcf871b7%3A0x893de09727293d85!2sPace%20University!5e0!3m2!1sen!2sus!4v1715156748510!5m2!1sen!2sus" width="600" height="450" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
       </div>
    </section>

    <footer>
        <p>&copy; 2024 IT Ticket Support System. All rights reserved.</p>
    </footer>
</body>
</html>
