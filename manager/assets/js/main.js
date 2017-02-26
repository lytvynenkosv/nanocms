(function () {
  var images = [];
  var $tableBody = $('#images-list tbody');

  function onNewImageSubmit(e) {
    e.preventDefault();
    var form = e.currentTarget;

    $
      .ajax({
        // Your server script to process the upload
        url: '/manager/index.php?action=add',
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
          images.push(res.data);
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
      .get('/manager/index.php?action=list')
      .then(function (res) {
        if(res.success){
          images = res.data;
          renderTable();
        } else {
          alert("Ошибка, обратитесь к администратору!");
        }
      })
      .fail(function () {

      });
  }

  function renderTable() {
    $tableBody.html(null);
    images.forEach(renderRow)
  }

  function renderRow(item) {
    $tableBody.append(
      '<tr data-id="'+item.id+'">' +
      '<td><img src="'+item.image+'"/></td>' +
      '<td><input name="title" type="text" class="form-control" value="'+item.title+'" required></td>' +
      '<td><input name="price" type="text" class="form-control" value="'+item.price+'" required></td>' +
      '<td>' +
      '<button type="button" class="btn btn-success save-image" disabled="disabled"><i class="glyphicon glyphicon-ok"></i></button>' +
      '<button type="button" class="btn btn-danger remove-image"><i class="glyphicon glyphicon-remove"></i></button>' +
      '</td>' +
      '</tr>')
  }


  $('#upload-form').on('submit', onNewImageSubmit);
  loadTableData();
})(jQuery);