jQuery(document).ready(function($) {
    $('.header_logo_upload').click(function(e) {
        e.preventDefault();
        var custom_uploader = wp.media({
            title: 'Custom Image',
            button: {
                text: 'Upload Image'
            },
            multiple: false  // Set this to true to allow multiple files to be selected
        })
            .on('select', function() {
                var attachment = custom_uploader.state().get('selection').first().toJSON();
                $('.header_logo').attr('src', attachment.url);
                $('.header_logo_url').val(attachment.url);

            })
            .open();
    });
    $('.header_logo_reset').click(function() {
        $('.header_logo').attr('src','');
        $('.header_logo_url').val('');
    });

  $('.favicon_upload').click(function(e) {
    e.preventDefault();
    var custom_uploader = wp.media({
      title: 'Custom Image',
      button: {
        text: 'Upload Image'
      },
      multiple: false  // Set this to true to allow multiple files to be selected
    })
      .on('select', function() {
        var attachment = custom_uploader.state().get('selection').first().toJSON();
        $('.favicon').attr('src', attachment.url);
        $('.favicon_url').val(attachment.url);

      })
      .open();
  });
  $('.favicon_reset').click(function() {
    $('.favicon').attr('src','');
    $('.favicon_url').val('');
  });
});