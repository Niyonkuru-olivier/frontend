<?php
// Start the session
session_start();

// Generate a random 6-digit OTP
$otp = rand(100000, 999999);

// Store the generated OTP in the session
$_SESSION['generatedOtp'] = $otp;

// Send the OTP to the user's email or phone (you would implement this part with a mail/SMS service)
// mail($email, "Your OTP Code", "Your OTP is: $otp");
// or send via SMS

echo "OTP has been sent to your registered email/phone.";
?>
