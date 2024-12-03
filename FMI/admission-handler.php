<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    try {
        // Establish a connection to SQLite database with absolute path
        $db = new SQLite3(__DIR__ . '/admission.db');

        // Collect form data with htmlspecialchars to avoid XSS attacks
        $firstName = htmlspecialchars($_POST['firstName']);
        $lastName = htmlspecialchars($_POST['lastName']);
        $email = htmlspecialchars($_POST['email']);
        $phone = htmlspecialchars($_POST['phone']);
        $dob = htmlspecialchars($_POST['dob']);
        $program = isset($_POST['program']) ? implode(", ", $_POST['program']) : "";
        $address = htmlspecialchars($_POST['address']);
        $address2 = htmlspecialchars($_POST['address2']);
        $city = htmlspecialchars($_POST['city']);
        $region = htmlspecialchars($_POST['region']);
        $postalCode = htmlspecialchars($_POST['postalCode']);
        $highSchool = htmlspecialchars($_POST['highSchool']);
        $highSchoolAddress = htmlspecialchars($_POST['highSchoolAddress']);
        $signature = $_POST['signature']; // Signature data

        // Handle file uploads
        $cvPath = "";
        $passportPath = "";

        if (isset($_FILES["cv"]) && $_FILES["cv"]["error"] == 0) {
            $cvPath = "uploads/" . basename($_FILES["cv"]["name"]);
            move_uploaded_file($_FILES["cv"]["tmp_name"], $cvPath);
        }

        if (isset($_FILES["passportPhoto"]) && $_FILES["passportPhoto"]["error"] == 0) {
            $passportPath = "uploads/" . basename($_FILES["passportPhoto"]["name"]);
            move_uploaded_file($_FILES["passportPhoto"]["tmp_name"], $passportPath);
        }

        // Prepare the SQL statement
        $query = "INSERT INTO student_applications (
            first_name, last_name, email, phone, dob, program, address, address2, city, region, postal_code, 
            high_school, high_school_address, signature, cv_file_path, passport_file_path
        ) VALUES (
            :firstName, :lastName, :email, :phone, :dob, :program, :address, :address2, :city, :region, :postalCode, 
            :highSchool, :highSchoolAddress, :signature, :cvPath, :passportPath
        )";

        // Bind values
        $stmt = $db->prepare($query);
        $stmt->bindValue(':firstName', $firstName, SQLITE3_TEXT);
        $stmt->bindValue(':lastName', $lastName, SQLITE3_TEXT);
        $stmt->bindValue(':email', $email, SQLITE3_TEXT);
        $stmt->bindValue(':phone', $phone, SQLITE3_TEXT);
        $stmt->bindValue(':dob', $dob, SQLITE3_TEXT);
        $stmt->bindValue(':program', $program, SQLITE3_TEXT);
        $stmt->bindValue(':address', $address, SQLITE3_TEXT);
        $stmt->bindValue(':address2', $address2, SQLITE3_TEXT);
        $stmt->bindValue(':city', $city, SQLITE3_TEXT);
        $stmt->bindValue(':region', $region, SQLITE3_TEXT);
        $stmt->bindValue(':postalCode', $postalCode, SQLITE3_TEXT);
        $stmt->bindValue(':highSchool', $highSchool, SQLITE3_TEXT);
        $stmt->bindValue(':highSchoolAddress', $highSchoolAddress, SQLITE3_TEXT);
        $stmt->bindValue(':signature', $signature, SQLITE3_TEXT);
        $stmt->bindValue(':cvPath', $cvPath, SQLITE3_TEXT);
        $stmt->bindValue(':passportPath', $passportPath, SQLITE3_TEXT);

        // Execute the query
        if ($stmt->execute()) {
            echo "<p>Application submitted successfully!</p>";
            echo '<script>
                setTimeout(function() {
                    window.location.href = "index.html"; // Replace "index.html" with your homepage URL
                }, 3000); // Redirect after 3 seconds
            </script>';
        } else {
            echo "<p>Error submitting the application.</p>";
            echo '<script>
                setTimeout(function() {
                    window.location.href = "index.html"; // Redirect to homepage even on error
                }, 5000); // Redirect after 5 seconds for errors
            </script>';
        }
        
        // Close the database connection
        $db->close();
    } catch (Exception $e) {
        echo "<p>Failed to submit application: " . $e->getMessage() . "</p>";
    }
}
?>
