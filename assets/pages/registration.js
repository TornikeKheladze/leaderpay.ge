$(document).ready(function() {
  var $validator = $('#registracion_form').validate({
      errorElement: 'span',
      rules: {
          'first_name1': {required: true, minlength: 2},
          'last_name1': {required: true, minlength: 2},
          'personal_number1': {required: true},
          'phone': {minlength: 9, maxlength: 10, required: true},
          'email': {required: true},
          'legal_address': {required: true, minlength: 5, maxlength: 255},
          'real_address': {required: true, minlength: 5, maxlength: 255},
          'repeat_password': {equalTo: '#password'},
          'password': {minlength: 8, required: true, passwordCheck: true},
          'checkbox': {required: true},
          'dual_citizen': {required: true},
          'country2': {
              required: function(element) {
                  return ($('#dual_citizen').val() == 1) ? true : false;
              },
          },
          'birth_country': {
              required: true,
          },
          'employee_status': {
              required: true,
          },
          'sfero_id': {
              required: function(element) {
                  return ($('#employee_status').val() == '1') ? true : false;
              },
              minlength: 1
          },
          'job_title': {
              required: function(element) {
                  return ($('#employee_status').val() == '1') ? true : false;
              },
              minlength: 3
          },
          'occupied_position': {
              required: function(element) {
                  return ($('#employee_status').val() == '1') ? true : false;
              },
              minlength: 3
          },
          'self_employed': {
              required: function(element) {
                  return ($('#employee_status').val() == '2') ? true : false;
              },
          },
          'source_of_income': {
              required: function(element) {

                  return ($('#employee_status').val() == '3') ? true : false;
              },
          },
          'monthly_income': {required: true, minlength: 1},
          'expected_turnover': {required: true, minlength: 1},
          'purpose_id': {required: true, minlength: 1},
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

                              $('#pNumber').val(data.data.personal_number);
                  
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
          if (index == 3) {

              var form = $('#registracion_form');
              var url = 'loads/registration.php';
              var mobile = $('#phone').intlTelInput('getNumber');
              var data = form.serializeArray();

              // data[data.length] = { name: 'step', value: 3};

              // data.push({name: "mobile", value: mobile});
              data.push({name: "step", value: 3});

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

                              $.ajax({
                                  type: 'POST',
                                  url: 'loads/pep.php',
                                  data: {personal_number: data.data.personal_number},
                                  dataType: 'json',
                                  success: function(data) {}
                              });

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


          } // index 3
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

function checkEmployeeStatus(id) {

  if (id == '1') {
      $('.jobTitleDiv').show();
      $('.sferoIdDiv').show();
  } else {
      $('.jobTitleDiv').hide();
      $('.sferoIdDiv').hide();
  }

  if (id == '2') {
      $('.selfEmployeeDiv').show();
      $(".sfero_id option[value='10']").prop('disabled', true);

  } else {
      $('.selfEmployeeDiv').hide();
      $(".sfero_id option[value='10']").prop('disabled', false);

  }

  if (id == '3') {
      $('.sourceIncomeDiv').show();

  } else {
      $('.sourceIncomeDiv').hide();

  }

}

function checkDualCitizen(id) {
  if (id == '1') {
      $('.country2').show();
  } else {
      $('.country2').hide();
  }

}

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
