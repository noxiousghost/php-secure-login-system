let recaptcha_response = "";
function submitUserForm() {
  if (recaptcha_response.length == 0) {
    document.getElementById("h-captcha-error").innerHTML =
      '<span style="color:red;">This field is required.</span>';
    return false;
  }
  return true;
}

function verifyCaptcha(token) {
  recaptcha_response = token;
  document.getElementById("h-captcha-error").innerHTML = "";
}

function togglePasswordVisibility(fieldId) {
  let passwordField = document.getElementById(fieldId);
  let eyeIcon = document.getElementById(fieldId + "-eye");

  if (passwordField.type === "password") {
    passwordField.type = "text";
    eyeIcon.className = "far fa-eye-slash";
  } else {
    passwordField.type = "password";
    eyeIcon.className = "far fa-eye";
  }
}
