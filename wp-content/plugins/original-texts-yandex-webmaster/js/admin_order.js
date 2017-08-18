
jQuery(document).ready(function () {
    //Установка галочки ведения журнала
    jQuery('[name="ortext_jornal_inc"]').on('click', function () {


        var text = ' ';
        if (jQuery(this).prop("checked") == true) {
            text = 'checked';
        }
        jQuery.ajax({
            type: "POST",
            url: '/wp-admin/admin-ajax.php',
            data: {
                action: 'incjornal',
                text: text
            },
            error: function () {
                console.log("Не смог сохранить галочку");
            }
        });
    });
        //Установка галочки сообщений об ошибках
    jQuery('[name="ortext_error_inc"]').on('click', function () {


        var text = ' ';
        if (jQuery(this).prop("checked") == true) {
            text = 'checked';
        }
        jQuery.ajax({
            type: "POST",
            url: '/wp-admin/admin-ajax.php',
            data: {
                action: 'incerrormessage',
                text: text
            },
            error: function () {
                console.log("Не смог сохранить галочку");
            }
        });
    });
    

    //Отправка через кнопку в редакторе( в случае ошибки)
    jQuery('#ortext_send_editor').on('click', function () {
        //alert("hello");
        var postID = jQuery('#ortextPostID').val();
        jQuery.ajax({
            type: "POST",
            url: '/wp-admin/admin-ajax.php',
            data: {
                action: 'posttoyandex',
                text: postID
            },
            success: function (result) {
                if (result == 'good') {
                    jQuery('#ortext_messagerror').fadeOut();
                    
                } else {
                    jQuery('#returnError').text(" Опять ошибка, обновите страницу и попробуйте еще раз ");
                }
            },
            error: function () {
                console.log("Не смог отправить");
            }
        });
    });


});

