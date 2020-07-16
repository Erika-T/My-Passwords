<?php

// login

require_once(__DIR__ . '/../config/config.php');

$app = new MyApp\Controller\Login();

$app->run();

?>
<!DOCTYPE html>
  <html>
    <head>
      <meta charset="utf-8">
      <title>Login</title>
      <link rel="stylesheet" href="css/styles.css">
      <script src="https://unpkg.com/react@16/umd/react.development.js"></script>
      <script src="https://unpkg.com/react-dom@16/umd/react-dom.development.js"></script>
      <script src="https://unpkg.com/babel-standalone@6.15.0/babel.min.js"></script>
      <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.13.0/css/all.css" integrity="sha384-Bfad6CLCknfcloXFOyFnlgtENryhrpZCe29RTifKEixXQZ38WheV+i/6YWSzkz3V" crossorigin="anonymous">
    </head>
    <body>
      <div class="login_container">
        <form action="" method="post" id="login">
          <h1>My Password Login</h1>
          <p class="input_login">
            <input type="text" name="email" placeholder="Email" value="<?= isset($app->getValues()->email) ? h($app->getValues()->email) : ''; ?>">
          </p>
          <p class="input_login">
            <input type="password" name="password" placeholder="Master Password">
          </p>
          <span class="err"><?= h($app->getErrors('login')); ?></span>
          <div class="btn" onclick="document.getElementById('login').submit();">LogIn</div>
          <p><a href="/signup.php">Sign Up</a></p>
          <input type="hidden" name="token" value="<?= h($_SESSION['token']); ?>">
        </form>
      </div>
    </body>
  </html>