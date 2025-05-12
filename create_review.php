<?php
require_once("db_connect.php");
try
{
  $pdo = new PDO($attr, $user, $password, $opts);
}
catch (PDOException $e)
{
  throw new PDOException($e->getMessage(), (int)$e->getCode());
}

session_start();


if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $reviewID = $_POST["ReviewID"];
    $ticketID = $_POST["TicketID"];
    $author = $_POST["Author"];
    $date = date('Y-m-d H:i:s');
    $comment = $_POST["Comment"];

    $sql = "INSERT INTO reviews (ReviewID, TicketID, Author, Date, Comment) VALUES (?, ?, ?, ?, ?)";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$reviewID, $ticketID, $author, $date, $comment]);

    $_SESSION['review_added'] = true;
    header("Location: reviews.php");

    // // echo "Review succesfully created!";
    // header("Location: reviews.php");
    // // echo "Review succesfully created!";
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add a Review</title>
</head>
<body>
    <h1>Add a Review!</h1>
    <form action= "create_review.php" method="post">
        <label for="ReviewID">ReviewID:</label><br>
        <input type="number" id="ReviewID" name="ReviewID" required><br>
        <label for="TicketID">TicketID:</label><br>
        <input type="text" id="TicketID" name="TicketID" required><br>
        <label for="Author">Author:</label><br>
        <input type="text" id="Author" name="Author" required><br>
        <label for="Comment">Comment:</label><br>
        <textarea id="Comment" name="Comment" rows="4" required></textarea><br>
        <input type="submit" value="Submit">
    </form>
</body>
</html>
