<?php require_once "controller.php"; ?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Login</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <script src="https://kit.fontawesome.com/1c2c2462bf.js" crossorigin="anonymous"></script>
    <script src="./js/pw.js"></script>
    <link rel="stylesheet" href="./css/style.css">
</head>

<body>
    <div class="container">
        <div class="row">
            <div class="col-md-4 offset-md-4 form login-form">
                <form action="login.php" method="POST" autocomplete="">
                    <h2 class="text-center">Login</h2>
                    <p class="text-center">&nbsp;</p>
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
                        <input class="form-control" type="email" name="email" placeholder="Enter your Email address"
                            required value="<?php echo $email ?>">
                    </div>
                    <div class="form-group">
                        <input id="password" class="form-control" type="password" name="password"
                            placeholder="Enter your password" required>
                        <span class="show-pass" onclick="togglePasswordVisibility('password','password-eye')">
                            <i id="password-eye" class="far fa-eye"></i>
                        </span>
                    </div>
                    <div class="link forget-pass text-left"><a href="forgot_password.php">Forgot password?</a></div>
                    <div class="form-group">
                        <input class="form-control button" type="submit" name="login" value="Login">
                    </div>
                    <div class="link login-link text-center">Don't have an account? <a href="signup.php">Register</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</body>

</html>