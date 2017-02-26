(function () {
  var $tableBody = $('#images-list tbody');

  function onNewImageSubmit(e) {
    e.preventDefault();
    var form = e.currentTarget;

    $
      .ajax({
        // Your server script to process the upload
        url: '/manager/index.php?action=add&gallery='+GALLERY_ID,
        type: 'POST',

        // Form data
        data: new FormData(form),

        // Tell jQuery not to process data or worry about content-type
        // You *must* include these options!
        cache: false,
        contentType: false,
        processData: false,

        // Custom XMLHttpRequest
        xhr: function () {
          var myXhr = $.ajaxSettings.xhr();
          if (myXhr.upload) {
            // For handling the progress of the upload
            myXhr.upload.addEventListener('progress', function (e) {
              if (e.lengthComputable) {
                $('progress').attr({
                  value: e.loaded,
                  max: e.total,
                });
              }
            }, false);
          }
          return myXhr;
        }
      })
      .then(function (res) {
        if (res.success) {
          form.reset();
          renderRow(res.data);
        } else {
          alert(res.message || "Ошибка загрузки, обратитесь к администратору!");
        }
      })
      .fail(function () {
        alert("Ошибка загрузки, обратитесь к администратору!");
      })
  }

  function loadTableData() {
    $
      .get('/manager/index.php?action=list&gallery='+GALLERY_ID)
      .then(function (res) {
        if(res.success){
          renderTable(res.data);
        } else {
          alert("Ошибка, обратитесь к администратору!");
        }
      })
      .fail(function () {
        alert("Ошибка, обратитесь к администратору!");
      });
  }

  function renderTable(images) {
    $tableBody.html(null);
    images.forEach(renderRow)
  }

  function saveImage(e) {
    e.preventDefault();
    var $row = $(e.currentTarget).closest('tr');
    var data = {id: $row.data('id')}
    $row.find('input').each(function () {
      var input = this;
      data[input.name] = input.value;
    });
    $.post('/manager/index.php?action=save&gallery='+GALLERY_ID,data)
      .then(function (res) {
        if(res.success){
          $row.find('.save-image').attr('disabled','disabled');
        } else {
          alert("Ошибка, обратитесь к администратору!");
        }
      })
      .fail(function () {
        alert("Ошибка, обратитесь к администратору!");
      });
  }

  function removeImage(e) {
    e.preventDefault();
    var $row = $(e.currentTarget).closest('tr');
    $.post('/manager/index.php?action=delete&gallery='+GALLERY_ID,{id: $row.data('id')})
      .then(function (res) {
        if(res.success){
          $row.fadeOut(300,function () {
            $row.remove();
          })
        } else {
          alert("Ошибка, обратитесь к администратору!");
        }
      })
      .fail(function () {
        alert("Ошибка, обратитесь к администратору!");
      });
  }

  function imageChanged(e) {
    var $row = $(e.currentTarget).closest('tr');
    $row.find('.save-image').removeAttr('disabled');
  }

  function renderRow(item) {
    $tableBody.append(
      '<tr data-id="'+item.id+'">' +
      '<td><img src="'+item.image+'"/></td>' +
      '<td><input name="title" type="text" class="form-control" value="'+item.title+'" required></td>' +
      '<td><input name="price" type="text" class="form-control" value="'+item.price+'" required></td>' +
      '<td>' +
      '<button type="button" class="btn btn-success save-image" disabled="disabled"><i class="glyphicon glyphicon-ok"></i></button> ' +
      '<button type="button" class="btn btn-danger remove-image"><i class="glyphicon glyphicon-remove"></i></button>' +
      '</td>' +
      '</tr>')
  }


  $('#upload-form').on('submit', onNewImageSubmit);
  $tableBody.on('click','button.save-image',saveImage);
  $tableBody.on('click','button.remove-image',removeImage);
  $tableBody.on('keyup','input',imageChanged);
  $tableBody.on('change','input',imageChanged);
  loadTableData();
})(jQuery);