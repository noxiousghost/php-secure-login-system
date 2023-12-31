<?php require_once "controller.php"; ?>
<?php 
$email = $_SESSION['email'];
if($email == false){
  header('Location: login.php');
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Password Reset</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="./css/style.css">
    <script src="./js/pw.js"></script>
    <script src="https://kit.fontawesome.com/1c2c2462bf.js" crossorigin="anonymous"></script>
    <script src="https://js.hcaptcha.com/1/api.js" async defer></script>

</head>

<body>
    <div class="container">
        <div class="row">
            <div class="col-md-4 offset-md-4 form">
                <form action="reset_password.php" method="POST" autocomplete="off" onsubmit="return submitUserForm();">
                    <h2 class="text-center">Reset Password</h2>
                    <p class="text-center">Create a new password</p>
                    <?php 
                    if(isset($_SESSION['info'])){
                        ?>
                    <!-- <div class="alert alert-dark text-success text-center">
                        <?php echo $_SESSION['info']; ?>
                    </div> -->
                    <?php
                    }
                    ?>
                    <?php
                    if(count($errors) > 0){
                        ?>
                    <div class="alert alert-dark text-danger text-center">
                        <?php
                            foreach($errors as $showerror){
                                echo $showerror;
                            }
                            ?>
                    </div>
                    <?php
                    }
                    ?>


                    <div class="form-group">
                        <div>
                            <input id="password" class="form-control" type="password" name="password"
                                placeholder="Enter your password" required>
                            <span class="show-pass" onclick="togglePasswordVisibility('password','password-eye')">
                                <i id="password-eye" class="far fa-eye"></i>
                            </span>
                        </div>

                        <div id="popover-password">
                            <p><span id="result"></span></p>
                            <div class="progress">
                                <div id="password-strength" class="progress-bar" role="progressbar" aria-valuenow="40"
                                    aria-valuemin="0" aria-valuemax="100" style="width: 0%">
                                </div>
                            </div>
                            <span class="info-icon" id="showCriteriaBtn" onclick="toggleCriteria()">
                                <i class="fas fa-info-circle"></i>
                            </span>
                            <ul id="password-criteria-list" class="list-unstyled" style="display: none;">
                                <li class="">
                                    <span class="low-upper-case">
                                        <i class="fas fa-circle" aria-hidden="true"></i>
                                        &nbsp;Lowercase &amp; Uppercase
                                    </span>
                                </li>
                                <li class="">
                                    <span class="one-number">
                                        <i class="fas fa-circle" aria-hidden="true"></i>
                                        &nbsp;Number (0-9)
                                    </span>
                                </li>
                                <li class="">
                                    <span class="one-special-char">
                                        <i class="fas fa-circle" aria-hidden="true"></i>
                                        &nbsp;Special Characters
                                    </span>
                                </li>
                                <li class="">
                                    <span class="eight-character">
                                        <i class="fas fa-circle" aria-hidden="true"></i>
                                        &nbsp;Atleast 10 Characters
                                    </span>
                                </li>
                            </ul>
                        </div>
                    </div>


                    <div class="form-group">
                        <input id="cpassword" class="form-control" type="password" name="cpassword"
                            placeholder="Confirm password" required>
                        <span class="show-pass" onclick="togglePasswordVisibility('cpassword','cpassword-eye')">
                            <i id="cpassword-eye" class="far fa-eye"></i>
                        </span>
                    </div>

                    <div class="form-group">
                        <div class="h-captcha" data-sitekey="57487d02-b4b4-4736-a154-810cd3700def" data-theme="dark"
                            data-callback="verifyCaptcha">
                        </div>
                        <div id="captcha-error"></div>
                    </div>


                    <div class="form-group">
                        <input class="form-control button" type="submit" name="reset-password" value="Change">
                    </div>
                </form>
            </div>
        </div>
    </div>
    <script src="./js/main.js"></script>
</body>

</html>