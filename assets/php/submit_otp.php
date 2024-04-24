<?php
session_start();
require_once("connection.php");
if ($_SERVER["REQUEST_METHOD"] == "POST") {
  

  $otp = "";
  // Concatenate the individual OTP input values
  $otp .= $_POST["otp1"];
  $otp .= $_POST["otp2"];
  $otp .= $_POST["otp3"];
  $otp .= $_POST["otp4"];
  $otp .= $_POST["otp5"];
  $otp .= $_POST["otp6"];
 

  $email = $_SESSION["email"];
  $userOtp = "SELECT * FROM users WHERE email = '$email'";
    $response = $conn->query($userOtp);
    
    if ($response) {
        $userData = $response->fetch_assoc();
        $correctOtp = $userData['otp'];
        $timeValue = new DateTime($userData['timeValue']); // Convert DATETIME to DateTime object

        $currentTime = new DateTime(); // Current DateTime object
        
        // Calculate the expiry time (current time + 60 seconds)
        $expiryTime = $timeValue->modify('+60 seconds');

        if ($currentTime > $expiryTime) {
            // OTP has expired
            echo "OTP expired";
        }else if ($otp != $correctOtp) {
          echo "Incorrect OTP";
        }
        else {
          echo "otp valid";
            // Check if email already exists in loggedin_users table
            $exists_query = "SELECT * FROM loggedin_users WHERE email='$email'";
            $exists_result = $conn->query($exists_query);
            if (!$exists_result) {
              // Error in database query
              echo ("Database query error: " . $conn->error);
          }
          
          if ($exists_result->num_rows == 0) {
              // Email does not exist in loggedin_users table, insert it
              $dateValue = date("Y-m-d H:i:s");
              $insert_query = "INSERT INTO loggedin_users (email, timeValue) VALUES ('$email', '$dateValue')";
              if (!$conn->query($insert_query)) {
                  // Error inserting record
                  echo ("Error inserting record into loggedin_users table: " . $conn->error);
              }
              else{
                // Success response
                echo "OTP verification successful";
                  // Rest of your code for handling the result of the query
                }
          }
          
        }
    } else {
        echo "Error executing query: " . $conn->error;
    }

}
?>