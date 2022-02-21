function scroll(to) {
  $('html, body').animate({
      scrollTop: $(to).offset().top
  }, 800);
}

// get services by category (responsive) //
function get_services(service_id,index,lang,subcat) {
    $(".service_result").remove();

    if ($(window).width() > 1200) {
      if (index >= 0 && index < 8) {
           var s = 8;
         } else if (index >= 8 && index < 16 ) {
           var s = 16;
         } else {
           var s = 8;
         }
    } else if ($(window).width() <= 1200 && $(window).width() > 991) {
      if (index >= 0 && index < 6) {
           var s = 6;
         } else if (index >= 6 && index < 12 ) {
           var s = 12;
         } else if (index >= 12 && index < 16 ) {
           var s = 16;
         } else {
           var s = 6;
         }
      } else if($(window).width() <= 991 && $(window).width() > 757) {
        if (index >= 0 && index < 5) {
             var s = 5;
           } else if (index >= 5 && index < 10 ) {
             var s = 10;
           } else if (index >= 10 && index < 15 ) {
             var s = 15;
           } else if (index >= 15 && index < 20 ) {
             var s = 16;
           } else {
             var s = 5;
           }
      } else if($(window).width() <= 757 && $(window).width() > 614) {
        if (index >= 0 && index < 4) {
             var s = 4;
           } else if (index >= 4 && index < 8 ) {
             var s = 8;
           } else if (index >= 8 && index < 12 ) {
             var s = 12;
           } else if (index >= 12 && index < 16 ) {
             var s = 16;
           } else {
             var s = 4;
           }
      } else if($(window).width() <= 614 && $(window).width() > 471) {
        // alert(index);
        if (index >= 0 && index < 3) {
             var s = 3;
           } else if (index >= 3 && index < 6 ) {
             var s = 6;
           } else if (index >= 6 && index < 9 ) {
             var s = 9;
           } else if (index >= 9 && index < 12 ) {
             var s = 12;
           } else if (index >= 12 && index < 15 ) {
             var s = 15;
           } else if (index >= 15 && index < 18 ) {
             var s = 16;
           } else {
             var s = 3;
           }
      } else if($(window).width() <= 471) {
        // alert(index);
        if (index >= 0 && index < 2) {
           var s = 2;
         } else if (index >= 2 && index < 4 ) {
           var s = 4;
         } else if (index >= 4 && index < 6 ) {
           var s = 6;
         } else if (index >= 6 && index < 8 ) {
           var s = 8;
         } else if (index >= 8 && index < 10 ) {
           var s = 10;
         } else if (index >= 10 && index < 12 ) {
           var s = 12;
         } else if (index >= 12 && index < 14 ) {
           var s = 14;
         } else if (index >= 14 && index < 16 ) {
           var s = 16;
         } else {
           var s = 2;
         }
      }

      if ($('.lst').find('.service-search-loading').length == 0) {
        $(".lst > .service-item:nth-child("+s+")").after('<div class="service-search-loading" style="display:block;margin: 50px;">'+
                                                            '<img src="assets/img/loading.gif" style="width:100px;height:100px;" alt="">'+
                                                          '</div>');
      }

      $.ajax({
         type: "GET",
         url: 'loads/services.php',
         data: {id: service_id, subcat, lang_id: lang},
         dataType: "html",
         success: function(data) {

          setTimeout(function () {
              jQuery(".service-search-loading").remove();

              $(".service_result").empty();
              $(".lst > .service-item:nth-child("+s+")").after(data);
           }, 500);
        }  // success
      }); // ajax

    if (subcat == 0) {
      $(location).attr('href','#cat='+service_id);
    } else {
      $(location).attr('href','#cat='+service_id+'#subcat='+subcat);
    }
  // scroll(".service_result");
} // end get services by category (responsive)

// get curent open service cat by url
$.urlParam = function(name){
	var results = new RegExp('[\#/]' + name + '=([^&#]*)').exec(window.location.href);
  if (results) {
    return results[1] || 0;
  }
}
// $('.serv-item').click(function() {
//   alert('ddd');
// })

var cat =  $.urlParam('cat');

if (cat) {
  var service_id = cat;
  var index = $('.service-item[rel='+service_id+']').index(this);
  var lang = $('.service-item[rel='+service_id+']').attr("lang");
  get_services(service_id,index,lang,0);
  $('.service-item[rel='+service_id+']').addClass("active");
}

  $(".lst").on("click", ".service-item",function() {

      var service_id = $(this).attr("rel");
      var index = $('.service-item').index(this);
      var lang = $('.service-item').attr("lang");

     if  ($(this).hasClass('active')) {
       $(this).removeClass("active");
       // get_services(service_id,index,lang);
       $(".service_result").remove();
       $(".service-search-loading").remove();
       // alert('..');
       $(location).attr('href','#');
     } else {
        $(".service-item").removeClass("active");
        $(this).addClass("active");
        get_services(service_id,index,lang,0);
     }
  });

  $(".lst").on("click", ".sub_cat_item",function() {
      var subcat = $(this).attr("rel");
      var parent = $(this).attr("parent");
      $('.service-item[rel='+parent+']').addClass("active");
      // $(".service-item").removeClass("active");
      $(this).addClass("active");
      get_services(parent,1,'ge',subcat);

  });

  // add service favorite
  $(document).on("click", ".add-f",function(e) {

    e.preventDefault();
    var id = $(this).attr('rel');
    var logo = $(this).attr('logo');

    // add html
    var fav_element = $(this).closest('.s-cov').closest('.s-cov').clone(true);
    $('.top-fav .container').append(fav_element);
    $('.top-fav .no-found').remove();
    // check if user logined
    $.ajax({url: "./user/session.php", success: function(data){
         if( data == 1){
           $.ajax({url: "./loads/favorites.php?action=add&id="+id+"&logo="+logo, success: function(d){
             $('.fov_palce_'+id).html('<div class="remove-f" title="ფავორიტებიდან წაშლა" rel="'+id+'"></div>');

             // $('.top-fav .container').append($(this).closest('.s-cov'));
             //var fav_element = $(this).closest('.s-cov');
             // $(this).closest('.s-cov').remove();
             // console.log(fav_element);
             // var fav_new = $('<div class="s-cov">');
             // fav_new.html(fav_element);
             // $('.top-fav .container').after(fav_element);

             if (d == 1) {
               flash_msg("succsess","სერვისა დამატებულია ფავორიტებში",id);
             } else if (d == 0) {
               flash_msg("error","სერვისი უკვე დამატებულია ფავორიტებში",id);
             }
             }});
         } else{
           popup("გაიარეთ ავტორიზაცია");
         }
    }});

  }); // reload

  // remove favorites
  $(document).on("click", ".remove-f",function(e) {

    e.preventDefault();
    var id = $(this).attr('rel');
    var is = $(this).attr('is');

    if (is == 1) {
      $(this).closest('.s-cov').remove();
    }

    // check if user logined
    $.ajax({url: "./user/session.php", success: function(data){
         if( data == 1){
           $.ajax({url: "./loads/favorites.php?action=remove&id="+id, success: function(d){
               flash_msg("succsess","სერვისი წაიშალა ფავორიტებიდან",id);
               $('.fov_palce_'+id).html('<div class="add-f" title="ფავორიტებში დამატება" rel="'+id+'"></div>');
             }});
         } else{
           popup("გაიარეთ ავტორიზაცია");
         }
    }});
  });

  $(document).on("click", ".check_uath",function(e) {

    e.preventDefault();
    var url = $(this).attr("href");

    // check if user logined
    $.ajax({url: "./user/session.php", success: function(data){
         if( data == 1){
           $(location).attr('href', url);
         } else{
           popup("გაიარეთ ავტორიზაცია");
         }
    }});
  });

  // service list searchs
$(document).ready(function(e) {
  $(document).click(function() {
      $(".service-search-result").hide();
      $(".search").removeClass('submited');
  });

  $(".ser-search-box").click(function(event) {
      $('.serach-inp').bind('keyup', function() {
        // $('.search').delay(200).submit();
      });
      event.stopPropagation();
  });

  $('.search').submit(function () {
    var query = $('#service_search_input').val();
    var service_lst = $('.service-search-item');

    search_service(query,service_lst)

    return false;
  });

  function search_service(query,service_lst) {
    if ( $.trim(query) !== '' ) {
      service_lst.addClass('hidden');
      $('.service-search-item[alt*="' + query.toLowerCase() + '"]').removeClass('hidden');
      $('.service-search-item:visible').last().css("border", "none");
      $(".service-search-result").css("visibility","visible");

      if ($('.service-search-item[alt*="' + query.toLowerCase() + '"]').length == 0) {
        $('.service_no_found').show();
      } else {
        $('.service_no_found').hide();
      }
    } else {
      $(".service-search-result").css("visibility","hidden");
    }
    $(".service-search-result").show();
    $(".search").addClass('submited');

  }

  $("#service_search_input").bind("change paste keyup", function() {
      var query = $(this).val();
      var service_lst = $('.service-search-item');
      search_service(query,service_lst);
  });
});

  // popup function
  function popup(msg) {
    $('body').append('<div class="popup" style="">'+
      '<div class="pupup-content">'+
        '<div class="remove"></div>'+
        '<h5 class="text-center">შეცდომა!</h5>'+
        '<p class="text-center">'+msg+'</p>'+
      '</div>'+
    '</div>');
  }

  // flash msg
  function flash_msg(status,msg,id) {

    if (status == "error") {
      $('body').append('<div class="flash-msg msg_error flash-msg_'+id+'" style="">'+
          '<a href="#" class="white-close"></a>'+
          '<span>'+msg+'</span>'+
      '</div>');
    } else if (status == "succsess") {
      $('body').append('<div class="flash-msg msg_succsess flash-msg_'+id+'" style="">'+
          '<a href="#" class="white-close"></a>'+
          '<span>'+msg+'</span>'+
      '</div>');
    }
    // remove
    setTimeout(function() {
      $('.flash-msg_'+id).remove();
    }, 2000);
  }
  // simple drop down
  // simple toggle
$('.drop').click(function(e) {
  e.preventDefault();
  var id = $(this).attr('rel');
  $('#'+id).toggle();
});
// simple slide
// $(document).ready(function(){
//   $(".slide-toggle").click(function(){
//     var id = $(this).attr('rel');
//     $('#'+id).animate({
//       width: "toggle"
//     });
//   });
// });

$('.drop-icon').click(function(e) {
  e.preventDefault();
  var id = $(this).attr('rel');
  if ($('.d-icon').hasClass('up-icon')) {
    $('.d-icon').removeClass('up-icon');
  } else {
    $('.d-icon').addClass('up-icon');
  }
  $('#'+id).toggle();
});

// ad simple toggle
$('.drop-t').click(function(e) {
  e.preventDefault();
  var id = $(this).attr('rel');
  $('#'+id).toggle();

  $('#'+id).css({
        position: 'absolute',
        top: $(this).height() +30+ 'px',
        left: $(this).offset().left + 'px',
        zIndex: 1000
    });
});

// close parent
$('.close').click(function(e) {
  e.preventDefault();
  $(this).parent().hide();
});
// close parent
$(document).on('click', '.white-close',function(e) {
  e.preventDefault();
  $(this).parent().remove();
});

// close parent parent
$(document).on('click', '.close-p',function(e) {
  e.preventDefault();
  $(this).parent().parent().hide();
});
// remove parent parent
$(document).on('click', '.remove',function(e) {
  e.preventDefault();
  $(this).parent().parent().remove();
});

// page load
$(document).ready(function() {
  setTimeout(function () {
      jQuery(".load-c").remove();
   }, 1000);
 });

 // float
$('.float').keypress(function(event) {
	 if ((event.which != 46 || $(this).val().indexOf('.') != -1) && (event.which < 48 || event.which > 57)) {
		 event.preventDefault();
	 }
 });
// check is input value integer
function isIntKey(evt) {
	var charCode = (evt.which) ? evt.which : event.keyCode;
	if (charCode > 31 && (charCode < 48 || charCode > 57)) {
		return false;
	} else {
		return true;
	}
}
//curency mask
$('#curency').inputmask("numeric", {
   radixPoint: ".",
   groupSeparator: ",",
   digits: 2,
   autoGroup: true,
   rightAlign: false,
   oncleared: function () { self.Value(''); }
});

 // recafch
 function reload(){
   $("#captcha").attr("src","").attr("src","https://leaderpay.ge/load/captcha.php");
 }
 // tefefhone mask
 // $("#phone").inputmask({"mask": "999 99 99 99"});

 //phone countryes
$("#phone").intlTelInput({
  hiddenInput: "full_phone",
  preferredCountries: ["ge"],
  utilsScript: "./assets/plugins/intl-tel-input/utils.js",
  separateDialCode: true,
});

// iframe popups
function iframe_popup(popup,url) {
  $(popup).show();
  $(popup+' #iframe iframe').attr('src',url);
}

// scroll
$(document).on('click', '.scroll-down', function(event) {
    var $anchor = $(this);
    $('html, body').stop().animate({
        scrollTop: $($anchor.attr('href')).offset().top
    }, 1500, 'easeInOutExpo');
    event.preventDefault();
});

// scroll
$(document).on('click', '.scroll', function(event) {
    var $anchor = $(this);
    $('html, body').stop().animate({
        scrollTop: $($anchor.attr('href')).offset().top
    }, 1500, 'easeInOutExpo');
    event.preventDefault();
});

// file upload
function upload(form) {

  $.ajax({
      type: 'POST',
      url: 'loads/upload.php',
      data: form,
      // enctype: 'multipart/form-data',
  });
  // console.log($(form).serializeArray());
}// file upload

//
$('#avatar_input').on('change',(function(e) {
  var data = $(".change_avatar");
  // console.log(data);
  var formData = new FormData(data);
  // upload(formData);
  console.log(formData);
}));

    // upload(this.closest("form"));
    // console.lgo(formData);
    // console.log($('#avatar_input').val());
    // $('.change_avatar').on('submit',(function(e) {
    //        e.preventDefault();
    //        var formData = new FormData(this);
    //        console.log(formData);
    //
    //        // $.ajax({
    //        //     type:'POST',
    //        //     url: $(this).attr('action'),
    //        //     data:formData,
    //        //     cache:false,
    //        //     contentType: false,
    //        //     processData: false,
    //        //     success:function(data){
    //        //         console.log("success");
    //        //         console.log(data);
    //        //     },
    //        //     error: function(data){
    //        //         console.log("error");
    //        //         console.log(data);
    //        //     }
    //        // });
    //    }));


// image upload preview
$(function() {
    // Multiple images preview in browser
    var imagesPreview = function(input, placeToInsertImagePreview) {

        if (input.files) {
                var reader = new FileReader();
                reader.onload = function(event) {
                    // $(placeToInsertImagePreview).empty();
                    // $(placeToInsertImagePreview).parent().css("display","block");
                    // $($.parseHTML('<img>')).attr('src', event.target.result).appendTo(placeToInsertImagePreview);
                    var id = $(input).attr('id');

                    if (id == "front") {
                      var doc = "#document_front";
                    } else if (id == "back") {
                      var doc = "#document_back";
                    } else if (id == "self") {
                      var doc = "#selfie";
                    }

                    $(doc).val(event.target.result);
                    $('#'+id).parents('.up-item').css("background", "url('"+event.target.result+"')");
                }
                reader.readAsDataURL(input.files[0]);
        }
    };

    $('.fileinput').on('change', function() {
        imagesPreview(this, '.img-result');

        // console.log(this);
    });
});

(function($){
	function injector(t, splitter, klass, after) {
		var a = t.text().split(splitter), inject = '';
		if (a.length) {
			$(a).each(function(i, item) {
				inject += '<span class="'+klass+(i+1)+'"><b>'+item+'</b></span>'+after;
			});
			t.empty().append(inject);
		}
	}

	var methods = {
		init : function() {

			return this.each(function() {
				injector($(this), '', 'char', '');
			});
		},

		words : function() {
			return this.each(function() {
				injector($(this), ' ', 'word', ' ');
			});
		},

		lines : function() {
			return this.each(function() {
				var r = "eefec303079ad17405c889e092e105b0";
				// Because it's hard to split a <br/> tag consistently across browsers,
				// (*ahem* IE *ahem*), we replaces all <br/> instances with an md5 hash
				// (of the word "split").  If you're trying to use this plugin on that
				// md5 hash string, it will fail because you're being ridiculous.
				injector($(this).children("br").replaceWith(r).end(), r, 'line', '');
			});
		}
	};

	$.fn.lettering = function( method ) {
		// Method calling logic
		if ( method && methods[method] ) {
			return methods[ method ].apply( this, [].slice.call( arguments, 1 ));
		} else if ( method === 'letters' || ! method ) {
			return methods.init.apply( this, [].slice.call( arguments, 0 ) ); // always pass an array
		}
		$.error( 'Method ' +  method + ' does not exist on jQuery.lettering' );
		return this;
	};

})(jQuery);
$(".slog").lettering();
// $(".head-elements .item .item div").lettering();
///
// tabbed content
    // $(".tab_content").hide();
    // $(".tab_content:first").show();

  /* if in tab mode */
    $("ul.tabs li").click(function() {
      $(".tab_content").hide();
      var activeTab = $(this).attr("rel");
      $("#"+activeTab).fadeIn();
      $("ul.tabs li").removeClass("active");
      $(this).addClass("active");
    });

	/* Extra class "tab_last"
	   to add border to right side
	   of last tab */
	$('ul.tabs li').last().addClass("tab_last");


// reload
$('.url').click(function() {
  var url = $(this).attr('data-url');
  window.location.replace(url);
});

function redirect_to(url,d) {
  setTimeout(function () {
      window.location.href = url;
   }, d);
}

// post
$(window).load(function() {
  $('.post-module').hover(function() {
    $(this).find('.description').stop().animate({
      height: "toggle",
      opacity: "toggle"
    }, 300);
  });
});

function counter(v) {
  $.ajax({
     type: "GET",
     url: 'loads/counter.php?'+v,
     data: '',
     dataType: "text",
     success: function(data) {
       // console.log(data);
       if (v == "operations") {
         $('.head-elements .item .item.operations').html(data);
         // $('.head-elements .item .item.operations div').html(data);
       } else if(v == "users") {
         $('.head-elements .item .item.users').html(data);
         // $('.head-elements .item  .item.users div').html(data);
       }
    }  // success
  }); // ajax
}// counters

setInterval(function(){ counter("operations"); }, 11000);
setInterval(function(){ counter("users"); }, 11000);
counter("operations");
counter("users");

// get curse
function getcurse() {
  $.ajax({
        type: "GET",
        url: "loads/curse.php",
        dataType: "html",
        success: function(html) {
            $('.curses').html(html);
        }
    });
// console.log($test.text(users));
}
getcurse();

// calculation percents
function calc1() {
    client_commission_percent = $('#client_commission_percent').val();
    client_commission_fixed = $('#client_commission_fixed').val();
    min_client_commission = $('#min_client_commission').val();
    max_client_commission = $('#max_client_commission').val();
    rate = $('#rate').val();
    rate_percent = $('#rate_percent').val();
    amount = $('#amount').val();

    client_commission_percent = parseFloat(client_commission_percent);
    client_commission_fixed = parseFloat(client_commission_fixed);
    min_client_commission = parseFloat(min_client_commission);
    max_client_commission = parseFloat(max_client_commission);
    rate = parseFloat(rate);
    rate_percent = parseFloat(rate_percent);
    amount = parseFloat(amount);

    if (isNaN(amount)) {
      amount = 0;
    }

    var genAmount = amount  / ((100 - client_commission_percent) / 100);
    genAmount = genAmount + client_commission_fixed;
    var differnece = genAmount - amount;

    if (differnece < min_client_commission && min_client_commission !== 0) {
        genAmount = genAmount + min_client_commission;
    }
    if (differnece > max_client_commission && max_client_commission !== 0) {
        genAmount = genAmount + max_client_commission;
    }

    var commission = genAmount - amount;
    var genRate = rate - (rate * (rate_percent / 100));
    genRate = genRate.toFixed(2);
    var commInGel = commission / genRate;
    var amountInGel = genAmount / genRate;

    amountInGel = parseFloat(amountInGel);
    commInGel = Math.round(commInGel * 100) / 100;
    amountInGel = Math.round(amountInGel * 100) / 100;

    if (isNaN(commInGel)) {
        commInGel = "";
    }
    if (isNaN(amountInGel)) {
        amountInGel = "";
    }

    $('#procent').val(commInGel);
    $('#generated').val(amountInGel);
} // end calculation percents

// re calc
function re_calc() {
    client_commission_percent = $('#client_commission_percent').val();
    client_commission_fixed = $('#client_commission_fixed').val();
    min_client_commission = $('#min_client_commission').val();
    max_client_commission = $('#max_client_commission').val();
    rate = $('#rate').val();
    rate_percent = $('#rate_percent').val();
    amount = $('#generated').val();

    client_commission_percent = parseFloat(client_commission_percent);
    client_commission_fixed = parseFloat(client_commission_fixed);
    min_client_commission = parseFloat(min_client_commission);
    max_client_commission = parseFloat(max_client_commission);
    rate = parseFloat(rate);
    rate_percent = parseFloat(rate_percent);
    amount = parseFloat(amount);

    if (isNaN(amount)) {
      amount = 0;
    }

    var genRate = rate - (rate * (rate_percent / 100));
    genRate = genRate.toFixed(4);
    var genAmountStart = genRate * amount;
    var genAmount = (genAmountStart - client_commission_fixed) - (genAmountStart * (client_commission_percent / 100));
    var differnece = genAmountStart - genAmount;

    if (differnece < min_client_commission && min_client_commission !== 0) {
        genAmount = genAmountStart - min_client_commission;
    }
    if (differnece > max_client_commission && max_client_commission !== 0) {
        genAmount = genAmountStart - max_client_commission;
    }

    var commission = genAmountStart - genAmount;
    var commInGel = commission / rate;

    if (genAmount === "NaN") {
        genAmount = 0;
    }
    if (commInGel === "NaN") {
        commInGel = 0;
    }
    genAmount = genAmount.toFixed(2);
    commInGel = commInGel.toFixed(2);
    if (genAmount === "NaN") {
        genAmount = "";
    }
    if (commInGel === "NaN") {
        commInGel = "";
    }
    if (isNaN(commInGel)) {
        commInGel = "";
    }

  $('#procent').val(commInGel);
  $('#amount').val(genAmount);
} // re calc

// function check_user_balance() {
//
//   var balance = '';
//   $.ajax({
//      type: "GET",
//      url: './user/session.php',
//      data: { "balance": "" },
//      dataType: "json",
//      success: function(data) {
//
//        balance = data.balance;
//        return false;
//
//     }  // success
//   }); // ajax
//   console.log( balance );
//
// }

// simple ajax
function s_ajax(type,url,form_data,datatype,load) {
  $.ajax({
    type: type,
    url: url,
    data: form_data,
    dataType: datatype,
     success: function(data) {

       var json = JSON.parse(data);

       if (json.code == 1) {
         $(load).html('<div class="msg msg-succses" style="margin-top:30px">'+json.msg+'</div>');
         //kakha reload
            setInterval(function() {
               location.reload();
           },1000);
            //end kakha
       } else {
         $('.loads').append('<div class="msg msg-error" style="margin-top:30px">'+json.msg+'</div>');
         // $(load).append(data);
       }
       // window.location.replace('https://leaderpay.ge/profile.php');
    }  // success
  }); // ajax

}

function load_infos(form,confirm) {
  var form_data = $(form).serializeArray();
  var url = $(form).attr('action');
  var generated = $(form).find('#generated').val();
  generated = parseFloat(generated);
  var balance = parseFloat(0);

    if ($(form).hasClass("pay")) {
    // check user balance
    $.ajax({
       type: "GET",
       url: './user/session.php',
       data: { "balance": "" },
       dataType: "json",
       success: function(data) {

         balance = data.balance;
         if (generated > balance ) {
           popup("თქვენს ანგარიშზე არ არის საკმარისი თანხა ტრანზაქციის განსახორციელებლად!");
         } else {
           // confirm
           if (confirm == 1) {
             pay_popup();
             $('.confirm_pay').click(function() {
               s_ajax("POST",url,form_data,"html",".pay");
             });
           } else {
             s_ajax("POST",url,form_data,"html",".load_carts");
             $('.pay').hide();
           }// confirm
         } // check balance
      }  // success
    }); // ajax

  } else {
    // loading
    var load_btn = $(form).find('.btn-load');
    $(load_btn).find('span').css("visibility","hidden");
    $(load_btn).append('<div class="min-loader">'+
                       '<div class="circle circle--white"></div>'+
                       '<div class="circle circle--white"></div>'+
                       '<div class="circle circle--white"></div>'+
                     '</div>');
    // loading
      $.ajax({
         type: "POST",
         url: url,
         data: form_data,
         dataType: "html",
         success: function(data) {

             // loading
           $(load_btn).find('span').css("visibility","visible");
           $(load_btn).find('.min-loader').remove();
           // loading

           if ($(form).attr('rol') == 'redirect') {

             if ($(form).find('.msg-error').length <= 1) {
               var json = JSON.parse(data);

               if (json.code == 1) {
                 var service_id  = $('#s_i').attr('rel');

                 $(form).attr('rol','');
                 $(form).attr('action','loads/service.php?action=info');
                 $('#service_id').val(json.service_id);
                 $('.pay-service-t').html(json.name_ge);
                 $('.pay_service-logo img').attr("src","https://uploads.allpayway.ge/files/services/"+json.image);

                   // for xpay
                   if (typeof json.loan !== 'undefined') {
                       $(form).prepend('<input name="loan" type="hidden" value="' + json.loan + '">');
                   }

                 // comissions
                 $.ajax({
                    type: "GET",
                    url: "loads/service.php?action=service&id="+json.service_id,
                    dataType: "json",
                    success: function(data) {
                      // console.log(data);
                      $('#client_commission_percent').val(data.commission.client_commission_percent);
                      $('#client_commission_fixed').val(data.commission.client_commission_fixed);
                      $('#min_client_commission').val(data.commission.min_client_commission);
                      $('#max_client_commission').val(data.commission.max_client_commission);
                      $('#rate').val(data.commission.rate);
                      $('#rate_percent').val(data.commission.rate_percent);
                    }
                  });

                 $(form).submit();
               } else {
                 $('.loads').html('<div class="msg msg-error" role="alert">'+json.msg+'</div>');
               } // eror code
             } // error label
           } else {

               var service_id  = $('#service_id').val();

               if (service_id == 114 ) {
                   $('.loads').html(data);
                   $(form).attr('action','loads/service.php?action=redirect');
                   $(form).attr('rol','redirect');
               } else {

                   $('.loads').html(data);

                   if ($(form).find('.msg-error').length <= 1) {
                       $(form).attr('action','loads/service.php?action=pay');
                       $(form).addClass('pay');
                       $('.user_input').attr('readonly', '');
                       $(load_btn).find('span').text("გადახდა");
                       // save btn
                       $('.p-btns .col-md-12').attr('class', 'col-md-8');
                       $('.p-btns .col-md-4').removeClass('none');
                   }

               }

           }
           // console.log(data);
        }  // success
      }); // ajax
  } //
}

// pay popup
function pay_popup() {
  var service = $('.pay-service-t').text();
  var user = $('.user_input ').val();
  var amount = $('#amount').val();
  var percent = $('#procent').val();
  var genamount =$('#generated').val();

  var output = '<div class="popup" style="">';
      output +=   '<div class="pupup-content">';
      output +=      '<div class="remove"></div>';
      output +=       '<h5 class="text-center" style="margin-bottom: 30px;font-family: title;">გადარიცხვის დადასტურება</h5>';
      output +=       '<ul class="list">';
      output +=       '<li class="clear">';
      output +=       '<div class="col-md-5 li-block">';
      output +=       'სერვისი';
      output +=       '</div>';
      output +=       '<div class="col-md-7 li-block">';
      output +=       service;
      output +=       '</div>';
      output +=       '</li>';
      output +=       '<li class="clear">';
      output +=       '<div class="col-md-5 li-block">';
      output +=       'აბონენტი';
      output +=       '</div>';
      output +=       '<div class="col-md-7 li-block">';
      output +=       user;
      output +=       '</div>';
      output +=       '</li>';
      output +=       '<li class="clear">';
      output +=       '<div class="col-md-5 li-block">';
      output +=       'ჩასარიცხი თანხა';
      output +=       '</div>';
      output +=       '<div class="col-md-7 li-block">';
      output +=       amount;
      output +=       '</div>';
      output +=       '</li>';
      output +=       '<li class="clear">';
      output +=       '<div class="col-md-5 li-block">';
      output +=       'საკომისიო';
      output +=       '</div>';
      output +=       '<div class="col-md-7 li-block">';
      output +=       percent;
      output +=       '</div>';
      output +=       '</li>';
      output +=       '<li class="clear">';
      output +=       '<div class="col-md-5 li-block">';
      output +=       'ჩამოგეჭრებათ';
      output +=       '</div>';
      output +=       '<div class="col-md-7 li-block">';
      output +=       genamount;
      output +=       '</div>';
      output +=       '</li>';
      output +=       '</ul>';
      output +=       '<button type="submit" class="g1-btn btn-b confirm_pay" name="submit"><i class="fa fa-check"></i> დადასტურება</button>';
      output +=    '</div>';
      output += '</div>';

      $('.sub-page-body').append(output);
      $('.confirm_pay').click(function() {
        $(this).parent().parent().remove();
      });
}
// pay popup

// pay popup by params
function pay_popup_by_params(service, user, amount, percent, genamount, sms) {

  var output = '<div class="popup" style="">';
      output +=   '<div class="pupup-content">';
      output +=      '<div class="remove"></div>';
      output +=       '<h5 class="text-center" style="margin-bottom: 30px;font-family: title;">გადარიცხვის დადასტურება</h5>';
      output +=       '<ul class="list">';
      output +=       '<li class="clear">';
      output +=       '<div class="col-md-5 li-block">';
      output +=       'სერვისი';
      output +=       '</div>';
      output +=       '<div class="col-md-7 li-block">';
      output +=       service;
      output +=       '</div>';
      output +=       '</li>';
      output +=       '<li class="clear">';
      output +=       '<div class="col-md-5 li-block">';
      output +=       'აბონენტი';
      output +=       '</div>';
      output +=       '<div class="col-md-7 li-block">';
      output +=       user;
      output +=       '</div>';
      output +=       '</li>';
      output +=       '<li class="clear">';
      output +=       '<div class="col-md-5 li-block">';
      output +=       'ჩასარიცხი თანხა';
      output +=       '</div>';
      output +=       '<div class="col-md-7 li-block">';
      output +=       amount;
      output +=       '</div>';
      output +=       '</li>';
      output +=       '<li class="clear">';
      output +=       '<div class="col-md-5 li-block">';
      output +=       'საკომისიო';
      output +=       '</div>';
      output +=       '<div class="col-md-7 li-block">';
      output +=       percent;
      output +=       '</div>';
      output +=       '</li>';
      output +=       '<li class="clear">';
      output +=       '<div class="col-md-5 li-block">';
      output +=       'ჩამოგეჭრებათ';
      output +=       '</div>';
      output +=       '<div class="col-md-7 li-block">';
      output +=       genamount;
      output +=       '</div>';
      output +=       '</li>';
      output +=       '</ul>';

        if (sms == 1) {
          output +=       '<ul class="list">';
            output +=       '<li class="clear">';
              output +=        '<div class="form-group">';
                output +=        '<label for="code">SMS-ით მიღებული კოდი</label>';
                output +=        '<div class="send_btn">';
                  output +=        '<span> <img src="/assets/img/sms.png" alt="send"> გაგზავნა</span>';
                output +=        '</div>';
                output +=        '<input onkeypress="return isIntKey(event);" data-rule-required="true" maxlength="6" minlength="6" name="code" type="txt" id="code" class="gen_code input" autocomplete="off">';
              output +=      '</div>';
            output +=       '</li>';
          output +=       '</ul>';
        }
        output +=       '<button type="submit" class="g1-btn btn-b confirm_pay" name="submit"><i class="fa fa-check"></i> დადასტურება</button>';
      output +=    '</div>';
      output += '</div>';

      $('.sub-page-body').append(output);
      $('.confirm_pay').click(function() {
        $(this).parent().parent().remove();
      });
}
// pay popup by params

//ssave service
function save_service() {
  if ($("#service_form").valid()) {
    var form_data = $("#service_form").serializeArray();

    $('.sv-btn').append('<div class="min-loader">'+
                       '<div class="circle circle--white"></div>'+
                       '<div class="circle circle--white"></div>'+
                       '<div class="circle circle--white"></div>'+
                     '</div>');
    $('.sv-btn span').css("visibility","hidden");

    $.ajax({
      type: "POST",
      url: "loads/service.php?action=save_service",
      data: form_data,
      dataType: "json",
       success: function(data) {

         if (data.code == 1) {
           // change count
           var count = $(".cart .count").text();
           count = parseInt(count);
           var nev_count = count + 1;
           $(".cart .count").text(nev_count);

           setTimeout(function () {
             $('.sv-btn .min-loader').remove();
             $('.sv-btn').append('<i class="fa fa-check"></i>');
             $('.sv-btn').removeClass('<i class="fa fa-check"></i>');
            }, 500);
         } else {
         }
      }
    });
  } 
}

function transfers(form, amount) {
  var form_data = $(form).serializeArray();
  var url = $(form).attr('action');
  var method = $(form).attr('rel');
  url = url + '?method=' + method;

  $('.transfer').append('<div class="min-loader">'+
                     '<div class="circle circle--white"></div>'+
                     '<div class="circle circle--white"></div>'+
                     '<div class="circle circle--white"></div>'+
                   '</div>');
  $('.transfer span').css("visibility","hidden");

  $.ajax({
     type: "POST",
     url: url,
     data: form_data,
     dataType: "json",
     success: function(data) {

       if (method == "info") {
         setTimeout(function () {
           $('.transfer .min-loader').remove();
           $('.transfer span').css("visibility","visible");
           $(form).find('.msg').remove();

           if (data.errorCode == 10) {
             $('.load_labels').show();
             
             $.each(data.data, function (k, v) {
               $('.load_labels').prepend('<div class="form-group col-md-12">'+
                        '<label for="'+ k +'">'+ k +'</label>'+
                        '<input type="text" name="'+ k +'" id="'+ k +'" readonly="" class="input" value="'+ v +'">'+
                      '</div>');
             });

             $.each(data.percents, function (k, v) {
               $('.load_labels').prepend('<input name="'+ k +'" type="hidden" id="'+ k +'" value="'+ v +'" class="input">');
             });
             $('#to').attr('readonly','true');
             $(form).attr('rel', 'pay');
           } else {
             $(form).prepend('<div class="msg col-md-12"><div class="msg msg-error" role="alert">'+ data.errorMessage +'</div></div>');
           }
         }, 500);
       } 

       if (method == "pay") {
          setTimeout(function () {
           $('.transfer .min-loader').remove();
           $('.transfer span').css("visibility","visible");

           if (data.errorCode == 10) {
             $(form).empty();
             $(form).prepend('<div class="msg msg-succses" role="alert">'+ data.errorMessage +'</div>');

             $.ajax({
              type: "GET",
              url: './user/session.php',
              data: { "balance": "" },
              dataType: "json",
              success: function(data) {
                balance = data.balance;
                $.ajax(
                  {url: "./../profile.php", success: function(d){
                    $('.user_balance').replaceWith('<span>'+ balance +
                    '<span class="lari" style="float: right; padding-top: 0;">¢</span> '+
                    '</span>' );
                    }
                });
              }
            });
           } else if(data.errorCode == 1)  {
             $(form).empty();
             $(form).prepend('<div class="msg msg-error" role="alert">'+ data.errorMessage +'</div>');
           } else {
             $(form).find('.msg').remove();
             $(form).prepend('<div class="msg msg-error" role="alert">'+ data.errorMessage +'</div>');
           }
         }, 500);
       }
    }
  });
}

function simple_comission() {
  var amount = parseFloat($('#amount').val());
  var percent = parseFloat($('#percent').val());
  var min = parseFloat($('#min').val());
  var commission = parseFloat($('#commission').val());
  commission = ( amount / 100 ) * percent;

  if (min > commission) {
    commission = min;
  }

  var gen_amount = amount + commission;
  commission = commission.toFixed(2);
  gen_amount = gen_amount.toFixed(2);

  $('#com').val(commission);
  $('#generated').val(gen_amount);
}

// load saved services
function load_saved_services(service_id) {
  $('.load_carts').html('<div class="service-search-loading" style="display:block;margin: 50px;">'+
                                  '<img src="assets/img/loading.gif" style="width:100px;height:100px;" alt="">'+
                                '</div>');


  if (service_id == 0) {
    var url = "loads/saved_services.php?saved_services_list=";
  } else {
    var url = "loads/saved_services.php?saved_services_list_by_id="+service_id;
  }

  $.ajax({
    type: "GET",
    url: url,
    data: "",
    dataType: "json",
     success: function(data) {

       var append = "";

       $.each(data.data, function(k, v) {

           // infos
           var info_params = $.parseJSON(v.json);
           var url1 = "loads/service.php?action=service_json&service_id="+v.service_id;

           $.ajax({
             type: "POST",
             url: url1,
             data: info_params,
             dataType: "json",
              success: function(data) {

                console.log(data);

                 append += '<form class="pay" id="service_form_'+v.id+'" rol="loads/service.php?action=pay" action="loads/service.php?action=pay" method="post" novalidate="novalidate">';
                 append += '<li class="clear">';
                 append += '<div class="col-md-1 li-block">';
                 append += '<img src="https://uploads.allpayway.ge/files/services/'+data.image+'" alt="">';
                 append += '</div>';
                 append += '<div class="col-md-2 li-block">';
                 append += data.lang.GE;
                 append += '</div>';
                 append += '<div class="col-md-2 li-block">';

                 $.each(info_params, function(k, v) {
                   append += v;
                   return false;
                 }); // end loop

                 append += '</div>';
                 append += '<div class="col-md-2 li-block">';

                 // debt
                 if (typeof(info_params.debt) != "undefined" && info_params.debt !== null) {
                   append += info_params.debt;
                 } else {
                   append += '  0';
                 }

                 $.each(info_params, function(k, v) {
                   $.each(data.params_pay, function(p_k, p_v) {
                     if (p_v.name == k) {
                       append += '<input name="'+k+'" type="hidden" id="'+k+'" value="'+v+'" readonly>';
                     }

                     if (p_v.name == "birthdate") {
                       var birthdate = info_params.day+'-'+info_params.month+'-'+info_params.year;
                       append += '<input name="'+p_v.name+'" type="hidden" id="'+p_v.name+'" value="'+birthdate+'" readonly>';
                     }
                   }); // loop 2
                 }); // loop 1

                 append += '</div>';
                 append += '<div class="col-md-2 li-block">';

                 // debt
                 if (typeof(info_params.debt) != "undefined" && info_params.debt !== null) {
                   append += '  <input type="text" name="amount" id="amount_'+v.id+'" class="amount float" value="'+info_params.debt+'" autocomplete="off">';
                 } else {
                   append += '  <input type="text" name="amount" id="amount_'+v.id+'" class="amount float" value="'+info_params.amount+'" autocomplete="off">';
                 }
                 append += '  <input type="hidden" name="procent" id="procent_'+v.id+'" class="percent float" value="" readonly>';
                 append += '  <input type="hidden" name="generated" id="generated_'+v.id+'" class="genamount float" value="" readonly>';
                 append += '  </div>';
                 append += '<input name="" type="hidden" class="sms" value="'+data.sms+'">';
                 append += '<input name="code" type="hidden" class="code" value="" required>';
                 append += '<input name="service_id" type="hidden" id="service_id" value="'+data.id+'">';
                 append += '<input name="" type="hidden" class="client_commission_percent_'+v.id+'" value="'+data.commission.client_commission_percent+'" disabled="">';
                 append += '<input name="" type="hidden" class="client_commission_fixed_'+v.id+'" value="'+data.commission.client_commission_fixed+'" disabled="">';
                 append += '<input name="" type="hidden" class="min_client_commission_'+v.id+'" value="'+data.commission.min_client_commission+'" disabled="">';
                 append += '<input name="" type="hidden" class="max_client_commission_'+v.id+'" value="'+data.commission.max_client_commission+'" disabled="">';
                 append += '<input name="" type="hidden" class="rate_'+v.id+'" value="'+data.commission.rate+'" disabled="">';
                 append += '<input name="" type="hidden" class="rate_percent_'+v.id+'" value="'+data.commission.rate_percent+'" disabled="">';
                 append += '  <div class="col-md-3 li-block text-right">';

                 $.each(info_params, function(s_k, s_v) {
                   append += '    <button type="submit" name="pay" class="g1-btn btn-load template-pay-btn" data-name="'+data.lang.GE+'" data-user="'+s_v+'" data-id="'+v.id+'" data-amount="'+info_params.amount+'"> <i class="fa fa-angle-right"></i> გადახდა</button>';

                   return false;
                 }); // end loop

                 append += '    <a href="#" class="btn-i delete_saved_service" rel="'+v.id+'" title="წაშლა"> <i class="fa fa-times"></i></a>';
                 append += '  </div>';
                 append += '</li>';
                 append += '</div>';
                 append += '</form>';

                 $(document).on("keyup","#amount_"+v.id, function(e) {
                   var amount = $(this).val();
                   // alert('aaa');
                   calculation_by_variables(v.id,data.commission.client_commission_percent,data.commission.client_commission_fixed,data.commission.min_client_commission,data.commission.max_client_commission,data.commission.rate,data.commission.rate_percent,amount);
                 });

                 // minappend

                 var m_append = '';
                     m_append += '<form class="pay" id="service_form_'+v.id+'" rol="loads/service.php?action=pay" action="loads/service.php?action=pay" method="post" novalidate="novalidate">';
                       m_append += '<div class="col-md-12 st-item">';
                        m_append += '<div class="col-md-6">';

                        $.each(info_params, function(k, v) {
                          m_append += v;
                          return false;
                        }); // end loop

                        m_append += '</div>';
                        m_append += '<div class="col-md-4">';
                        // m_append += '  <div class="amount-circle">';
                        // m_append += info_params.amount+' <span class="lari" style="float: right;padding-top: 0;">¢</span>';
                        // m_append += '  </div>';

                        // debt
                        if (typeof(info_params.debt) != "undefined" && info_params.debt !== null) {
                          m_append += '  <input type="text" name="amount" id="amount_'+v.id+'" class="amount float" value="'+info_params.debt+'" autocomplete="off">';
                        } else {
                          m_append += '  <input type="text" name="amount" id="amount_'+v.id+'" class="amount float" value="'+info_params.amount+'" autocomplete="off">';
                        }

                        m_append += '</div>';
                        m_append += '<div class="col-md-2">';

                        $.each(info_params, function(k, v) {
                          $.each(data.params_pay, function(p_k, p_v) {
                            if (p_v.name == k) {
                              m_append += '<input name="'+k+'" type="hidden" id="'+k+'" value="'+v+'" readonly>';
                            }
                            if (p_v.name == "birthdate") {
                              var birthdate = info_params.day+'-'+info_params.month+'-'+info_params.year;
                              m_append += '<input name="'+p_v.name+'" type="hidden" id="'+p_v.name+'" value="'+birthdate+'" readonly>';
                            }
                          }); // loop 2
                        }); // loop 1

                        m_append += '<input type="hidden" name="procent" id="procent_'+v.id+'" class="percent float" value="" readonly>';
                        m_append += '<input type="hidden" name="generated" id="generated_'+v.id+'" class="genamount float" value="" readonly>';
                        m_append += '<input name="" type="hidden" class="sms" value="'+data.sms+'">';
                        m_append += '<input name="code" type="hidden" class="code" value="" required>';
                        m_append += '<input name="service_id" type="hidden" id="service_id" value="'+data.id+'">';
                        m_append += '<input name="" type="hidden" class="client_commission_percent_'+v.id+'" value="'+data.commission.client_commission_percent+'" disabled="">';
                        m_append += '<input name="" type="hidden" class="client_commission_fixed_'+v.id+'" value="'+data.commission.client_commission_fixed+'" disabled="">';
                        m_append += '<input name="" type="hidden" class="min_client_commission_'+v.id+'" value="'+data.commission.min_client_commission+'" disabled="">';
                        m_append += '<input name="" type="hidden" class="max_client_commission_'+v.id+'" value="'+data.commission.max_client_commission+'" disabled="">';
                        m_append += '<input name="" type="hidden" class="rate_'+v.id+'" value="'+data.commission.rate+'" disabled="">';
                        m_append += '<input name="" type="hidden" class="rate_percent_'+v.id+'" value="'+data.commission.rate_percent+'" disabled="">';

                        $.each(info_params, function(s_k, s_v) {
                          m_append += '    <button type="submit" name="pay" class="g1-btn btn-load template-pay-btn" data-name="'+data.lang.GE+'" data-user="'+s_v+'" data-id="'+v.id+'" data-amount="'+info_params.amount+'"> <i class="fa fa-angle-right"></i></button>';

                          return false;
                        }); // end loop

                        m_append += '</div>';
                      m_append += '</div>';
                     m_append += '</form>';

               // console.log(append);
               setTimeout(function () {
                   $(".service-search-loading").remove();

                   if (service_id == 0) {
                     $(".load_carts").html(append);
                   } else {
                     $(".short-templates").show();
                     $(".short-templates").append(m_append);
                   }
                }, 500);
             }  // success
           }); // ajax
           // console.log(info_params);
       }); // loop
       //


       $(document).on("click",".template-pay-btn", function(e) {

         // calc
         var id = $(this).attr('data-id');
         var amount = $(this).parent().parent().find('.amount').val();

         var sms = $(this).parent().parent().find('.sms').val();
         var code = $(this).parent().parent().find('.code');


         var client_commission_percent = $(this).parent().parent().find('.client_commission_percent_'+id).val();
         var client_commission_fixed = $(this).parent().parent().find('.client_commission_fixed_'+id).val();
         var min_client_commission = $(this).parent().parent().find('.min_client_commission_'+id).val();
         var max_client_commission = $(this).parent().parent().find('.max_client_commission_'+id).val();
         var rate = $(this).parent().parent().find('.rate_'+id).val();
         var rate_percent = $(this).parent().parent().find('.rate_percent_'+id).val();

         calculation_by_variables(id,client_commission_percent,client_commission_fixed,min_client_commission,max_client_commission,rate,rate_percent,amount);

         var service = $(this).attr('data-name');
         var user = $(this).attr('data-user');
         var percent = $(this).parent().parent().find('.percent').val();
         var genamount = $(this).parent().parent().find('.genamount').val();
         // var amount = $('.amount').val();

          pay_popup_by_params(service,user,amount,percent,genamount,sms);

         e.preventDefault();
         //

         $(document).on("click",".confirm_pay", function(e1) {
           // console.log("one");
           e1.preventDefault();

           var gen_code = $(this).parent().find('.gen_code').val();

           $(code).val(gen_code);

           // check user balance
           var balance = parseFloat(0);
           genamount = parseFloat(genamount);

           $.ajax({
              type: "GET",
              url: './user/session.php',
              data: { "balance": "" },
              dataType: "json",
              success: function(data) {

                balance = data.balance;
                if (genamount > balance ) {
                  popup("თქვენს ანგარიშზე არ არის საკმარისი თანხა ტრანზაქციის განსახორციელებლად!");
                } else {
                  // check sms
                  if (sms == 1 ) {
                    if (gen_code.toString().length == 6) {
                      load_infos($('#service_form_'+id),0);
                    } else {
                      popup("sms კოდი არასწორია!");
                    } // check sms  lenght
                  } else {
                    load_infos($('#service_form_'+id),0);
                  } // check sms
                } // check balance
              }  // success
            }); // ajax
         }); // confirm_pay
       }); // template-pay-btn
       $(".service-search-loading").remove();
    }  // success
  }); // ajax
}// load saved services

function delete_saved_services(service_id) {
  $.ajax({
    type: "GET",
    url: "loads/saved_services.php?delete="+service_id,
    data: "",
    dataType: "json",
     success: function(data) {
       if (data.code == 1) {
         // change count
         var count = $(".cart .count").text();
         count = parseInt(count);
         var nev_count = count - 1;
         $(".cart .count").text(nev_count);
       }
    }
  });
}

$(document).on("click",".delete_saved_service", function(e) {
  e.preventDefault();

  var service_id = $(this).attr('rel');
  delete_saved_services(service_id);
  $(this).parent().parent().remove();
});

// transactionjs filter
function transactions_filter(form,limit) {
  var data = $(form).serializeArray();
  var url = $(form).attr('action');
  // console.log(data);
  data.push({name: "limit", value: limit});

  $('.transactions_load').html('<div class="service-search-loading" style="display:block;margin: 50px;">'+
                                  '<img src="assets/img/loading.gif" style="width:100px;height:100px;" alt="">'+
                                '</div>');

  $.ajax({
     type: "POST",
     url: url,
     data: data,
     dataType: "json",
     success: function(data) {

       var append_str = "";

       if (data.count > 0) {
         $.each(data.transactions, function(i, item) {
             append_str += '<tr class="filtered_item">';
             append_str += '<td>'+item.date+'</td>';
             append_str += '<td>'+item.description+'</td>';
             // append_str += '<td>'+item.status+'</td>';
             append_str += '<td>'+item.amount+'</td>';
             // append_str += '<td>0</td>';
             append_str += '<td>'+item.balance+'</td>';
             append_str += '</tr>';
             // console.log(item);
          });
       } else {
         append_str += '<div class="no-found">';
         append_str += '<img src="assets/img/not.png" alt="no found">';
         append_str += '<span>სია ცარიელია</span>';
         append_str += '</div>';
       }

       var all = parseInt($(".more_t").attr('rel'));

       if (data.count <= all) {
         $('.more_t').hide();
       } else {
         $('.more_t').show();
       }

       setTimeout(function () {
           $(".service-search-loading").remove();
           $('.transactions_load').html(append_str);

        }, 500);
    }  // success
  }); // ajax
}

$(document).ready(function() {
  $('.reset_filter').click(function() {
    $('.transactions_filter').trigger("reset");
    transactions_filter(".transactions_filter",10);
  });

  $('.trans-filter-item').change(function() {
    var form = $('.transactions_filter');
    transactions_filter(form,10);
  });

  $('.more_t').click(function (e)  {
    e.preventDefault();

    var all = parseInt($(".filtered_item").attr('rel'));
    var c = parseInt($(this).attr('rel'));

    c = c + 10;

    $(this).attr('rel', c);
    $(".transactions_filter").trigger("change");

    var form = $('.transactions_filter');

    transactions_filter(".transactions_filter",c);
  });
  transactions_filter(".transactions_filter",10);
});

// calculation percents by variables
function calculation_by_variables(id,client_commission_percent,client_commission_fixed,min_client_commission,max_client_commission,rate,rate_percent,amount) {
    client_commission_percent = parseFloat(client_commission_percent);
    client_commission_fixed = parseFloat(client_commission_fixed);
    min_client_commission = parseFloat(min_client_commission);
    max_client_commission = parseFloat(max_client_commission);
    rate = parseFloat(rate);
    rate_percent = parseFloat(rate_percent);
    amount = parseFloat(amount);

    if (isNaN(amount)) {
      amount = 0;
    }

    var genAmount = amount  / ((100 - client_commission_percent) / 100);
    genAmount = genAmount + client_commission_fixed;
    var differnece = genAmount - amount;

    if (differnece < min_client_commission && min_client_commission !== 0) {
        genAmount = genAmount + min_client_commission;
    }
    if (differnece > max_client_commission && max_client_commission !== 0) {
        genAmount = genAmount + max_client_commission;
    }

    var commission = genAmount - amount;
    var genRate = rate - (rate * (rate_percent / 100));
    genRate = genRate.toFixed(2);
    var commInGel = commission / genRate;
    var amountInGel = genAmount / genRate;
    amountInGel = parseFloat(amountInGel);
    commInGel = Math.round(commInGel * 100) / 100;
    amountInGel = Math.round(amountInGel * 100) / 100;

    if (isNaN(commInGel)) {
        commInGel = "";
    }
    if (isNaN(amountInGel)) {
        amountInGel = "";
    }

    $('#procent_'+id).val(commInGel);
    $('#generated_'+id).val(amountInGel);
}
