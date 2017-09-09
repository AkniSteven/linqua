requirejs([
  'jquery'
], function($){
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
          if (response =='end') {
            $('.single-test-page').addClass('js-show-finish-test');
          } else if (response =='error_end') {
            $('.test-finish').hide();
            $('.test-error').show();
            $('.single-test-page').addClass('js-show-finish-test');
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