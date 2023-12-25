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
