<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Database connection
    $db = new SQLite3('admission.db');

    // Collect form data
    $name = htmlspecialchars($_POST['name']);
    $email = htmlspecialchars($_POST['email']);
    $message = htmlspecialchars($_POST['message']);

    // Insert data into database
    $query = "INSERT INTO contact_submissions (name, email, message) VALUES (:name, :email, :message)";
    
    $stmt = $db->prepare($query);
    $stmt->bindValue(':name', $name, SQLITE3_TEXT);
    $stmt->bindValue(':email', $email, SQLITE3_TEXT);
    $stmt->bindValue(':message', $message, SQLITE3_TEXT);

    if ($stmt->execute()) {
        echo "<p>Message submitted successfully!</p>";
    } else {
        echo "<p>Error submitting the message.</p>";
    }

    // Close the database connection
    $db->close();
}
?>
