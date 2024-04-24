<?php
session_start();
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

// Include the connection file
require_once("connection.php");
require 'PHPMailer/src/Exception.php';
require 'PHPMailer/src/PHPMailer.php';
require 'PHPMailer/src/SMTP.php';

$mail = new PHPMailer(true);

    //Server settings
    $mail->isSMTP();                                            // Send using SMTP
    $mail->Host       = 'smtp.gmail.com';                     // Set the SMTP server to send through
    $mail->SMTPAuth   = true;                                   // Enable SMTP authentication
    $mail->Username   = 'eernagasritha@gmail.com';                     // SMTP username
    $mail->Password   = 'fskvbdfskmblmgsp';                         // SMTP password
    $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;         // Enable TLS encryption; `PHPMailer::ENCRYPTION_SMTPS` encouraged
    $mail->Port       = 587;                                    // TCP port to connect to, use 465 for `PHPMailer::ENCRYPTION_SMTPS` above
    //Recipients
    $mail->setFrom('eernagasritha@gmail.com', 'Mailer');

// Function to generate OTP
function generateOTP() {
    return rand(100000, 999999);
}

// Function to send email
function sendOTP($email, $otp,$mail) {
    $mail->addAddress($email, 'Recipient');     
    $mail->isHTML(true);                                        // Set email format to HTML
    $mail->Subject = 'Subject';
    $mail->Body    = "Your OTP is: $otp";
    return $mail->send();
}

// Function to handle errors and return JSON response
function returnError($message) {
    $response = ["success" => false, "message" => $message];
    header('Content-Type: application/json');
    echo json_encode($response);
    exit(); // Stop further execution
}

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get the username and password from the form
    $email = $_POST["email"];
    $_SESSION["email"] = $email;
    // Prepare the SQL statement
    $otp = generateOTP();
    $current_date_time = date("Y-m-d H:i:s");
    
    // Check if the email already exists in the database
    $exists_query = "SELECT * FROM users WHERE email='$email'";
    $exists_result = $conn->query($exists_query);
    
    if (!$exists_result) {
        // Error in database query
        returnError("Database query error: " . $conn->error);
    }
    
    if ($exists_result->num_rows > 0) {
        // Email already exists, update OTP and timeValue
        $update_query = "UPDATE users SET otp='$otp', timeValue='$current_date_time' WHERE email='$email'";
        
        if ($conn->query($update_query) === TRUE) {
            // Update successful, send OTP via email
            if (sendOTP($email, $otp,$mail)) {
                $_SESSION["email"] = $email;
                $response = ["success" => true, "message" => "OTP sent successful"];
            } else {
                returnError("Error sending OTP");
            }
        } else {
            // Error updating record
            returnError("Error updating record: " . $conn->error);
        }
    } else {
        // Email does not exist, insert new record
        $insert_query = "INSERT INTO users (email, otp, timeValue) VALUES ('$email', '$otp', '$current_date_time')";
        
        if ($conn->query($insert_query) === TRUE) {
            // Insert successful, send OTP via email
            if (sendOTP($email, $otp,$mail)) {
                $_SESSION["email"] = $email;
                $response = ["success" => true, "message" => "New user registered"];
            } else {
                returnError("Error sending OTP");
            }
        } else {
            // Error inserting record
            returnError("Error inserting record: " . $conn->error);
        }
    }
    
    // Output the JSON response
    header('Content-Type: application/json');
    echo json_encode($response);
}
?>