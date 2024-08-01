<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Login - Perpustakaan</title>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
  <style>
         body {
            font-family: Arial, sans-serif;
            background-image: url('uploads/user_background.jpeg');
            background-size: cover;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }
    .container {
      background-color: rgba(255, 255, 255, 0.8); /* Tambahkan opacity pada latar belakang */
      padding: 20px;
      border-radius: 10px;
      box-shadow: 0 0 20px rgba(0, 0, 0, 0.2);
      width: 300px;
      text-align: center;
    }
    .form-group {
      margin-bottom: 20px;
      text-align: left;
    }
    .form-group label {
      display: flex;
      align-items: center;
      margin-bottom: 5px;
      font-weight: bold;
    }
    .form-group label i {
      margin-right: 8px;
      color: #333;
    }
    .form-group input {
      width: calc(100% - 22px);
      padding: 10px;
      border: none;
      border-radius: 5px;
      background-color: #f9f9f9;
      margin-top: 5px;
      margin-bottom: 10px;
      box-shadow: 0 0 5px rgba(0, 0, 0, 0.1);
    }
    .password-toggle {
      position: relative;
    }
    .password-toggle .toggle-password {
      position: absolute;
      top: 50%;
      right: 10px;
      transform: translateY(-50%);
      cursor: pointer;
      font-size: 24px;
      color: #ccc;
    }
    .password-toggle .toggle-password:hover {
      color: #333;
    }
    .btn {
      display: inline-block;
      background-color: #007bff;
      color: #fff;
      padding: 10px 20px;
      border: none;
      border-radius: 5px;
      cursor: pointer;
      transition: background-color 0.3s;
    }
    .btn:hover {
      background-color: #0056b3;
    }
    h2 {
      margin-bottom: 20px;
      color: #333;
    }
    .login-image {
      width: 100px;
      height: 100px;
      margin-bottom: 0px;
    }
    .toast {
      visibility: hidden;
      min-width: 250px;
      margin-left: -125px;
      background-color: #333;
      color: #fff;
      text-align: center;
      border-radius: 2px;
      padding: 16px;
      position: fixed;
      z-index: 1;
      left: 50%;
      bottom: 30px;
      font-size: 17px;
    }
    .toast.show {
      visibility: visible;
      -webkit-animation: fadein 0.5s, fadeout 0.5s 2.5s;
      animation: fadein 0.5s, fadeout 0.5s 2.5s;
    }
    @-webkit-keyframes fadein {
      from {bottom: 0; opacity: 0;}
      to {bottom: 30px; opacity: 1;}
    }
    @keyframes fadein {
      from {bottom: 0; opacity: 0;}
      to {bottom: 30px; opacity: 1;}
    }
    @-webkit-keyframes fadeout {
      from {bottom: 30px; opacity: 1;}
      to {bottom: 0; opacity: 0;}
    }
    @keyframes fadeout {
      from {bottom: 30px; opacity: 1;}
      to {bottom: 0; opacity: 0;}
    }
  </style>
</head>
<body>
  <div class="container">
    <img src="ba.png" alt="Library Logo" class="login-image"> <!-- Ganti 'login-image.jpg' dengan URL gambar yang sesuai -->
    <h2>PERPUSTAKAAN UNIVERSITAS HASANUDDIN</h2>
    <form action="login_process.php" method="post" onsubmit="return validateForm()">
      <div class="form-group">
        <label for="username"><i class="fas fa-user"></i> Username:</label>
        <input type="text" id="username" name="username" required>
      </div>
      <div class="form-group password-toggle">
        <label for="password"><i class="fas fa-lock"></i> Password:</label>
        <input type="password" id="password" name="password" required>
        <span class="toggle-password">&#x1F441;</span>
      </div>
      <button type="submit" class="btn">Login</button>
    </form>
    <?php
      // Jika pengguna belum memiliki akun, tampilkan tautan ke halaman pendaftaran
      echo "<p>Don't have an account? <a href='register.php'>Register here</a>.</p>";
      // Tampilkan tautan ke halaman login admin
      echo "<p>Admin? <a href='admin_login.php'>Login here</a>.</p>";
    ?>
    <div id="toast" class="toast">Incorrect username or password.</div>
  </div>
  <script>
    function validateForm() {
      var username = document.getElementById("username").value;
      var password = document.getElementById("password").value;

      // Cek jika username mengandung spasi
      if (/\s/.test(username)) {
        showToast("Username tidak boleh mengandung spasi.");
        return false; // Prevent form submission
      }

      var hasLetter = /[a-zA-Z]/.test(password);
      var hasDigit = /\d/.test(password);
      if (!hasLetter || !hasDigit) {
        showToast("Password harus terdiri dari huruf dan angka.");
        return false; // Prevent form submission
      }

      return true; // Allow form submission
    }

    function togglePassword() {
      var passwordField = document.getElementById("password");
      if (passwordField.type === "password") {
        passwordField.type = "text";
        document.querySelector(".toggle-password").innerHTML = "&#x1F440;";
      } else {
        passwordField.type = "password";
        document.querySelector(".toggle-password").innerHTML = "&#x1F441;";
      }
    }

    document.querySelector(".toggle-password").addEventListener("click", togglePassword);

    function showToast(message) {
      var toast = document.getElementById("toast");
      toast.textContent = message;
      toast.className = "toast show";
      setTimeout(function() { toast.className = toast.className.replace("show", ""); }, 3000);
    }

    window.onload = function() {
      const urlParams = new URLSearchParams(window.location.search);
      const error = urlParams.get('error');
      if (error) {
          if (error == '1') {
              showToast('Username tidak ditemukan.');
          } else if (error == '2') {
              showToast('Password salah.');
          }
      }
    };

    function formatFirstLetterUppercase(event) {
      var input = event.target;
      var value = input.value;
      if (value.length > 0) {
        input.value = value.charAt(0).toUpperCase() + value.slice(1);
      }
    }

    document.getElementById("username").addEventListener("input", formatFirstLetterUppercase);
    document.getElementById("password").addEventListener("input", formatFirstLetterUppercase);
  </script>
</body>
</html>