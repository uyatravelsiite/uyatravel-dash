<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Admin Login Panel</title>
  <?php require('inc/links.php'); ?>
  <style>
    div.login-form {
      position: absolute;
      top: 50%;
      left: 50%;
      transform: translate(-50%, -50%);
      width: 400px;
    }
  </style>
</head>
<body class="bg-light">
  <div class="login-form text-center rounded bg-white shadow overflow-hidden">
    <form id="loginForm">
      <h4 class="bg-dark text-white py-3">ADMIN LOGIN PANEL</h4>
      <div class="p-4">
        <div class="mb-3">
          <input id="emailInp" name="email" required type="text" class="form-control shadow-none text-center" placeholder="Email">
        </div>
        <div class="mb-4">
          <input id="passwordInp" name="password" required type="password" class="form-control shadow-none text-center" placeholder="Password">
        </div>
        <button name="login" type="submit" class="btn text-white custom-bg shadow-none">LOGIN</button>
       
      </div>
    </form>
  </div>

  <script type="module">
    import { initializeApp } from "https://www.gstatic.com/firebasejs/10.5.0/firebase-app.js";
    import { getAuth, signInWithEmailAndPassword } from "https://www.gstatic.com/firebasejs/10.5.0/firebase-auth.js";

    const firebaseConfig = {
      apiKey: "AIzaSyBiya-MbWDnCcsM-CL36LvY7oduMMxVRsQ",
      authDomain: "uya-travel.firebaseapp.com",
      databaseURL: "https://uya-travel-default-rtdb.firebaseio.com",
      projectId: "uya-travel",
      storageBucket: "uya-travel.appspot.com",
      messagingSenderId: "283228218463",
      appId: "1:283228218463:web:1320b719aabcf813dfa7ea",
    };

    const app = initializeApp(firebaseConfig);
    const auth = getAuth(app);

    let LoginForm = document.getElementById('loginForm');
    let EmailInp = document.getElementById('emailInp');
    let PasswordInp = document.getElementById('passwordInp');

    let LoginUser = (evt) => {
      evt.preventDefault();
      signInWithEmailAndPassword(auth, EmailInp.value, PasswordInp.value)
        .then((credentials) => {
          console.log(credentials);
          // Redirect to the dashboard page after a successful login
          window.location.href = "dashboard.php";
        })
        .catch((error) => {
          alert(error.message);
          console.log(error.code);
          console.log(error.message);
        });
    }

    LoginForm.addEventListener('submit', LoginUser);
  </script>
</body>
</html>
