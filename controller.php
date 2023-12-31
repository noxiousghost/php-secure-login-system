<?php 
session_start();
require "db_conn.php";
require "send_email.php";

$email = "";
$name = "";
$errors = array();

// Function to check password strength on the server side
function isValidPassword($password) {
return (strlen($password) >= 10 && preg_match("/[a-z]/", $password) && preg_match("/[A-Z]/",
$password) && preg_match("/[0-9]/", $password) && preg_match("/[!@#$%^&*(),.?_~]/", $password));
}

//Function for hcaptcha server side verification
// if you wish you can get your own h-captcha secret key and use
define('HCAPTCHA_SECRET_KEY', 'ES_25eb6b5bcf6b490aaa760bc8aa04a431');
function validateHcaptcha($hcaptchaResponse) {
    $hcaptchaUrl = "https://hcaptcha.com/siteverify";
    $hcaptchaData = array(
        'secret' => HCAPTCHA_SECRET_KEY,
        'response' => $hcaptchaResponse,
    );
    $hcaptchaOptions = array(
        'http' => array(
            'header' => "Content-type: application/x-www-form-urlencoded\r\n",
            'method' => 'POST',
            'content' => http_build_query($hcaptchaData),
        ),
    );
    $hcaptchaContext = stream_context_create($hcaptchaOptions);
    $hcaptchaResult = file_get_contents($hcaptchaUrl, false, $hcaptchaContext);
    $hcaptchaData = json_decode($hcaptchaResult, true);
    return $hcaptchaData['success'];
}

// signup
if(isset($_POST['signup'])){
$name = mysqli_real_escape_string($con, $_POST['name']);
$email = mysqli_real_escape_string($con, $_POST['email']);
$password = mysqli_real_escape_string($con, $_POST['password']);
$cpassword = mysqli_real_escape_string($con, $_POST['cpassword']);
// Validate hCaptcha response
$hcaptchaResponse = $_POST['h-captcha-response'];
if (!validateHcaptcha($hcaptchaResponse)) {
    $errors['hcaptcha'] = "hCaptcha verification failed.";
}
// checks for password and confirm password
if($password !== $cpassword){
$errors['password'] = "Passwords do not match";
}
// Server-side password strength check
if (!isValidPassword($password)) {
$errors['password'] = "Password does not meet the required strength criteria.";
}
//check for exiting email
$email_check = "SELECT * FROM users WHERE email = '$email'";
$res = mysqli_query($con, $email_check);
if(mysqli_num_rows($res) > 0){
$errors['email'] = "Email is already used";
}
if(count($errors) === 0){
$encpass = password_hash($password, PASSWORD_BCRYPT);
$code = rand(999999, 111111);
$status = "notverified";
$insert_data = "INSERT INTO users (name, email, password, code, status)
values('$name', '$email', '$encpass', '$code', '$status')";
$data_check = mysqli_query($con, $insert_data);

if($data_check){
$subject = "OTP verification";
$message = "Please use this code to verify: $code";

// Call the sendMail function from mailer.php
$result = sendMail($email, $subject, $message);

if ($result === true) {
$info = "Verification code is sent to your email - $email";
$_SESSION['info'] = $info;
$_SESSION['email'] = $email;
$_SESSION['password'] = $password;
header('location: signup_otp.php');
exit();
} else {
$errors['otp-error'] = $result;
}
} else {
$errors['db-error'] = "Database Error";
}

}
}

// verification code submit
if(isset($_POST['check'])){
$_SESSION['info'] = "";
$otp_code = mysqli_real_escape_string($con, $_POST['otp']);
$check_code = "SELECT * FROM users WHERE code = $otp_code";
$code_res = mysqli_query($con, $check_code);
if(mysqli_num_rows($code_res) > 0){
$fetch_data = mysqli_fetch_assoc($code_res);
$fetch_code = $fetch_data['code'];
$email = $fetch_data['email'];
$code = 0;
$status = 'verified';
$update_otp = "UPDATE users SET code = $code, status = '$status' WHERE code = $fetch_code";
$update_res = mysqli_query($con, $update_otp);
if($update_res){
$_SESSION['name'] = $name;
$_SESSION['email'] = $email;
header('location: home.php');
exit();
}else{
$errors['otp-error'] = "OTP update failed";
}
}else{
$errors['otp-error'] = "Invalid OTP!";
}
}

// login
if(isset($_POST['login'])){
$email = mysqli_real_escape_string($con, $_POST['email']);
$password = mysqli_real_escape_string($con, $_POST['password']);
$check_email = "SELECT * FROM users WHERE email = '$email'";
$res = mysqli_query($con, $check_email);
if(mysqli_num_rows($res) > 0){
$fetch = mysqli_fetch_assoc($res);
$fetch_pass = $fetch['password'];
if(password_verify($password, $fetch_pass)){
$_SESSION['email'] = $email;
$status = $fetch['status'];
if($status == 'verified'){
$_SESSION['email'] = $email;
$_SESSION['password'] = $password;
header('location: home.php');
}else{
$info = "Please verify your email address before logging in";
$_SESSION['info'] = $info;
header('location: signup_otp.php');
}
}else{
$errors['email'] = "Incorrect email or password!";
}
}else{
$errors['email'] = "Account not found! Please signup first.";
}
}

//forgot password
if(isset($_POST['check-email'])){
$email = mysqli_real_escape_string($con, $_POST['email']);
$check_email = "SELECT * FROM users WHERE email='$email'";
$run_sql = mysqli_query($con, $check_email);

if(mysqli_num_rows($run_sql) > 0){
$code = rand(999999, 111111);
$insert_code = "UPDATE users SET code = $code WHERE email = '$email'";
$run_query = mysqli_query($con, $insert_code);

if($run_query){
$subject = "OTP verification";
$message = "Please use this code to verify: $code";

// calling sendMail main function from send_email.php file
// to send otp to the desitnation email address
$result = sendMail($email, $subject, $message);

if ($result === true) {
$info = "We've sent a password reset OTP to your email - $email";
$_SESSION['info'] = $info;
$_SESSION['email'] = $email;
header('location: otp_verification.php');
exit();
} else {
$errors['otp-error'] = $result;
}
} else {
$errors['db-error'] = "Database Error";
}
} else {
$errors['email'] = "This email address does not exist!";
}
}

// reset otp
if(isset($_POST['check-reset-otp'])){
$_SESSION['info'] = "";
$otp_code = mysqli_real_escape_string($con, $_POST['otp']);
$check_code = "SELECT * FROM users WHERE code = $otp_code";
$code_res = mysqli_query($con, $check_code);
if(mysqli_num_rows($code_res) > 0){
$fetch_data = mysqli_fetch_assoc($code_res);
$email = $fetch_data['email'];
$_SESSION['email'] = $email;
$info = "Enter a new Password";
$_SESSION['info'] = $info;
header('location: reset_password.php');
exit();
}else{
$errors['otp-error'] = "Invalid OTP";
}
}

// reset password
if (isset($_POST['reset-password'])) {
$_SESSION['info'] = "";
$password = mysqli_real_escape_string($con, $_POST['password']);
$cpassword = mysqli_real_escape_string($con, $_POST['cpassword']);
// Validate hCaptcha response
$hcaptchaResponse = $_POST['h-captcha-response'];
if (!validateHcaptcha($hcaptchaResponse)) {
    $errors['hcaptcha'] = "hCaptcha verification failed.";
}
// Check if passwords match
if ($password !== $cpassword) {
$errors['password'] = "Passwords do not match";
} elseif (!isValidPassword($password)) {
$errors['password'] = "Password does not meet the required strength criteria.";
} else {
$email = $_SESSION['email'];
// Get the current hashed password from the database
$get_current_pass = "SELECT password FROM users WHERE email = '$email'";
$result = mysqli_query($con, $get_current_pass);

if ($result) {
$row = mysqli_fetch_assoc($result);
$current_password_hash = $row['password'];

// Verify if the entered password is different from the current one
if (password_verify($password, $current_password_hash)) {
$errors['password'] = "New password cannot be the same as the previous one.";
} else {
$code = 0;
$encpass = password_hash($password, PASSWORD_BCRYPT);
$update_pass = "UPDATE users SET code = $code, password = '$encpass' WHERE email = '$email'";
$run_query = mysqli_query($con, $update_pass);

if ($run_query) {
$info = "Your password has been changed successfully!";
$_SESSION['info'] = $info;
header('Location: pw_changed.php');
} else {
$errors['db-error'] = "Failed to change your password!";
}
}
} else {
$errors['db-error'] = "Error fetching current password.";
}
}
}


// change password
if (isset($_POST['change-password'])) {
$_SESSION['info'] = "";
$crpassword = mysqli_real_escape_string($con, $_POST['crpassword']);
$password = mysqli_real_escape_string($con, $_POST['password']);
$cpassword = mysqli_real_escape_string($con, $_POST['cpassword']);

// Check if current password is correct
$email = $_SESSION['email'];
$get_current_pass = "SELECT password FROM users WHERE email = '$email'";
$result = mysqli_query($con, $get_current_pass);

if ($result) {
$row = mysqli_fetch_assoc($result);

if (!$row) {
$errors['db-error'] = "No matching user found for the provided email.";
} else {
$current_password_hash = $row['password'];
// Validate hCaptcha response
$hcaptchaResponse = $_POST['h-captcha-response'];
if (!validateHcaptcha($hcaptchaResponse)) {
    $errors['hcaptcha'] = "hCaptcha verification failed.";
}
// Verify if the entered current password is correct
if (!password_verify($crpassword, $current_password_hash)) {
$errors['crpassword'] = "Incorrect current password.";
} else {
// Check if new passwords match and meet strength criteria
if ($password !== $cpassword) {
$errors['password'] = "Passwords do not match";
} elseif (!isValidPassword($password)) {
$errors['password'] = "Password does not meet the required strength criteria.";
} else {
// Verify if the entered password is different from the current one
if (password_verify($password, $current_password_hash)) {
$errors['password'] = "New password cannot be the same as the previous one.";
} else {
$code = 0;
$encpass = password_hash($password, PASSWORD_BCRYPT);
$update_pass = "UPDATE users SET code = $code, password = '$encpass' WHERE email = '$email'";
$run_query = mysqli_query($con, $update_pass);

if ($run_query) {
$info = "Your password has been changed successfully!";
$_SESSION['info'] = $info;
header('Location: pw_changed.php');
} else {
$errors['db-error'] = "Failed to change your password!";
}
}
}
}
}
} else {
$errors['db-error'] = "Error fetching current password: " . mysqli_error($con);
}
}

//if login now button click
if(isset($_POST['login-now'])){
// Logout user
session_destroy();
header('Location: login.php');
}
?>