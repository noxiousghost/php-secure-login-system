# Secure Login/Signup Prototype

This web application prototype illustrates the design of security systems and the application of programming principles to cybersecurity applications. Users can create an account, log in, and explore the basic functionalities of the system.

## Tech Stacks

- PHP
- HTML
- CSS
- JavaScript
- MySQL

## Instructions

Follow these steps to run the project successfully on your system:

1. If using XAMPP, copy the entire `php-secure-login-system` folder to `xampp/htdocs/`.

2. Import the database:

- Open phpMyAdmin in your web browser.
- Import the SQL file located in the `DB` directory (`php-secure-login-system/DB/users.sql`). No need to create database first

3. Make Changes in Code:

- Open the project in any code editor.
- In controller.php file, in line 24 remove Your_Hcaptcha_Secret_Key and enter your own Hcaptcha secret key
- In change_password.php file, reset_password.php and signup.php, remove Hcaptcha_Site_Key and enter your own Hcaptcha site key
- In send_email.php, enter your own gmail and its app password (Not gmail password).

3. Start your local server (XAMPP, MAMP, or any other PHP server).
4. Open your web browser and navigate to `http://127.0.0.1/php-secure-login-system/` to access the application.

- Note: If localhost/ is used instead of 127.0.0.1/ then h-captcha might not work

