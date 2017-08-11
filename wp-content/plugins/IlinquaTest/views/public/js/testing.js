requirejs([
    'jquery'
],function($){
    var testing_obj = {
        submit_btn: '.submit_question',

        init:function(){
            this.submit_action();
        },

        submit_action:function(){
            var _this = this;
            $(document).on( "click", this.submit_btn, function(){
                _this.addTestStep($(this).closest('form').serialize());
            });
        },

        addTestStep:function(data) {
            $.ajax({
                type: 'POST',
                url: $('#ajax').data('url'),
                data: {
                    'action': 'addTestStep',
                    'data': data
                },
                dataType: 'html',
                success: function (response) {
                    console.log('hello');
                    console.log($('.single-test-page'));
                    if (response =='end') {
                        $('#main').addClass('adscdscdscds');

                    }
                },
                error: function () {
                    console.log(0);
                }

            })
        }
    };
    $(document).ready(function () {
        testing_obj.init();
    });
});