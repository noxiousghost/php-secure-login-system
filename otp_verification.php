<?php require_once "controller.php"; ?>
<?php
$email = $_SESSION['email'];
if ($email == false) {
    header('Location: login.php');
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>OTP Verification</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="./css/style.css">
</head>

<body>
    <div class="container">
        <div class="row">
            <div class="col-md-4 offset-md-4 form">
                <form action="otp_verification.php" method="POST" autocomplete="off">
                    <h2 class="text-center">OTP Verification</h2>
                    <?php
                    if (isset($_SESSION['info'])) {
                    ?>
                    <div style="padding: 0.4rem 0.4rem">
                        <?php echo $_SESSION['info']; ?>
                    </div>
                    <?php
                    }
                    ?>
                    <?php
                    if (count($errors) > 0) {
                    ?>
                    <div class="alert alert-dark text-danger text-center">
                        <?php
                            foreach ($errors as $showerror) {
                                echo $showerror;
                            }
                            ?>
                    </div>
                    <?php
                    }
                    ?>
                    <div class="form-group">
                        <input class="form-control" type="number" name="otp" placeholder="Enter code" required>
                    </div>
                    <div class="form-group">
                        <input class="form-control button" type="submit" name="check-reset-otp" value="Submit">
                        <div class="link login-link text-center"><a href="otp_verification.php?resend_otp2=true">Resend
                                OTP</a>
                        </div>
                </form>
            </div>
        </div>
    </div>

</body>

</html>