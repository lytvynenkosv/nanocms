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
  <ul class="nav nav-tabs">
    <?php foreach ($galleries as $id=>$title){ //?>
    <li role="presentation" <?php echo $id==$_GET['gallery'] ? 'class="active' : '' ; ?> "><a href="?gallery=<?php echo $id; ?>"><?php echo $title; ?></a></li>
    <?php } ?>
  </ul>
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
  <div class="row">
    <form id="upload-form" class="col-md-6 col-md-offset-3">
      <h2>Загрузка изображения</h2>
      <div class="row">
        <div class="form-group col-sm-8">
          <label for="newTitleInput">Название</label>
          <input name="title" type="text" class="form-control" id="newTitleInput" placeholder="Название изображения" required>
        </div>
        <div class="form-group col-sm-4">
          <label for="newPriceInput">Цена</label>
          <input name="price" type="text" class="form-control" id="newPriceInput" placeholder="Цена" required>
        </div>
      </div>
      <div class="form-group">
        <label for="exampleInputFile">Файл</label>
        <input name="file" type="file" id="exampleInputFile" accept="image/jpeg" required>
        <p class="help-block">Файл в формате JPEG</p>
      <button type="submit" class="btn btn-default">Загрузить</button>
    </form>
  </div>
</div>
<script type="text/javascript">
  var GALLERY_ID = '<?php echo $_GET['gallery'] ?>';
</script>
<script type="text/javascript" src="/manager/assets/js/main.js"></script>
</body>
</html>
