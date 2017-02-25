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
  <h1>Управление фотогаллереей</h1>
  <table id="images-list" class="table table-striped">
    <thead>
    <th>Фото</th>
    <th>Название</th>
    <th>Цена</th>
    <th>&nbsp;</th>
    </thead>
    <tbody>

    </tbody>
  </table>
</div>
<form id="upload-form">
  <div class="form-group">
    <label for="exampleInputEmail1">Email address</label>
    <input type="email" class="form-control" id="exampleInputEmail1" placeholder="Email">
  </div>
  <div class="form-group">
    <label for="exampleInputPassword1">Password</label>
    <input type="password" class="form-control" id="exampleInputPassword1" placeholder="Password">
  </div>
  <div class="form-group">
    <label for="exampleInputFile">File input</label>
    <input type="file" id="exampleInputFile">
    <p class="help-block">Example block-level help text here.</p>
  </div>
  <div class="checkbox">
    <label>
      <input type="checkbox"> Check me out
    </label>
  </div>
  <button type="submit" class="btn btn-default">Submit</button>
</form>
<script type="text/javascript" src="/manager/assets/js/main.js"></script>
</body>
</html>
