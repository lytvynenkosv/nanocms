<?php
defined('APP_RUNNING') or die('Restricted access');
?>
<!doctype html>
<html lang="en">
<head>
    <?php include './templates/header.tpl.php'; ?>
</head>
<body>
<div class="container">

  <form class="form-signin" method="post" action="/manager/">
    <h2 class="form-signin-heading">Панель управления</h2>
    <label for="inputLogin" class="sr-only">Логин</label>
    <input type="text" id="inputLogin" name="login" class="form-control" placeholder="логин" required autofocus>
    <label for="inputPassword" class="sr-only">Пароль</label>
    <input type="password" name="password" id="inputPassword" class="form-control" placeholder="пароль" required>
    <button class="btn btn-lg btn-primary btn-block" type="submit">Войти</button>
  </form>

</div>
</body>
</html>
