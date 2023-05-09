$(document).ready(function() {
  var $validator = $('#registracion_form').validate({
      errorElement: 'span',
      rules: {
          'phone': {minlength: 9, maxlength: 10, required: true},
          'email': {required: true},
          'legal_address': {required: true, minlength: 5, maxlength: 255},
          'real_address': {required: true, minlength: 5, maxlength: 255},
          'repeat_password': {equalTo: '#password'},
          'password': {minlength: 8, required: true, passwordCheck: true},
          'pep_status': {required: true, minlength: 1},
          'pep': {
              required: function(element) {
                  return ($('#pep_status').val() == '1') ? true : false;
              },
          },
          'limits': {required: true},
          'privacy_policy': {required: true},
          'contract': {required: true},

      },
      messages: {
          'password': {
              'passwordCheck': 'პაროლი ძალიან სუსტია. პაროლი უნდა შეიცავდეს მინიმუმ 1 ციფრს 1 სიმბოლოს 1 uppercase!'
          }
      }
  });

  $('#rootwizard').bootstrapWizard({
      'tabClass': 'nav nav-pills',
      'onNext': function(tab, navigation, index) {
          var $valid = $('#registracion_form').valid();
          if(!$valid) {
              $validator.focusInvalid();
              return false;
          }

          if (index == 1) {

              var form = $('#registracion_form');
              var url = 'loads/registration.php';
              var mobile = $('#phone').intlTelInput('getNumber');
              var data = form.serializeArray();

              // data[data.length] = { name: 'mobile', value: mobile};
              // data[data.length + 1] = { name: 'step', value: 1};

              data.push({name: "mobile", value: mobile});
              data.push({name: "step", value: 1});


              $('.reg_loader').show();
              $('.msg').remove();

              $.ajax({
                  type: 'POST',
                  url: url,
                  data: data,
                  dataType: 'json',
                  success: function(data) {

                      setTimeout(function() {

                          $('.reg_loader').hide();

                          if (data.errorCode == 10) {
                  
                              $('.identomat').attr('src', 'https://widget.identomat.com/?session_token=' + data.data.session);
                              $('#iToken').val(data.data.session);
                              $('#type').val('identomat');

                          } else {

                              var errorMsg = '<div class="msg msg-error">';
                                  errorMsg += data.errorMessage;
                                  errorMsg += '</div>';
                  
                              $(form).prepend(errorMsg);
                              $('.previous').trigger('click');

                          }

                      }, 3000);
                  }  // success
              }); // ajax

          } // index 1

          if (index == 2) {

              var form = $('#registracion_form');
              var url = 'loads/registration.php';
              var mobile = $('#phone').intlTelInput('getNumber');
              var data = form.serializeArray();

              // data[data.length] = { name: 'mobile', value: mobile};
              // data[data.length + 1] = { name: 'step', value: 2};

              data.push({name: "mobile", value: mobile});
              data.push({name: "step", value: 2});
              
              $('.reg_loader').show();
              $('.msg').remove();

              $.ajax({
                  type: 'POST',
                  url: url,
                  data: data,
                  dataType: 'json',
                  success: function(data) {

                      setTimeout(function() {

                          $('.reg_loader').hide();

                          if (data.errorCode == 10) {

                              var errorMsg = '<div class="msg msg-succses">';
                                  errorMsg += data.errorMessage;
                                  errorMsg += '</div>';

                              $('.page-bg').html(errorMsg);
                          } else {

                              var errorMsg = '<div class="msg msg-error">';
                                  errorMsg += data.errorMessage;
                                  errorMsg += '</div>';
                  
                              $(form).prepend(errorMsg);
                              $('.previous').trigger('click');
                          }

                      }, 3000);
                  }  // success
              }); // ajax

          } // index 2
      },
      'onTabClick': function(tab, navigation, index) {
          return false;
      },
      'onTabShow': function(tab, navigation, index) {

          var total = navigation.find('li').length;
          var current = index+1;

          if (total == current) {

              $('.next').hide();
              $('.last').show();
              $('.last').removeClass('disabled');

          } 

      }
  });
});

function checkPepStatus(id) {

    if (id == '1') {
        $('.pep_div').show();
    } else {
        $('.pep_div').hide();
    }

}

$.validator.addMethod('passwordCheck', function(value) {

  return /[a-z]/.test(value)
  && /[A-Z]/.test(value)
  && /\d/.test(value)
  && /[=!\-@._*\$\#\%\^\&\(\)\~\`\<\>\/\?\\\|\{\}\[\]\;\:\'\"\,\+]/.test(value)
});

addEventListener('message', function (e) {

  if (e.origin !== 'https://widget.identomat.com') return;
  if (e.data !== 'DONE') return;

  $('.g1-btn').trigger('click');

});
