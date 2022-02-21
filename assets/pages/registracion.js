// registracion form validatrion
// validation
var registracion_form = $('#registracion_form');
var registracion_error = $('.msg-error', registracion_form);
// console.log(grecaptcha);
registracion_form.validate({
   focusInvalid: false, // do not focus the last invalid input
   errorElement: 'span',
    // errorElement: 'span',
   rules: {
    'country': {equalTo: "#country"},
    //  'country': {required: true},
    //  'personal_number': {

    //    minlength: function(element) {
    //                  if($('option:selected', "#country").val() == "GE") { return 11; } else { return false; }
    //                },
    //    maxlength: function(element) {
    //                  if($('option:selected', "#country").val() == "GE") { return 11; } else { return false; }
    //                },

    //    number: function(element) {
    //                if($('option:selected', "#country").val() == "GE") { return true; } else { return false; }
    //              },
    //    required: function(element) {
    //              if($('option:selected', "#country").val() == "GE") { return true; } else { return false; }
    //            },
    //  },
    'personal_number': {minlength: 11,maxlength:11, required: true},
     'first_name': {minlength: 3,required: true},
     'phone': {minlength: 9,required: true},
     'birth_year': {required: true},
     'birth_month': {required: true},
     'birth_day': {required: true},
     'repeat_password': {equalTo: "#password"},
     'last_name': {minlength: 3,required: true},
     'gender': {required: true},
     'password': {minlength: 8,required: true},
     'hidden-grecaptcha': {
               required: function () {
                   if (grecaptcha.getResponse() == '') {
                       return true;
                   } else {
                       return false;
                   }
               }
           },
     'checkbox': {required: true},
     'checkbox1': {required: true},
     },

   invalidHandler: function (event, validator) { //display error alert on form submit
       registracion_error.show();
       scroll(registracion_error, -200);
   },
   highlight: function (element,errorElement) { // hightlight error inputs
       $(element).closest('.form-group').addClass('has-error'); // set error class to the control group
   },
   unhighlight: function (element) { // revert the change done by hightlight
       $(element).closest('.form-group').removeClass('has-error'); // set error class to the control group
   },
   errorPlacement: function(error, element){
     var errorClone = error.clone();
     element.next("label[class='help-block help-block-error']").remove();
     error.insertAfter(element);
   },

   success: function (label) {
       label.closest('.form-group').removeClass('has-error'); // set success class to the control group
           // $( ".form-group" ).remove( ".error" );
   },
   submitHandler: function (form) {
       registracion_error.hide();
       // registracion_form[0].submit();
       generete_doc(0);
       registracion(registracion_form);

       return false;
   },
   //errorPlacement: function(error, element) {   },
 });


// $(document).on('submit','#registracion_form',function(){
//   generete_doc(0);
//   registracion($('#registracion_form'));
//   return false;
// });

 function registracion(form) {
   var form = $(form);
   var url = $(form).attr('action');
   var data = $(form).serializeArray(); // ansource

   $('.reg_loader').show();
   $('.msg').remove();

   $.ajax({
      type:"POST",
      url: url,
      data: data,
      dataType: "json",
      success: function(data) {

       setTimeout(function() {

         $('.reg_loader').hide();

         if (data.errorCode == 10) {
           var errorMsg = '<div class="msg msg-succses">';
               errorMsg += data.errorMessage;
               errorMsg += '<span>თქვენი საფულის ნომერი: '+data.wallet_number+'</span>';
               errorMsg += '<div class="alert alert-primary" role="alert" style="font-family: \'title\';">'
               errorMsg += 'ვერიფიკაციის გასავლელად მიბრძანდით ჩვენს ნებისმიერ <a href="https://leaderpay.ge/contact.php" style="font-family: \'title\';">სალაროში</a>'
               errorMsg += '</div>'
               errorMsg += '</div>';

            $(form).html(errorMsg);
         } else {
           var errorMsg = '<div class="msg msg-error">';
               errorMsg += data.errorMessage;
               errorMsg += '</div>';

            $(form).prepend(errorMsg);
         }
       }, 3000); // timeout
     }  // success
   }); // ajax
 }

// country
$('#country').change(function() {
  var id = $('option:selected', this).val();

  // console.log(id);
  if (id == "GE") {
    $('.personal_number_div').show();
  } else {
    $('.personal_number_div').hide();
  }
});

$('#checkbox').click(function() {
  generete_doc(0);
});
