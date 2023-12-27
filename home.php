<?php require_once "controller.php"; ?>
<?php 
$email = $_SESSION['email'];
$password = $_SESSION['password'];
if($email != false && $password != false){
    $sql = "SELECT * FROM users WHERE email = '$email'";
    $run_Sql = mysqli_query($con, $sql);
    if($run_Sql){
        $fetch_info = mysqli_fetch_assoc($run_Sql);
        $status = $fetch_info['status'];
        $code = $fetch_info['code'];
        if($status == "verified"){
            if($code != 0){
                header('Location: otp_verification.php');
            }
        }else{
            header('Location: signup_otp.php');
        }
    }
}else{
    header('Location: login.php');
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title><?php echo $fetch_info['name'] ?> | Home</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="./css/home.css">
</head>

<body>
    <nav class="navbar">
        <a class="navbar-brand" href="#">Secure Login System</a>
        <div>
            <button type="button" class="btn btn-light" style="margin: 10px;"><a href="change_password.php">Change
                    Password</a></button>
            <button type="button" class="btn btn-light"><a href="logout.php">Logout</a></button>
        </div>

    </nav>
    <h1>Welcome <?php echo $fetch_info['name'] ?></h1>

</body>

</html>