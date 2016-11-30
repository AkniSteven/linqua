function addTestStep(data) {
    debugger;
        jQuery.ajax({
            type: 'POST',
            url: 'http://www.linqua.web/wp-admin/admin-ajax.php',
            data: {
                'action': 'addTestStep',
                'data' : data
            },
            dataType: 'html',
            success: function (response) {
                alert(response);

            },
            error: function () {
                alert(0);
            }

        })
}
jQuery( document ).ready(function() {
    jQuery('.submit_question').on( "click", function(){
      addTestStep($(this).closest('form').serialize());
    });
});