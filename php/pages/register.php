<?php

if (!defined('GUARD')) {
  http_response_code(404);
  exit;
}
?>

<h1>Register</h1>
<form id="registerForm">
  <div id="usernameInput">
    <label for="username">Username</label>
    <input type="text" name="username" id="username" required>
  </div>
  <div id="emailInput">
    <label for="email">Email</label>
    <input type="email" name="email" id="email" required>
  </div>
  <div id="passwordInput">
    <label for="password">Password</label>
    <input type="password" name="password" id="password" required>
  </div>
  <div id="password_confirmationInput">
    <label for="password_confirmation">Password Confirmation</label>
    <input type="password" name="password_confirmation" id="password_confirmation" required>
  </div>
  <div id="phone_numberInput">
    <label for="phone_number">Phone</label>
    <input type="tel" name="phone_number" id="phone_number" required>
  </div>
  <div id="birthdateInput">
    <label for="birthdate">Birthday</label>
    <input type="date" name="birthdate" id="birthdate" required>
  </div>
  <div id="urlInput">
    <label for="url">URL</label>
    <input type="url" name="url" id="url" required>
  </div>
  <div>
    <button type="submit">Register</button>
  </div>
</form>

<script>
  const registerForm = document.getElementById('registerForm');
  registerForm.addEventListener('submit', async (e) => {
    e.preventDefault();
    const formData = new FormData(registerForm);
    const response = await fetch('api/register', {
      method: 'POST',
      body: formData
    });
    const data = await response.json();
    if (data.success) {
      window.location.href = 'index.php?page=login';
    } else {
      const responseErrors = data.errors;
      Object.keys(responseErrors).forEach((key) => {
        const error = responseErrors[key];
        const input = document.getElementById(key);
        input.classList.add('error');
        const errorElement = document.querySelector(`#${key}Input .error-message`) ?? document.createElement('div');
        errorElement.classList.add('error-message');
        errorElement.innerText = error;
        input.parentElement.appendChild(errorElement);
      });
    }
  });
</script>