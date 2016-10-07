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