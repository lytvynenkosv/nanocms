(function () {

  $('#upload-form').on('submit', function (e) {
    e.preventDefault();
    var form = e.currentTarget;
    $.ajax({
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
    });
  });

})(jQuery);