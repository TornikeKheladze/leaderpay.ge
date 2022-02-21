<div class="title">ჩემი შაბლონები</div>
<div class="sub-page-body">
  <div class="loads"></div>
  <ul class="list">
    <li class="clear head">
      <div class="col-md-1 li-block" title="ლოგო">
        ლოგო
      </div>
      <div class="col-md-2 li-block" title="სახელი">
        სახელი
      </div>
      <div class="col-md-2 li-block" title="აბონენტი">
        აბონენტი
      </div>
      <div class="col-md-2 li-block" title="დავალიანება">
        დავალიანება
      </div>
      <div class="col-md-2 li-block" title="თანხა">
        თანხა
      </div>
      <div class="col-md-3 li-block text-right">
        მოქმედება
      </div>
    </li>
    <div class="load_carts">

    </div>
  </ul>

</div>

<script>

  $(document).ready(function() {

    load_saved_services(0);

  });

function send_sms(data) {

  //

  $.ajax({
     type: "POST",
     url: 'https://apw.ge/loads/sms.php?send',
     data: data,
     dataType: "json",
     success: function(data) {

       if (data.errorCode != 100) {

         $('body').prepend('<div class="msg msg-error" style="margin-top:30px" style="margin-top:10px">'+
                             data.errorMessage+
                           '</div>');

       }

    }  // success

  }); // ajax

} // send_sms


$(document).ready(function() {

  // timer
  function timer(timer) {

    var interval = setInterval(function() {
        timer--;
        $('#timer').text(timer);
        if (timer === 0) clearInterval(interval);
    }, 1000);

  }


  var clickDisabled = false;

  $(document).on('click', '.send_btn', function() {

      if (clickDisabled) {

        return false;

      }

      // loading
      var load_btn = $('.send_btn');
      $(load_btn).find('span').css("visibility","hidden");
      $(load_btn).append('<div id="timer">60</div>');
      // loading

      timer(60);



      // delete session
      $.get("https://apw.ge/loads/sms.php?delete_sesion", function(){});

      <?php

          $send_params = array(
            "destination" => $user['mobile'],
            "sender" => 'apw.ge',
          );

       ?>

      send_sms(<?php echo json_encode($send_params); ?>);

      clickDisabled = true;

      setTimeout(function(){

        clickDisabled = false;

        // loading
        $(load_btn).find('span').css("visibility","visible");
        $(load_btn).find('#timer').remove();
        // loading

        // delete session
        $.get("https://apw.ge/loads/sms.php?delete_sesion", function(){});

      }, 60000);

  });


});


</script>
