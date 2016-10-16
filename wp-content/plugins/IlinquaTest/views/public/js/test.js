function createQuestionsFields() {
    var q_category = jQuery("#questions_category").val();
    if (q_category != 'undefined') {
            jQuery.ajax({
                type: 'POST',
                url: ajaxurl,
                data: {
                    'action': 'createQuestionsFields',
                    'q_type': q_category
                },
                dataType: 'html',
                success: function (response) {
                    jQuery('#test_questions_block').html(response);
                },
                error: function () {
                    alert('Sory... error');
                }

            })
        
    }
}
jQuery( document ).ready(function() {
    createQuestionsFields()
});