requirejs(["jquery","jquery.maskedinput"],function(e){var a={form:"#start-form",name:"#name",tel:"#tel",email:"#email",init:function(){this.phone_mask(),this.name_mask(),this.validate_change_action(),this.validate_click_action()},is_valid_phone_number:function(e){return!(null==/\(\d\d\d\)-\d\d-\d\d-\d\d\d/.exec(e)||15!=e.length)},is_valid_name:function(e){return e.length>1&&e.length<40},is_valid_email:function(e){return/^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,6})+$/.test(e)},name_mask:function(){e(this.name).keydown(function(){/[^a-zA-Zа-яА-ЯёЁ`ґєҐЄ´ІіЇї .]/i.test(this.value)&&(this.value=this.value.slice(0,-1))}),e(this.name).keyup(function(){/[^a-zA-Zа-яА-ЯёЁ`ґєҐЄ´ІіЇї .]/i.test(this.value)&&(this.value=this.value.slice(0,-1))})},phone_mask:function(){e(this.tel).mask("(999)-99-99-999")},validate_name:function(a){this.is_valid_name(e(a).val())?(e(a).toggleClass("field-error",!1),e("span.name-error-msg").fadeOut().remove()):(e(a).toggleClass("field-error",!0),e("span.name-error-msg").html()||e(a).after('<span class="name-error-msg">Имя должно быть от 2 до 40 символов</span>'))},validate_tel:function(a){this.is_valid_phone_number(e(a).val())?(e(a).toggleClass("field-error",!1),e("span.tel-error-msg").fadeOut().remove()):(e(a).toggleClass("field-error",!0),e("span.tel-error-msg").html()||e(a).after('<span class="tel-error-msg">Неправильный формат телефона</span>'))},validate_email:function(a){this.is_valid_email(e(a).val())?(e(a).toggleClass("field-error",!1),e("span.email-error-msg").fadeOut().remove()):(e(a).toggleClass("field-error",!0),e("span.email-error-msg").html()||e(a).after('<span class="email-error-msg">Неправильный формат email</span>'))},validate_change_action:function(){var a=this;e(a.tel).change(function(){a.validate_tel(this)}),e(a.name).change(function(){a.validate_name(this)}),e(a.email).change(function(){a.validate_email(this)})},validate_click_action:function(){var a=this;e(a.form).submit(function(){var i=!0;if(a.is_valid_phone_number(e(a.tel).val())||(a.validate_tel(a.tel),i=!1),a.is_valid_name(e(a.name).val())||(a.validate_name(a.name),i=!1),a.is_valid_email(e(a.email).val())||(a.validate_email(a.email),i=!1),!i)return!1})}};e(document).ready(function(){a.init()})});