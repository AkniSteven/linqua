/**
 * Created by icefier on 31.08.16.
 */
function fields_creator(wrapper, add_button, max_fields, append_name){

    var x = 1; //initlal text box count
    jQuery(add_button).click(function(e){ //on add input button click
        e.preventDefault();
        if(x < max_fields){ //max input box allowed
            x++; //text box increment
            jQuery(wrapper).append('<div><input type="text" name="'+ append_name +'"/><a href="#" class="remove_field">Remove</a></div>'); //add input box
        }
    });

    jQuery(wrapper).on("click",".remove_field", function(e){ //user click on remove text
        e.preventDefault(); jQuery(this).parent('div').remove(); x--;
    })
}
jQuery(document).ready(function() {
    fields_creator(jQuery('.input_fields_wrap_phone'), jQuery('.add_field_button_phone'), 10, "ice-theme-settings[phones][]")
});