function questionSorter(name){
    switch (name){
        case 'text' :
            hideAnswerFields();
            hideCounter();
            break;
        case 'radio':
            showCounter();
            showAnswerFields();
            break;
        case 'checkbox':
            showCounter();
            showAnswerFields();
            break;
    }
}

function hideCounter(){
    jQuery('#answer_counter').hide();
}

function hideAnswerFields(){
    jQuery('#answer_fields').hide();
}

function showCounter(){
    jQuery('#answer_counter').show();
}

function showAnswerFields(){
    jQuery('#answer_fields').show();
}

function createAnswerFields(value, id){
    if(value !='undefined' && id!='undefined'){
        jQuery.ajax({
            type: 'POST',
            url: ajaxurl,
            data: {
                'action':'createAnswerFields',
                'counter':value,
                'post_id':id
            },
            dataType: 'html',
            success: function(response){
                jQuery('#answer_fields').html(response);
            },
            error: function() {
                alert('Sory... error');
            }

        })
    }
}
function createRightAnswerField(){
    var q_type  = jQuery("#question_type").val();
    var a_count = jQuery("#counter").val();

    if(q_type != 'undefined' && a_count != 'undefined'){
        if(q_type != 'text'){
            jQuery.ajax({
                type: 'POST',
                url: ajaxurl,
                data: {
                    'action':'createRightAnswerField',
                    'q_type':q_type,
                    'q_count':a_count
                },
                dataType: 'html',
                success: function(response){
                    jQuery('#right-answer').html(response);
                },
                error: function() {
                    alert('Sory... error');
                }

            })
        } else {
            jQuery('#right-answer').html("<input type='hidden' name='right_answer' id='right_answer' value=''");
        }

    }
}