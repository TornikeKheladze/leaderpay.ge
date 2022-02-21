 // login form validation
 // validation
 var login = $('#login');
 var login_error = $('.msg-error', login);

 login.validate({
    focusInvalid: false, // do not focus the last invalid input
    errorElement: 'span',

    rules: {
      'username': {minlength: 11,number: true, required: true},
      'password': {required: true},
      'sms_code' : {required: true},
      },

    invalidHandler: function (event, validator) { //display error alert on form submit
        login_error.show();
        scroll(login_error, -200);
    },
    highlight: function (element,errorElement) { // hightlight error inputs
        $(element).closest('.form-group').addClass('has-error'); // set error class to the control group
    },
    unhighlight: function (element) { // revert the change done by hightlight
        $(element).closest('.form-group').removeClass('has-error'); // set error class to the control group
    },
    errorPlacement: function(error, element){
      var errorClone = error.clone();
      element.next("span[class='help-block help-block-error']").remove();
      error.insertAfter(element);
    },

    success: function (label) {
        label.closest('.form-group').removeClass('has-error'); // set success class to the control group
        // $( ".form-group" ).remove( ".error" );
    },
    submitHandler: function (form) {
        login_error.hide();
        login[0].submit();
    },
    //errorPlacement: function(error, element) {   },

  });
