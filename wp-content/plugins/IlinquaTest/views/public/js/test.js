function questionSorter(name){
    switch (name){
        case 'text' :
            hideFragment();
            hideCounter();
            break;
        case 'radio':
            hideFragment();
            showCounter();
            break;
        case 'checkbox':
            hideFragment();
            showCounter();
            break;
        case 'fragment':
            hideCounter();
            showFragment();
            break;
    }
}

function hideCounter(){
    jQuery('#answer_counter').hide();
}

function showCounter(){
    jQuery('#answer_counter').show();
}

function hideFragment(){
    jQuery('#fragment').hide();
}

function showFragment(){
    jQuery('#fragment').show();
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