<?php
    require_once('includes/head.php');

    $active = 'register';
    $page_title = $lang['sing_up'];

    // countries
    $countries = $db->get_unlimited_list("countries", ' code > 0 ', "code", "desc");

    //check user
    if ($db->check_auch() == true) {
        header('Location: profile.php');
    }

    $page_style = "<script src='https://www.google.com/recaptcha/api.js'></script>";

    include 'includes/header.php';

?>
<div class="container page">
    <div class="row">
        <div class="col-md-12">
            <div class="page-bg fluid clear">
                <h3 class="page-title">
                    <span class="t r"><?php echo $lang['sing_up']; ?></span>
                </h3>
                <form class="register_form" action="loads/registracion.php" method="post"
                      autocomplete="off" id="registracion_form">
                    <div class="reg_loader" style="display: none">
                        <span class="helper"></span>
                        <img src="assets/img/g_loader.gif" alt="">
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="msg msg-error" style="display:none"><?php echo $lang['required']; ?></div>
                            <?php if (isset($error_msg)) { ?>
                                <div class="msg msg-error"><?php echo $error_msg; ?></div>
                            <?php } ?>
                            <?php if (isset($valid) && $valid != false) { ?>
                                <div class="msg msg-error">
                                    <?php foreach ($valid as $key => $value) { ?>
                                        <?php echo $value; ?>
                                    <?php } ?>
                                </div>
                            <?php } ?>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12 col-sm-12">
                            <div class="row">

                                <div class="col-md-6 col-sm-6" style="padding-bottom: 25px">
                                    <div class="form-group req personal_number_div">
                                        <label for="personal_number"><?php echo $lang['personal_number']; ?></label>
                                        <input onkeypress="return isIntKey(event);" name="personal_number" type="text"
                                               id="personal_number"
                                               value="<?php if (isset($_SESSION['register']['personal_number'])) {
                                                   echo $_SESSION['register']['personal_number'];
                                               } ?>" class="input">
                                        <div class="input-icon-right" style="bottom: 7px;">
                                            <img src="assets/img/question-mark.png" alt="example">
                                            <span class="input-note">რეგისტრაციის დასრულების შემდეგ  მოგენიჭებათ საფულის ნომერი  რომელიც იდენტურია თქვენი პირადი ნომრის</span>
                                        </div>
                                    </div>
                                </div> <!-- end col -->
                                <div class="col-md-6 col-sm-12">
                                    <div class="form-group req" style="visibility: hidden">
                                        <input name="country" type="hiiden" id="country" class="input" value="<?php echo $country['country'] = "GE"; ?>">
                                    </div>
                                </div> <!-- end col -->
                            </div><!-- end row -->

                            <div class="row">
                                <div class="col-md-6 col-sm-6">
                                    <div class="form-group req">
                                        <label for="first_name"><?php echo $lang['first_name']; ?></label>
                                        <input name="first_name" type="text" id="first_name" maxlength="50"
                                               class="input"
                                               value="<?php if (isset($_SESSION['register']['first_name'])) {
                                                   echo $_SESSION['register']['first_name'];
                                               } ?>">
                                    </div>
                                </div> <!-- end col -->
                                <div class="col-md-6 col-sm-6">
                                    <div class="form-group req">
                                        <label for="last_name"><?php echo $lang['last_name']; ?></label>
                                        <input name="last_name" type="text" maxlength="50" id="last_name" class="input"
                                               value="<?php if (isset($_SESSION['register']['last_name'])) {
                                                   echo $_SESSION['register']['last_name'];
                                               } ?>">
                                    </div>
                                </div> <!-- end col -->
                            </div><!-- end row -->

                            <div class="row">
                                <div class="col-md-12 col-sm-12">
                                    <div class="form-group req">
                                        <label for="birth_date"><?php echo $lang['date_of_birth']; ?></label>
                                        <div class="row date-row">
                                            <div class="col-md-4 col-sm-4 col-xs-4">
                                                <select name="birth_year" id="birth_year"
                                                        class="input select2-container select2me">
                                                    <option value=""><?php echo $lang['year']; ?></option>
                                                    <?php for ($x = 2005; $x > 1920; $x--) { ?>
                                                        <option value="<?php echo $x; ?>" <?php if (isset($_SESSION['register']['birth_year']) && $_SESSION['register']['birth_year'] == $x) {
                                                            echo "selected";
                                                        } ?>><?php echo $x; ?></option>
                                                    <?php } ?>
                                                </select>
                                            </div>
                                            <div class="col-md-4 col-sm-4 col-xs-4">
                                                <select name="birth_month" id="birth_month"
                                                        class="input select2-container select2me">
                                                    <option value=""><?php echo $lang['month']; ?></option>
                                                    <?php foreach ($month_array as $key => $value) { ?>
                                                        <option value="<?php echo $key; ?>" <?php if (isset($_SESSION['register']['birth_month']) && $_SESSION['register']['birth_month'] == $key) {
                                                            echo "selected";
                                                        } ?>><?php echo $value[$lang_id]; ?></option>
                                                    <?php } // end foreach ?>
                                                </select>
                                            </div>
                                            <div class="col-md-4 col-sm-4 col-xs-4">
                                                <select name="birth_day" id="birth_day"
                                                        class="input select2-container select2me">
                                                    <option value=""><?php echo $lang['day']; ?></option>
                                                    <?php for ($x = 1; $x <= 31; $x++) { ?>
                                                        <option value="<?php echo $x; ?>" <?php if (isset($_SESSION['register']['birth_day']) && $_SESSION['register']['birth_day'] == $x) {
                                                            echo "selected";
                                                        } ?>><?php echo $x; ?></option>
                                                    <?php } ?>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                </div> <!-- end col -->
                            </div><!-- end row -->

                            <div class="row">
                                <div class="col-md-12 col-sm-12">
                                    <div class="form-group req">
                                        <label for="phone"><?php echo $lang['telephone_number']; ?></label>
                                        <input onkeypress="return isIntKey(event);" name="phone" type="tel" id="phone"
                                               class="input" value="">
                                    </div>
                                </div> <!-- end col -->

                            </div><!-- end row -->

                            <div class="row">
                                <div class="col-md-6 col-sm-6">
                                    <div class="form-group req">
                                        <label for="password"><?php echo $lang['password']; ?></label>
                                        <input name="password" type="password" id="password" class="input" value="">
                                    </div>
                                </div> <!-- end col -->
                                <div class="col-md-6 col-sm-6">
                                    <div class="form-group req">
                                        <label for="repeat_password"><?php echo $lang['repeat_password']; ?></label>
                                        <input name="repeat_password" type="password" id="repeat_password" class="input"
                                               value="">
                                    </div>
                                </div> <!-- end col -->
                            </div> <!-- end row -->
                            <!-- anonsed to -->
                            <div class="row">
                                <div class="col-md-6 col-sm-6">
                                    <div class="form-group req">
                                        <label for="gender" style="display:block"><?php echo $lang['gender']; ?></label>
                                        <div class="radio">
                                            <input id="radio-1" class="radio_input" name="gender" type="radio" checked
                                                   value="1">
                                            <label for="radio-1"
                                                   class="radio-label"><?php echo $lang['male']; ?></label>
                                            <div class="control__indicator"></div>
                                        </div>
                                        <div class="radio">
                                            <input id="radio-2" class="radio_input" name="gender" type="radio"
                                                   value="2">
                                            <label for="radio-2"
                                                   class="radio-label"><?php echo $lang['female']; ?></label>
                                            <div class="control__indicator"></div>
                                        </div>
                                    </div>
                                </div> <!-- end col -->
                            </div><!-- end row -->
                            <div class="row">
                                <div class="col-md-6 col-sm-6">
                                    <div class="form-group req">
                                        <label for="security"><?php echo $lang['security_code']; ?></label>
                                        <div class="g-recaptcha"
                                             data-sitekey="6LfLxE4UAAAAAAiq2Io2JclnSwYuUJftQOOk7RMX"></div>
                                        <input id="hidden-grecaptcha" name="hidden-grecaptcha" type="text"
                                               style="visibility:hidden;height: 0;">
                                    </div>
                                </div> <!-- end col -->
                            </div><!-- end row -->
                        </div><!-- end col-md-6 -->
                    </div> <!-- end row -->
                    <div class="col-md-12">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group checkbox">
                                    <div class="md-checkbox">
                                        <input id="checkbox1" name="checkbox1" type="checkbox">
                                        <label for="checkbox1"><?php echo $lang['agree']; ?> <a
                                                    href="https://apw.ge/assets/pdf/aggrament.pdf" target="_blank"
                                                    class=""> <?php echo $lang['agreements']; ?> </a> <?php echo $lang['agreement']; ?>
                                        </label>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group checkbox">
                                    <div class="md-checkbox">
                                        <input id="checkbox" name="checkbox" type="checkbox">
                                        <label for="checkbox">მე გავეცანი და ვეთანხმები კონფიდენციალურობისა და
                                            უსაფრთხოების <a
                                                    href="https://apw.ge/privacy.php" target="_blank">პირობებს </a>
                                        </label>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div> <!-- end col -->

                    <div class="col-md-12">
                        <div class="row">
                            <div class="col-md-12">
                                <br>
                                <hr>
                                <br>
                            </div> <!-- end col -->
                        </div><!-- end row div -->
                    </div> <!-- end col -->

                    <div class="col-md-12 text-center">
                        <button type="submit" class="g1-btn" name="submit" id = "submit"><i
                                    class="ic-reg"></i> <?php echo $lang['sing_up']; ?>
                        </button>
                    </div>
            </div><!-- end row -->
        </div> <!-- end col -->
    </div><!-- end row div -->

</div><!-- end row -->
</form>
</div><!-- end page-bg -->
</div><!-- end col -->
</div><!-- end row -->

<script>
    $( "#submit" ).click(function() {

        //sms_code = $("#retrieved_sms_code").val();
        sms_code = "1";

    //     $.ajax({
    //         type: "POST",
    //         url: "load/registracion.php",
    //         data: { sms_code: sms_code },
    //         dataType: "json",
    //         success: function (json){
    //             if(json.errorCode == 9) {
    //                 console.log("Register failed");
    //             }
    //         },
    //         error: function (err) {
    //         }
    //     });
    // });
</script>

</div><!-- end container -->

<?php

$page_script = '<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js"></script>
<script src="assets/pages/registracion.js?' . time() . '"></script>';

include 'includes/footer.php';
?>
