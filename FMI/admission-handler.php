<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Collect and sanitize form data
    $firstName = isset($_POST['firstName']) ? htmlspecialchars($_POST['firstName']) : '';
    $lastName = isset($_POST['lastName']) ? htmlspecialchars($_POST['lastName']) : '';
    $email = isset($_POST['email']) ? htmlspecialchars($_POST['email']) : '';
    $confirmEmail = isset($_POST['confirmEmail']) ? htmlspecialchars($_POST['confirmEmail']) : '';
    $phone = isset($_POST['phone']) ? htmlspecialchars($_POST['phone']) : '';
    $dob = isset($_POST['dob']) ? htmlspecialchars($_POST['dob']) : '';
    $quarter = isset($_POST['quarter']) ? htmlspecialchars($_POST['quarter']) : '';
    $program = isset($_POST['program']) ? implode(", ", $_POST['program']) : ''; // Store multiple programs as a string

    // Address details
    $address = isset($_POST['address']) ? htmlspecialchars($_POST['address']) : '';
    $address2 = isset($_POST['address2']) ? htmlspecialchars($_POST['address2']) : '';
    $city = isset($_POST['city']) ? htmlspecialchars($_POST['city']) : '';
    $region = isset($_POST['region']) ? htmlspecialchars($_POST['region']) : '';
    $postalCode = isset($_POST['postalCode']) ? htmlspecialchars($_POST['postalCode']) : '';
    $country = isset($_POST['country']) ? htmlspecialchars($_POST['country']) : '';

    // Education background
    $highSchool = isset($_POST['highSchool']) ? htmlspecialchars($_POST['highSchool']) : '';
    $highSchoolAddress = isset($_POST['highSchoolAddress']) ? htmlspecialchars($_POST['highSchoolAddress']) : '';
    $college = isset($_POST['college']) ? htmlspecialchars($_POST['college']) : '';
    $degreeArea = isset($_POST['degreeArea']) ? htmlspecialchars($_POST['degreeArea']) : '';

    // Church details
    $churchAffiliation = isset($_POST['churchAffiliation']) ? htmlspecialchars($_POST['churchAffiliation']) : '';
    $churchName = isset($_POST['churchName']) ? htmlspecialchars($_POST['churchName']) : '';
    $churchActivities = isset($_POST['churchActivities']) ? htmlspecialchars($_POST['churchActivities']) : '';

    // Signature
    $signature = isset($_POST['signature']) ? $_POST['signature'] : '';

    // File upload handling
    $allowedCvTypes = ['application/pdf', 'application/msword', 'application/vnd.openxmlformats-officedocument.wordprocessingml.document'];
    $allowedPhotoTypes = ['image/jpeg', 'image/png'];

    $cvFilePath = "uploads/cv_" . uniqid() . "_" . basename($_FILES['cv']['name']);
    $passportFilePath = "uploads/passport_" . uniqid() . "_" . basename($_FILES['passportPhoto']['name']);

    $cvUploadSuccess = false;
    $passportUploadSuccess = false;

    // Validate CV file type
    if (in_array($_FILES['cv']['type'], $allowedCvTypes)) {
        $cvUploadSuccess = move_uploaded_file($_FILES['cv']['tmp_name'], $cvFilePath);
    } else {
        echo "<p>Error: Invalid CV file type. Please upload a PDF or Word document.</p>";
    }

    // Validate Passport Photo file type
    if (in_array($_FILES['passportPhoto']['type'], $allowedPhotoTypes)) {
        $passportUploadSuccess = move_uploaded_file($_FILES['passportPhoto']['tmp_name'], $passportFilePath);
    } else {
        echo "<p>Error: Invalid passport photo file type. Please upload a JPEG or PNG image.</p>";
    }

    // Proceed if both files uploaded successfully
    if ($cvUploadSuccess && $passportUploadSuccess) {
        // Here, you can save the data to your database or perform other processing
        echo "<p>Application submitted successfully!</p>";
    } else {
        echo "<p>There were errors with your application. Please try again.</p>";
    }
}
?>
