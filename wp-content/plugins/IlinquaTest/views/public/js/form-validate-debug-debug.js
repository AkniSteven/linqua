requirejs([
    'jquery',
    "jquery.maskedinput"

],function($){
    var request_obj = {
        form: '#start-form',
        name: '#name',
        tel:  '#tel',
        email:'#email',

        init:function(){
            this.phone_mask();
            this.name_mask();
            this.validate_change_action();
            this.validate_click_action();
        },

        is_valid_phone_number:function(phone_number){
            var regExpObj = /\(\d\d\d\)-\d\d-\d\d-\d\d\d/;
            return !(regExpObj.exec(phone_number) == null || phone_number.length != 15);
        },

        is_valid_name:function(name) {
            return name.length > 1 && name.length < 40;
        },

        is_valid_email:function(email)  {
            var re = /^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,6})+$/;
            return re.test(email);
        },

        name_mask:function(){
            $(this.name).keydown(function(){
                if(/[^a-zA-Zа-яА-ЯёЁ`ґєҐЄ´ІіЇї .]/i.test(this.value)){
                    this.value = this.value.slice(0, -1)
                }
            });
            $(this.name).keyup(function(){
                if(/[^a-zA-Zа-яА-ЯёЁ`ґєҐЄ´ІіЇї .]/i.test(this.value)){
                    this.value = this.value.slice(0, -1)
                }
            });
        },

        phone_mask:function(){
            $(this.tel).mask("(999)-99-99-999")
        },

        validate_name:function(name){
            var _this = this;

            if (! _this.is_valid_name($(name).val())) {
                $(name).toggleClass('field-error', true);

                if (!$('span.name-error-msg').html()) {
                    $(name).after('<span class="name-error-msg">' + 'Имя должно быть от 2 до 40 символов' + '</span>');
                }
            } else {
                $(name).toggleClass('field-error', false);
                $('span.name-error-msg').fadeOut().remove();
            }
        },

        validate_tel:function(tel){
            var _this = this;

            if (! _this.is_valid_phone_number($(tel).val())) {
                $(tel).toggleClass('field-error', true);

                if (!$('span.tel-error-msg').html()) {
                    $(tel).after('<span class="tel-error-msg">' + 'Неправильный формат телефона' + '</span>');
                }
            } else {
                $(tel).toggleClass('field-error', false);
                $('span.tel-error-msg').fadeOut().remove();
            }
        },

        validate_email:function(email){
            var _this = this;

            if (! _this.is_valid_email($(email).val())) {
                $(email).toggleClass('field-error', true);

                if (!$('span.email-error-msg').html()) {
                    $(email).after('<span class="email-error-msg">' + 'Неправильный формат email' + '</span>');
                }
            } else {
                $(email).toggleClass('field-error', false);
                $('span.email-error-msg').fadeOut().remove();
            }
        },

        validate_change_action:function(){
            var _this = this;

            $(_this.tel).change(function(){
                _this.validate_tel(this);
            });
            $(_this.name).change(function(){
                _this.validate_name(this);
            });
            $(_this.email).change(function(){
                _this.validate_email(this);
            });
        },

        validate_click_action:function(){
            var _this = this;

            $(_this.form).submit(function() {
                var valid = true;

                if(! _this.is_valid_phone_number($(_this.tel).val())) {
                    _this.validate_tel(_this.tel);
                    valid = false;
                }

                if(! _this.is_valid_name($(_this.name).val())) {
                    _this.validate_name(_this.name);
                    valid = false;
                }

                if(! _this.is_valid_email($(_this.email).val())) {
                    _this.validate_email(_this.email);
                    valid = false;
                }

                if(!valid) {
                    return false;
                }

            });
        }
    };

    $(document).ready(function () {
        request_obj.init();
    });
});