<?php

// check service id
if (isset($_GET['id']) && $_GET['id'] != '') {

  $service_id = intval($_GET['id']);

} else {

  header('Location: services.php');
}



$service = $billing->get_service_info($service_id);

?>
<div class="sub-page-body clear">
  <div class="row">
    <div class="load_carts"></div>
    <div class="pay">


      <?php

        if (is_array($service) AND $service['id'] != 46) {

          $lng = strtoupper($lang_id);

          ?>

          <div class="col-md-4">
            <a href="?action=services#cat=<?php echo $service['category_id']; ?>" class="go-back"> <img src="assets/img/back.png" alt=""> <?php echo $lang['go_to_back']; ?></a>
            <h4 class="pay-service-t"><?php echo $service['lang'][$lng]; ?></h4>
            <div class="pay_service-logo">
              <img src="https://uploads.allpayway.ge/files/services/<?php echo $service['image']; ?>" class="img-responsive" alt="<?php echo $service['lang'][$lng]; ?>">
            </div>
            <div class="short-templates clear none">
            </div>
            <script>

              $(document).ready(function() {

                load_saved_services(<?php echo $service_id; ?>);

              });

            </script>
          </div><!-- end col-md-4 div -->
          <div class="col-md-8 b-left">
            <form class="clear" id="service_form" rol="<?php if($service_id == 3 OR $service_id == 4) {echo "redirect"; } else { echo ""; } ?>" action="<?php if($service_id == 3 OR $service_id == 4) {echo "loads/service.php?action=redirect"; } else { echo "loads/service.php?action=info"; } ?>" method="post">
              <div class="msg-area"></div>
              <div class="row">
                <div class="col-md-12">
                  <div class="msg msg-error" style="display:none"><?php echo $lang['required']; ?></div>
                </div>
              </div>
              <?php

              foreach ($service['params_info'] as $key) {

                // if is birthdate
                if ($key['name'] == "birthdate") {

                  ?>

                  <div class="form-group">
                    <label for="<?php echo $key['name']; ?>"><?php echo $key['description']; ?></label>

                    <div class="row date-row">
                      <div class="col-md-4 col-sm-4 col-xs-4">
                        <select name="year" id="year" class="input select2-container select2me">
                          <option value=""><?php echo $lang['year']; ?></option>

                          <?php foreach ($year_array as $year) { ?>

                            <?php if ($year > 2000 ) { ?>
                              <?php continue; ?>
                            <?php } ?>

                            <option value="<?php echo $year ?>"><?php echo $year ?></option>

                          <?php } ?>

                        </select>
                      </div>
                      <div class="col-md-4 col-sm-4 col-xs-4">
                        <select name="month" id="month" class="input select2-container select2me">
                          <option value=""><?php echo $lang['month']; ?></option>

                          <?php foreach ($month_array as $key  => $value) { ?>

                            <option value="<?php echo $key;  ?>"><?php echo $value[$lang_id]; ?></option>

                          <?php } ?>

                        </select>
                      </div>
                      <div class="col-md-4 col-sm-4 col-xs-4">
                        <select name="day" id="day" class="input select2-container select2me">
                          <option value=""><?php echo $lang['day']; ?></option>

                          <?php foreach ($day_array as $key  => $value) { ?>

                            <option value="<?php echo $key;  ?>"><?php echo $value;  ?></option>

                          <?php } ?>

                          </select>
                      </div>
                    </div>
                  </div>

                  <?php

                } else {

                  $cities = array(
                    '32' => 'Tbilisi',
                    '431' => 'Kutaisi',
                    '493' => 'Poti',
                    '492' => 'Zestafoni',
                    '491' => 'Terjola',
                    '411' => 'Samtredia',
                  );

                  if ($key['name'] == "city" AND $service['id'] == 92) {

                    ?>

                    <div class="form-group">
                      <label for="<?php echo $key['name']; ?>"><?php echo $key['description']; ?></label>

                      <div class="row date-row">
                        <div class="col-md-12 col-sm-12 col-xs-12">
                          <select name="<?php echo $key['name']; ?>" id="<?php echo $key['name']; ?>" class="input select2-container select2me">

                            <?php foreach ($cities as $key  => $value) { ?>

                              <option value="<?php echo $key;  ?>"><?php echo $value;  ?></option>

                            <?php } ?>

                            </select>
                        </div>
                      </div>
                    </div>

                    <?php

                    continue;

                  }

                  ?>

                  <div class="form-group">
                    <label for="<?php echo $key['name']; ?>"><?php echo $key['description']; ?></label>
                    <input name="<?php echo $key['name']; ?>" type="text" id="<?php echo $key['name']; ?>" class="input user_input" autocomplete="off">
                    <div class="input-icon-right">
                      <img src="assets/img/warning.png?1" alt="example">
                    </div>
                    <div class="input-example">
                      მიუთითეთ <?php echo $key['description']; ?>  <?php if (isset($key['example'])) { echo $key['example']; } else { echo " .....";} ?>
                    </div>
                  </div>

                  <?php

                } // end if is birthdate


              } // end forash

               ?>
               <div class="loads"></div>
               <input name="service_id" type="hidden" id="service_id" value="<?php echo $service_id ?>">
               <input name="client_commission_percent" type="hidden" id="client_commission_percent" value="<?php echo $service['commission']['client_commission_percent']; ?>" disabled>
               <input name="client_commission_fixed" type="hidden" id="client_commission_fixed" value="<?php echo $service['commission']['client_commission_fixed']; ?>" disabled>
               <input name="min_client_commission" type="hidden" id="min_client_commission" value="<?php echo $service['commission']['min_client_commission']; ?>" disabled>
               <input name="rate" type="hidden" id="rate" value="<?php echo $service['commission']['rate']; ?>" disabled>
               <input name="rate_percent" type="hidden" id="rate_percent" value="<?php echo $service['commission']['rate_percent']; ?>" disabled>
              <div class="form-group p-btns">
                <div class="row">
                  <div class="col-md-12">
                    <button type="submit" name="pay" class="g1-btn btn-load"><span><?=$lang['check'] ?></span></button>
                  </div>
                  <div class="col-md-4 none">
                    <a href="#" class="sv-btn"> <span> <i class="fa fa-floppy-o"></i> შენახვა</span></a>
                  </div>
                </div>
              </div>
            </form>
          </div><!-- end col-md-8 div -->

          <!-- validation -->
          <script type="text/javascript" src="./assets/plugins/jquery-validation/js/jquery.validate.min.js"></script>
          <script type="text/javascript" src="./assets/plugins/jquery-validation/js/additional-methods.min.js"></script>
          <script type="text/javascript" src="./assets/plugins/jquery-validation/js/localization/messages_<?=$lang_id ?>.js"></script>
          <script>

            // count percent
            $('#service_form').on("keyup","#amount", function() {

              calc1();

            });

            $('#service_form').on("keyup","#generated", function() {

              re_calc();

            });

            $('#service_form').on("click",".sv-btn", function(e) {

              e.preventDefault();

              save_service();

            });

            $(document).ready(function(){
                
              var service_form = $('#service_form');

              $.validator.addMethod(
                  "pattern",
                  function(value, element, pattern) {
                      var re = new RegExp(pattern);
                      return this.optional(element) || re.test(value);
                  },
                  "ფორმატი არასწორია.."
                );

                service_form.validate({
                   focusInvalid: false, // do not focus the last invalid input
                   errorElement: 'span',

                   rules: {

                     <?php

                        foreach ($service['params_info'] as $key) {

                          echo $key['name'].": {required: true, pattern: ".$key['regexp']."},";

                        }

                      ?>
                      amount: {required: true,min: <?php echo $service['commission']['min_amount']; ?>,max: <?php echo $service['commission']['max_amount']; ?>,},
                      generated: {required: true,min: <?php echo $service['commission']['min_amount']; ?>,max: <?php echo $service['commission']['max_amount']; ?>,},

                     },

                      onkeyup: function(element) {
                        // console.log(element);
                        $(element).valid();

                        if($(element).valid()) {

                          $(element).closest('.form-group').children('.input-example').css('opacity','0');
                          $(element).closest('.form-group').find('.input-icon-right').find('img').attr('src', 'assets/img/success.png?1');

                        } else {
                          $(element).closest('.form-group').children('.input-example').css('opacity','1');
                          $(element).closest('.form-group').find('.input-icon-right').find('img').attr('src', 'assets/img/warning.png?2');

                        }

                      },


                     submitHandler: function (form) {

                       load_infos(form,1);

                       return false; // required to block normal submit since you used ajax

                     },



                 });
            });


            function send_sms(data) {

              //

              $.ajax({
                 type: "POST",
                 url: 'https://leaderpay.ge/loads/sms.php?send',
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
                  $.get("https://leaderpay.ge/loads/sms.php?delete_sesion", function(){});

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
                    $.get("https://leaderpay.ge/loads/sms.php?delete_sesion", function(){});

                  }, 60000);

              });


            });


          </script>

          <?php

        } else {

          ?>

          <div class="msg msg-error">
            დროებითი ტექნიკური შეფერხებაა
            <div class="close-p msg-colose" rel="0"></div>
          </div>

          <?php

        }

      ?>

    </div><!-- end pay -->
  </div> <!-- end row-->
</div> <!-- end sub-page-body-->
