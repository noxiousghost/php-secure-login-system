<?php require_once "controller.php"; ?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Signup</title>
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
                <form action="signup.php" method="POST" autocomplete="" onsubmit="return submitUserForm();">
                    <h2 class=" text-center">Signup</h2>
                    <p class="text-center">Create a new account.</p>
                    <?php
                    if(count($errors) == 1){
                        ?>
                    <div class="alert alert-dark text-danger text-center">
                        <?php
                            foreach($errors as $showerror){
                                echo $showerror;
                            }
                            ?>
                    </div>
                    <?php
                    }elseif(count($errors) > 1){
                        ?>
                    <div class="alert alert-dark text-danger text-center">
                        <?php
                            foreach($errors as $showerror){
                                ?>
                        <li><?php echo $showerror; ?></li>
                        <?php
                            }
                            ?>
                    </div>
                    <?php
                    }
                    ?>

                    <div class="form-group">
                        <input class="form-control" type="text" name="name" placeholder="Enter your full name" required
                            value="<?php echo $name ?>">
                    </div>
                    <div class="form-group">
                        <input class="form-control" type="email" name="email" placeholder="Enter your Email address"
                            required value="<?php echo $email ?>">
                    </div>


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
                    <div class="form-group terms-check">
                        <input type="checkbox" name="accept_terms" id="accept_terms" required>
                        <label for="accept_terms">I accept the&nbsp;<a class="terms-link" href="terms.html"
                                target="_blank"> Terms and Conditions</a></label>
                    </div>
                    <div class="form-group">
                        <div class="h-captcha" data-sitekey="57487d02-b4b4-4736-a154-810cd3700def" data-theme="dark"
                            data-callback="verifyCaptcha">
                        </div>
                        <div id="captcha-error"></div>
                    </div>
                    <div class="form-group">
                        <input class="form-control button" type="submit" name="signup" value="Signup">
                    </div>
                    <div class="link login-link text-center">Have an account? <a href="login.php">Login</a>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script src="./js/main.js"></script>

</body>

</html>