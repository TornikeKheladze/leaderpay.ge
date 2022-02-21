

 // form form validatrion
 // validation
 var form1 = $('.st_1');
 var form2 = $('.st_2');
 var form3 = $('.st_3');
 var form4 = $('.st_4');
 var form_error1 = $('.msg-error', form1);
 var form_error2 = $('.msg-error', form2);
 var form_error3 = $('.msg-error', form3);
 var form_error4 = $('.msg-error', form4);

 form1.validate({
    focusInvalid: false, // do not focus the last invalid input
    errorElement: 'span',

    rules: {
      'personal_number': {minlength: 11,number: true, required: true},
      'document_number': {required: true,minlength: 5},
      // 'hidden-grecaptcha': {
      //           required: function () {
      //               if (grecaptcha.getResponse() == '') {
      //                   return true;
      //               } else {
      //                   return false;
      //               }
      //           }
      //       },
      // 'email': {required: true,email: true},
      //
       // 'sms': {
       //     required: true,
       //     minlength: 6,
       //     maxlength: 6,
       //     number: true,
       // },
      //  'last_name': {
      //      required: true,
      //      minlength: 3,
      //      maxlength: 50,
      //  },
      //  'mobile': {
      //      required: true,
      //      minlength: 6,
      //      maxlength: 30,
      //  },
      //  'email': {
      //      required: false,
      //      email: true,
      //  },
      //  'birth_year': {
      //      required: true,
      //  },
      //  'birth_month': {
      //      required: true,
      //  },
      //  'birth_day': {
      //      required: true,
      //  },
      //  'birth_place': {
      //      required: true,
      //      minlength: 3,
      //      maxlength: 50,
      //  },
      //  'real_address': {
      //      required: true,
      //      minlength: 3,
      //      maxlength: 50,
      //  },
      //  'gender': {
      //      required: true,
      //      number: true,
      //      maxlength: 1,
      //  },
      //  'sfero_id': {
      //      required: true,
      //  },
      //  'sfero': {
      //    required: function(element) {
      //      if($('#sfero_id').val() == 12) { return true; } else { return false; }
      //    },
      //  },
      //  'document_type': {
      //    required: true,
      //  },
      //  'document_number': {
      //      required: true,
      //      pattern: $('#document_number').attr("regex"),
      //  },
      //
      //  'issue_organisation': {
      //      required: true,
      //  },
      //  'issue_year': {
      //      required: true,
      //  },
      //  'issue_month': {
      //      required: true,
      //  },
      //  'issue_day': {
      //      required: true,
      //  },
      //
      //  'expiry_year': {
      //    required: function(element) {
      //      if($('#expiry').is(':checked')) { return false; } else { return true; }
      //    },
      //  },
      //  'expiry_month': {
      //    required: function(element) {
      //      if($('#expiry').is(':checked')) { return false; } else { return true; }
      //    },
      //  },
      //  'expiry_day': {
      //    required: function(element) {
      //      if($('#expiry').is(':checked')) { return false; } else { return true; }
      //    },
      //  },
      //
      //  'document_front': {
      //      required: true,
      //  },
      //  'document_back': {
      //      required: true,
      //  },
      //  'aggrament': {
      //      required: true,
      //  },
       // 'aggrament': {
       //     required: true,
       // },
      },

    invalidHandler: function (event, validator) { //display error alert on form submit
        form_error1.show();
        // scroll(form_error, -200);
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
    submitHandler: function (form1) {
        form_error1.hide();
        // form[0].submit();
        user_verification(form1);

        return false;
    },
    //errorPlacement: function(error, element) {   },

  });

  form2.validate({
     focusInvalid: false, // do not focus the last invalid input
     errorElement: 'span',

     rules: {
        'sms': {
            required: true,
            minlength: 6,
            maxlength: 6,
            number: true,
        },

       },

     invalidHandler: function (event, validator) { //display error alert on form submit
         form_error2.show();
         // scroll(form_error, -200);
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
     submitHandler: function (form2) {
         form_error2.hide();
         // form[0].submit();
         user_verification(form2);

         return false;
     },
     //errorPlacement: function(error, element) {   },

   });

   form3.validate({
      focusInvalid: false, // do not focus the last invalid input
      errorElement: 'span',

      rules: {
         'document_type': {
            required: true,
         },
         'front': {
             required: true,
             accept:"jpg,png,jpeg",
         },
         'back': {
             required: true,
             accept:"jpg,png,jpeg",
         },
         'issue_year': {required: true},
         'issue_month': {required: true},
         'issue_day': {required: true},
         'expiry_year': {required: true},
         'expiry_month': {required: true},
         'expiry_day': {required: true},
         'sfero_id': {
             required: true,
         },

        },

      invalidHandler: function (event, validator) { //display error alert on form submit
          form_error3.show();
          // scroll(form_error, -200);
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
      submitHandler: function (form3) {
          form_error3.hide();
          // form[0].submit();
          user_verification(form3);

          return false;
      },
      //errorPlacement: function(error, element) {   },

    });

    form4.validate({
       focusInvalid: false, // do not focus the last invalid input
       errorElement: 'span',

       rules: {
          'checkbox': {
              required: true,
          },

         },

       invalidHandler: function (event, validator) { //display error alert on form submit
           form_error4.show();
           // scroll(form_error, -200);
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
       submitHandler: function (form4) {
           form_error4.hide();
           // form[0].submit();
           user_verification(form4);

           return false;
       },
       //errorPlacement: function(error, element) {   },

     });

  function add_new(input) {

     if (input.files && input.files[0]) {
     var reader = new FileReader();

     reader.onload = function(e) {
       // $('#blah').attr('src', e.target.result);
       $(input).parent().parent().find('.image-preview').css("background","url('"+e.target.result+"')");
       // console.log(e.target.result);

       $("#cropModal").modal("show");

       var img = e.target.result;
       var img_name = $(input).attr("name");

       $("#cropImage").attr('src',img);
       $('.cropper-container').find("img").attr('src',img);

       $("#cropImageButton").attr('onClick','saveImage('+img_name+');');
       $("#closeCrop").attr('onClick','closeModal('+img_name+');');


       setTimeout(function(){
         $image = $("#cropImage");
         $image.cropper();
       }, 300);

   }

   reader.readAsDataURL(input.files[0]);
 }

} // end add_new function

$(".bs64").change(function() {
 add_new(this);
});

function add_from_webcam(img,rel) {

   // $('#blah').attr('src', e.target.result);
   $('.image-preview.'+rel).css("background","url('"+img+"')");
   // console.log(e.target.result);

   $("#cropModal").modal("show");

   $("#cropImage").attr('src',img);
   $('.cropper-container').find("img").attr('src',img);

   $("#cropImageButton").attr('onClick','saveImage('+rel+');');
   $("#closeCrop").attr('onClick','closeModal('+rel+');');

   var evnt = "start('"+rel+"')";
   $(".new_ph").html('<button type="button" name="button" class="btn btn-default" id="buttonStart" onClick="'+evnt+'">თავიდან გადაღება</button>');


   setTimeout(function(){
     $image = $("#cropImage");
     $image.cropper();
   }, 300);


} // end add_new function


 function saveImage(doc){

   //
   var src = $image.cropper("getDataURL");

   $(doc).parent().parent().find('.image-preview').css("background","url('"+src+"')");

     var doc_id = $(doc).attr("id");

   if (doc_id == 'front') {

     var doc_val = '#document_front';

   } else if (doc_id == 'back') {

     var doc_val = '#document_back';

   }

   $(doc_val).val(src);


   $("#cropModal").modal("hide");

     $image.cropper("destroy");

   }
   function closeModal(name){

     $("#cropModal").modal("hide");

   $(name).parent('.img-prev').css("background","");

 } // end saveImage function

$(document).ready(function() {

  $('#document_type').onch

  $('#document_type').on("change",function() {
    // var regex = $(this).attr("regex");
    var id = $(this).val();

    if (id == 1) {

      $('.backside').hide();

    } else {

      $('.backside').show();

    }

  });


});

  function user_verification(form) {

    var step = $(form).attr('rel');
    var form = $(form);
    var url = $(form).attr('action');
    var data = $(form).serializeArray();

    // alert(url);

    // remove alerts
    $(".msg").remove();

    if (step == 1) {

      $(form).prepend('<div class="loader" style="position: absolute;top: 0;left: 0;background-color: #fff;width: 100%;height: 100%;text-align:center;z-index: 11;"><img src="https://thinkfuture.com/wp-content/uploads/2013/10/loading_spinner.gif" ></div>');

      $.ajax({
         type:"POST",
         url: url,
         data: data,
         dataType: "json",
         success: function(data) {

          setTimeout(function() {

            $('.loader').remove();

            if (data.errorCode == 10) {

              // remove
              $('.multi-steps li').removeClass('is-active');
              $('.step').removeClass('active');

              // add
              $('.multi-steps').children().eq(1).addClass('is-active');
              $('.steps-body').children().eq(1).addClass('active');


            } else {

              var errorMsg = '<div class="msg msg-error">';
                  errorMsg += data.errorMessage;
                  errorMsg += '</div>';

               $(form).prepend(errorMsg);

            }

          }, 1000); // timeout

        }  // success

      }); // ajax

    } // step 1

    if (step == 2) {

      $(form).prepend('<div class="loader" style="position: absolute;top: 0;left: 0;background-color: #fff;width: 100%;height: 100%;text-align:center;z-index: 11;"><img src="https://thinkfuture.com/wp-content/uploads/2013/10/loading_spinner.gif" ></div>');

      $.ajax({
         type:"POST",
         url: url,
         data: data,
         dataType: "json",
         success: function(data) {

          setTimeout(function() {

            $('.loader').remove();

            if (data.errorCode == 100) {

              var errorMsg = '<div class="msg msg-succses">';
                  errorMsg += data.errorMessage;
                  errorMsg += '</div>';

               $(form).prepend(errorMsg);

            } else {

              var errorMsg = '<div class="msg msg-error">';
                  errorMsg += data.errorMessage;
                  errorMsg += '</div>';

               $(form).prepend(errorMsg);

            }

            if (data.errorCode == 4 || data.errorCode == 7  || data.errorCode == 8 ) {

              // remove
              $('.multi-steps li').removeClass('is-active');
              $('.step').removeClass('active');

              // add
              $('.multi-steps').children().eq(2).addClass('is-active');
              $('.steps-body').children().eq(2).addClass('active');

            }

          }, 1000); // timeout

        }  // success

      }); // ajax


    } // step 2

    if (step == 3) {

      $(form).prepend('<div class="loader" style="position: absolute;top: 0;left: 0;background-color: #fff;width: 100%;height: 100%;text-align:center;z-index: 11;"><img src="https://thinkfuture.com/wp-content/uploads/2013/10/loading_spinner.gif" ></div>');

      // get values
      var document_front = $('#document_front').val();
      var document_back = $('#document_back').val();
      var sfero_id = $('#sfero_id').val();
      var document_type = $('#document_type').val();

      var issue_date = $('#issue_year').val() +'-'+ $('#issue_month').val() +'-'+ $('#issue_day').val();
      var expiry_date = $('#expiry_year').val() +'-'+ $('#expiry_month').val() +'-'+ $('#expiry_day').val();

        $.ajax({
           type:"POST",
           url: url,
           data: data,
           dataType: "json",
           success: function(data) {


            setTimeout(function() {

              $('.loader').remove();

              if (data.errorCode == 100) {

                // remove
                $('.multi-steps li').removeClass('is-active');
                $('.step').removeClass('active');

                // add
                $('.multi-steps').children().eq(3).addClass('is-active');
                $('.steps-body').children().eq(3).addClass('active');

                $('#aggement').attr("src","http://uploads.allpayway.ge/files/pdf/"+data.data);

                // append
                var append = '<input type="hidden" name="document_front" value="'+document_front+'">';
                    append += '<input type="hidden" name="document_back" value="'+document_back+'">';
                    append += '<input type="hidden" name="sfero_id" value="'+sfero_id+'">';
                    append += '<input type="hidden" name="document_type" value="'+document_type+'">';
                    append += '<input type="hidden" name="issue_date" value="'+issue_date+'">';
                    append += '<input type="hidden" name="expiry_date" value="'+expiry_date+'">';
                    append += '<input type="hidden" name="pdf" value="'+data.data+'">';

                $('.steps-body').children().eq(3).find("form").prepend(append);

              } else {

                var errorMsg = '<div class="msg msg-error">';
                    errorMsg += data.errorMessage;
                    errorMsg += '</div>';

                 $('.steps-body').children().eq(2).find("form").prepend(errorMsg);

              }

            }, 1000); // timeout

          }  // success

        }); // ajax

    } // step 3

    if (step == 4) {

      $(form).prepend('<div class="loader" style="position: absolute;top: 0;left: 0;background-color: #fff;width: 100%;height: 100%;text-align:center;z-index: 11;"><img src="https://thinkfuture.com/wp-content/uploads/2013/10/loading_spinner.gif" ></div>');

      $.ajax({
         type:"POST",
         url: url,
         data: data,
         dataType: "json",
         success: function(data) {

          setTimeout(function() {

            $('.loader').remove();

            if (data.errorCode == 10) {

              var errorMsg = '<div class="msg msg-succses">';
                  errorMsg += data.errorMessage;
                  errorMsg += '</div>';

               $(form).html(errorMsg);

            } else {

              var errorMsg = '<div class="msg msg-error">';
                  errorMsg += data.errorMessage;
                  errorMsg += '</div>';

               $(form).prepend(errorMsg);

            }

            // remove
            $('.multi-steps li').removeClass('is-active');
            // $('.step').removeClass('active');

            // add
            $('.multi-steps').children().eq(4).addClass('is-active');
            // $('.steps-body').children().eq(4).addClass('active');

          }, 1000); // timeout

        }  // success

      }); // ajax

    } // step 4

  }//


  //////////////

var video = document.getElementById('webcam');
var canvas = document.getElementById('taked_img');
var videoStream = null;

function snapshot(rel) {

	canvas.width = video.videoWidth;
	canvas.height = video.videoHeight;
	canvas.getContext('2d').drawImage(video, 0, 0);

  var img = canvas.toDataURL("image/png");

  add_from_webcam(img,rel);
  stop();
}

function noStream() {
	console.log('ვებ კამერასთან წვდომა არ არის');
}

function stop() {

  $("#webcamModel").modal("hide");

	var myButton = document.getElementById('buttonStop');
	if (myButton) myButton.disabled = true;
	myButton = document.getElementById('buttonSnap');
	if (myButton) myButton.disabled = true;
	if (videoStream)
	{
		if (videoStream.stop) videoStream.stop();
		else if (videoStream.msStop) videoStream.msStop();
		videoStream.onended = null;
		videoStream = null;
	}
	if (video)
	{
		video.onerror = null;
		video.pause();
		if (video.mozSrcObject)
			video.mozSrcObject = null;
		video.src = "";
	}
	myButton = document.getElementById('buttonStart');
	if (myButton) myButton.disabled = false;
}

function gotStream(stream) {

	var myButton = document.getElementById('buttonStart');
	if (myButton) myButton.disabled = true;
	videoStream = stream;
	console.log('Got stream.');
	video.onerror = function () {
		alert('video.onerror');
		if (video) stop();
	};
	stream.onended = noStream;
	video.srcObject = stream;

	myButton = document.getElementById('buttonSnap');
	if (myButton) myButton.disabled = false;
	myButton = document.getElementById('buttonStop');
	if (myButton) myButton.disabled = false;
}

function start(rel) {

// console.log(rel);
  $('#buttonSnap').attr("onClick","snapshot('"+rel+"')");

  $("#webcamModel").modal("show");

	if ((typeof window === 'undefined') || (typeof navigator === 'undefined'))

    console.log('This page needs a Web browser with the objects window.* and navigator.*!');

	else if (!(video && canvas))

    console.log('HTML context error!');

	else {

		console.log('Get user media…');

		if (navigator.getUserMedia) navigator.getUserMedia({video:true}, gotStream, noStream);
		else if (navigator.oGetUserMedia) navigator.oGetUserMedia({video:true}, gotStream, noStream);
		else if (navigator.mozGetUserMedia) navigator.mozGetUserMedia({video:true}, gotStream, noStream);
		else if (navigator.webkitGetUserMedia) navigator.webkitGetUserMedia({video:true}, gotStream, noStream);
		else if (navigator.msGetUserMedia) navigator.msGetUserMedia({video:true, audio:false}, gotStream, noStream);
		else alert('getUserMedia() not available from your Web browser!');

	}

}

// $('buttonStart').on("click",function(){
//   start();
// });



function show_webcam_model() {
  $("#webcamModel").modal("show");
}
function hid_webcam_model() {
  $("#webcamModel").modal("hide");
}

$('#sfero_id').change(function() {

  var id = $(this).val();

  if (id == 12) {
    $('.sfero_div').show();
  } else {
    $('.sfero_div').hide();
  }

});
