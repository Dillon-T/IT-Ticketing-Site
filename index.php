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
    <h1>Dillon's On-Demand Tech Support</h1>
    <section class="description">
    <header>
        <h1>Welcome to our IT Ticket Support System</h1>
    </header>
        <p>Welcome to our IT Ticket Support System. We provide a platform for efficiently managing IT issues within your organization.</p>
        <p>With our system, you can easily report IT problems, track their status, and ensure timely resolution by our support team.</p>
        <p>Whether it's a software bug, hardware malfunction, or network issue, we've got you covered. Our goal is to provide you with reliable IT support to keep your business running smoothly.</p>
    </section>
    <section class="create">
        <h1>How to Create a Ticket</h1>
            <p>Please login to create a ticket and view your ticket or view and manage tickets as a techinician.<p>
    </section>
    <section class="about_us">
        <header>
            <h1>About Us</h1>
        </header>
        <p>Welcome to IT Ticket Support System! We are dedicated to providing efficient IT support solutions for businesses of all sizes. With years of experience in the industry, our team of expert technicians is committed to resolving your IT issues promptly and effectively.</p>
        <p>At IT Ticket Support System, we understand the importance of technology in today's business environment. That's why we strive to offer top-notch support services to ensure the smooth operation of your IT infrastructure. Whether it's troubleshooting software problems, fixing hardware issues, or optimizing network performance, we're here to help.</p>
        <p>Our mission is to deliver exceptional customer service and technical expertise to help you overcome any IT challenge. We believe in building long-term relationships with our clients by providing reliable solutions tailored to their unique needs.</p>
        <p>Thank you for choosing IT Ticket Support System for your IT support needs. We look forward to serving you!</p>
    </section>
    <footer>
        <p>&copy; 2024 Dillon's On-Demand Tech Support. All rights reserved.</p>
    </footer>
</body>
</html>
