

 // lost form validatrion
 // validation
 var lost = $('#loas_pass_form');
 var lost_error = $('.msg-error', lost);

 lost.validate({
    focusInvalid: false, // do not focus the last invalid input
    errorElement: 'span',

    rules: {
      'username': {minlength: 11,number: true, required: true},
      'phone': {required: true,number: true},
      // 'hidden-grecaptcha': {
      //           required: function () {
      //               if (grecaptcha.getResponse() == '') {
      //                   return true;
      //               } else {
      //                   return false;
      //               }
      //           }
      //       },
      },

    invalidHandler: function (event, validator) { //display error alert on form submit
        lost_error.show();
        scroll(lost_error, -200);
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
        lost_error.hide();
        lost_pass(form);
        return false;
    },
    //errorPlacement: function(error, element) {   },

  });

  function lost_pass(form) {

      // $('.alert').remove();
      var data = $(form).serializeArray();
      var url = $(form).attr('action');

      $(form).prepend('<div class="loader" style="position: absolute;top: 0;left: 0;background-color: #fff;width: 100%;height: 100%;text-align:center;z-index: 11;"><img src="https://thinkfuture.com/wp-content/uploads/2013/10/loading_spinner.gif" ></div>');

      $.ajax({
         type: "POST",
         url: url,
         data: data,
         dataType: "json",
         success: function(data) {

          // window.open(url,'_blank');
          // console.log(data.errorMessage);
          // console.log(data); // console append to the child class

          setTimeout(function() {

            $('.msg').remove();
            $('.loader').remove();
            // $('.load_info').empty();

            if (data.status == 1) {

              $('.inputs1').hide();

              var mobileInput = '<div class="form-group inputs-whit-icon">';
                    mobileInput += '<label for="telephone_number">ტელეფონის ნომერი</label>';
                    mobileInput += '<span class="form-icon" style="background: url(assets/img/phone-24.png)"></span>';
                    mobileInput += '<input onkeypress="return isIntKey(event);" placeholder="'+data.mobile+'" type="phone" name="mobile" id="telephone_number" class="input" autocomplete="off">';
                  mobileInput += '</div>';

              $(form).prepend(mobileInput); //


            } else if(data.status == 2) {

              var errorMsg = '<div class="msg msg-succses">';
                  errorMsg += data.errorMessage;
                  errorMsg += '</div>';

              $(form).html(errorMsg);

              setTimeout(function() {

                window.location.replace("https://apw.ge/login.php");

              }, 1000);

            } else {

              var errorMsg = '<div class="msg msg-error">';
                  errorMsg += data.errorMessage;
                  errorMsg += '</div>';

              $(form).prepend(errorMsg);

            }

         }, 1000);

        }  // success

      }); // ajax


  } // end lost pass function
