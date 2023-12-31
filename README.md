# Advanced Cybersecurity Assignment - Secure Login/Signup Prototype

This web application prototype illustrates the design of security systems and the application of programming principles to cybersecurity applications. Users can create an account, log in, and explore the basic functionalities of the system.

## Tech Stacks

- PHP
- HTML
- CSS
- JavaScript
- MySQL

## Project File Structure

Narayan_login/
│
├── css/
│ ├── style.css
│ └── home.css
│ └── terms.css
│
├── js/
│ ├── main.js
│ ├── pw.js
│
│
├── DB/
│ └── narayan_user.sql
│
├── PHPMailer/src/
│ └── ... (PHPMailer library files)
│
├── All other PHP files and one html file

## Instructions

Follow these steps to run the project successfully on your system:

1. If using XAMPP, copy the entire `Narayan_login` folder to `xampp/htdocs/`.

2. Import the database:

- Open phpMyAdmin in your web browser.
- Import the SQL file located in the `DB` directory (`Narayan_login/DB/narayan_user.sql`). No need to create database first

3. Start your local server (XAMPP, MAMP, or any other PHP server).
4. Open your web browser and navigate to `http://localhost/Narayan_login/` to access the application.

## Important Notice

**Disclaimer:**

- I understand that storing sensitive information in the source code is a major security vulnerability.
- For the simplicity of the grader while grading this assignment, I have included my mail and app password as well as the h-captcha site key and secret key in the source code.
- You are expetected to receive email from sapkota.king@gmail.com for getting OTP code while signing up and changing passwords.
- If you wish, in send_email.php file, replace username and password with your own.
