<?php
require_once('includes/head.php');

//
$active = 'register';
$page_title = $lang['sing_up'];

// countryes
$countries = $db->get_unlimited_list("countries",' code > 0 ',"code","desc");

// sferos
$sferos = $db->get_unlimited_list("sferos",' id > 0 ',"id","ASC");

// document types
$document_types = $db->get_unlimited_list("users_document_types",' id > 0 ',"id","ASC");

//check user
//if ($db->check_auch() == true) {
//
//    header('Location: profile.php');
//
//}

//$page_style = "<script src='https://www.google.com/recaptcha/api.js'></script>";


//include 'includes/header.php';
//if (isset($page_style)) {
//
//    echo $page_style;
//}

?>


<div class="modal fade bs-modal-lg in" id="webcamModel" tabindex="-1" role="dialog" aria-hidden="false">
    <div class="modal-backdrop fade in"></div>
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="cropImageTitle">საბუთის სურათის გადაღება</h4>
                <div class="cropButtons">
                </div>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-12">
                        <div class="webcam-shot">
                            <video id="webcam" autoplay="autoplay"></video>
                            <canvas id="taked_img"></canvas>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" id="buttonStop" onClick="stop()">დახურვა</button>
                <button type="button" class="btn btn-success" id="buttonSnap" onClick="snapshot()">ფოტოს გადაღება</button>
            </div>
        </div>
    </div>
</div>


<div class="container page" id="registration_form">
    <div class="row">
        <div class="col-md-12">
            <div class="page-bg fluid clear">
                <h3 class="page-title">
                    <span class="t r"><?php echo $lang['sing_up']; ?></span>
                </h3>
                <form class="register_form" action="loads/registracion.php?action=registracion" method="post" autocomplete="off" id="registracion_form">
                    <div class="reg_loader" style="display: none">
                        <span class="helper"></span>
                        <img src="assets/img/g_loader.gif" alt="">
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="msg msg-error" style="display:none"><?php echo $lang['required']; ?></div>

                            <?php if (isset($error_msg)){ ?>

                                <div class="msg msg-error"><?php echo $error_msg; ?></div>

                            <?php } ?>

                            <?php if (isset($valid) && $valid != false){ ?>

                                <div class="msg msg-error">

                                    <?php foreach ($valid as $key => $value) { ?>

                                        <?php echo $value; ?>

                                    <?php } ?>

                                </div>

                            <?php } ?>

                        </div>
                    </div>
                    <div class="row">

                        <div class="col-md-6 col-sm-6">

                            <div class="row">
                                <div class="col-md-6 col-sm-12">
                                    <div class="form-group req">
                                        <label for="country"><?php echo $lang['country']; ?></label>
                                        <select name="country" id="country" class="input select2-container select2me">
                                            <option value=""><?php echo $lang['country']; ?></option>

                                            <?php foreach ($countries as $country){ ?>

                                                <option value="<?php echo $country['ccode']; ?>" <?php if (isset($_SESSION['register']['country']) && $_SESSION['register']['country'] == $country['ccode']){ echo "selected"; } ?>><?php echo $country['country']; ?></option>

                                            <?php } ?>

                                        </select>
                                    </div>
                                </div> <!-- end col -->
                                <div class="col-md-6 col-sm-6">
                                    <div class="form-group req personal_number_div">
                                        <label for="personal_number"><?php echo $lang['personal_number']; ?></label>
                                        <input onkeypress="return isIntKey(event);" name="personal_number" type="text" id="personal_number" value="<?php if(isset($_SESSION['register']['personal_number'])) { echo $_SESSION['register']['personal_number'];}?>" class="input">
                                        <div class="input-icon-right" style="bottom: 7px;">
                                            <img src="assets/img/question-mark.png" alt="example">
                                            <span class="input-note">რეგისტრაციის დასრულების შემდეგ  მოგენიჭებათ საფულის ნომერი  რომელიც იდენტურია თქვენი პირადი ნომრის</span>
                                        </div>
                                    </div>
                                </div> <!-- end col -->
                            </div><!-- end row -->

                            <div class="row">
                                <div class="col-md-6 col-sm-6">
                                    <div class="form-group req">
                                        <label for="first_name"><?php echo $lang['first_name']; ?></label>
                                        <input name="first_name" type="text" id="first_name" maxlength="50" class="input" value="<?php if(isset($_SESSION['register']['first_name'])) { echo $_SESSION['register']['first_name'];}?>">
                                    </div>
                                </div> <!-- end col -->
                                <div class="col-md-6 col-sm-6">
                                    <div class="form-group req">
                                        <label for="last_name"><?php echo $lang['last_name']; ?></label>
                                        <input name="last_name" type="text" maxlength="50" id="last_name" class="input" value="<?php if(isset($_SESSION['register']['last_name'])) { echo $_SESSION['register']['last_name'];}?>">
                                    </div>
                                </div> <!-- end col -->
                            </div><!-- end row -->

                            <div class="row">
                                <div class="col-md-6 col-sm-6">
                                    <div class="form-group req">
                                        <label for="real_address"><?php echo $lang['real_address']; ?></label>
                                        <input name="real_address" maxlength="40" type="text" id="real_address" class="input" value="<?php if(isset($_SESSION['register']['real_address'])) { echo $_SESSION['register']['real_address'];}?>" autocomplete="off">
                                    </div>
                                </div> <!-- end col -->
                                <div class="col-md-6 col-sm-6">
                                    <div class="form-group req">
                                        <label for="birth_place"><?php echo $lang['place_of_birth']; ?></label>
                                        <input name="birth_place" maxlength="40" type="text" id="birth_place" class="input" value="<?php if(isset($_SESSION['register']['birth_place'])) { echo $_SESSION['register']['birth_place'];}?>">
                                    </div>
                                </div> <!-- end col -->
                            </div><!-- end row -->

                            <div class="row">
                                <div class="col-md-12 col-sm-12">
                                    <div class="form-group req">
                                        <label for="birth_date"><?php echo $lang['date_of_birth']; ?></label>
                                        <div class="row date-row">
                                            <div class="col-md-4 col-sm-4 col-xs-4">
                                                <select name="birth_year" id="birth_year" class="input select2-container select2me">
                                                    <option value=""><?php echo $lang['year']; ?></option>

                                                    <?php for ($x = 2005; $x > 1920; $x--) { ?>

                                                        <option value="<?php echo $x; ?>" <?php if (isset($_SESSION['register']['birth_year']) && $_SESSION['register']['birth_year'] == $x){ echo "selected"; } ?>><?php echo $x; ?></option>

                                                    <?php } ?>

                                                </select>
                                            </div>
                                            <div class="col-md-4 col-sm-4 col-xs-4">
                                                <select name="birth_month" id="birth_month" class="input select2-container select2me">
                                                    <option value=""><?php echo $lang['month']; ?></option>

                                                    <?php foreach ($month_array as $key  => $value) { ?>

                                                        <option value="<?php echo $key; ?>" <?php if (isset($_SESSION['register']['birth_month']) && $_SESSION['register']['birth_month'] == $key){ echo "selected"; } ?>><?php echo $value[$lang_id]; ?></option>

                                                    <?php } // end foreach ?>

                                                </select>
                                            </div>
                                            <div class="col-md-4 col-sm-4 col-xs-4">
                                                <select name="birth_day" id="birth_day" class="input select2-container select2me">
                                                    <option value=""><?php echo $lang['day']; ?></option>

                                                    <?php for ($x = 1; $x <= 31; $x++) { ?>

                                                        <option value="<?php echo $x;  ?>" <?php if (isset($_SESSION['register']['birth_day']) && $_SESSION['register']['birth_day'] == $x){ echo "selected"; } ?>><?php echo $x;  ?></option>

                                                    <?php } ?>

                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                </div> <!-- end col -->
                            </div><!-- end row -->

                            <div class="row">
                                <div class="col-md-6 col-sm-6">
                                    <div class="form-group req">
                                        <label for="phone"><?php echo $lang['telephone_number']; ?></label>
                                        <input onkeypress="return isIntKey(event);" name="phone" type="tel" id="phone" class="input" value="">
                                    </div>
                                </div> <!-- end col -->

                                <div class="col-md-6 col-sm-6">
                                    <div class="form-group req">
                                        <label for="email"><?php echo $lang['email']; ?></label>
                                        <input name="email" type="text" id="email" class="input" value="<?php if(isset($_SESSION['register']['email'])) { echo $_SESSION['register']['email'];}?>">
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
                                        <input name="repeat_password" type="password" id="repeat_password" class="input" value="">
                                    </div>
                                </div> <!-- end col -->
                            </div> <!-- end row -->

                            <div class="row">
                                <div class="col-md-12 col-sm-12">
                                    <div class="form-group req">
                                        <label for="sfero_id"><?php echo $lang['sfero_id']; ?></label>
                                        <select name="sfero_id" id="sfero_id" class="input select2-container select2me">

                                            <?php foreach ($sferos as $sfero){ ?>

                                                <option value="<?php echo $sfero['id']; ?>"><?php echo $sfero['name']; ?></option>

                                            <?php } ?>

                                        </select>
                                    </div>
                                </div> <!-- end col -->
                            </div><!-- end row -->

                            <div class="row sfero_div" style="display:none">
                                <div class="col-md-12 col-sm-12">
                                    <div class="form-group req">
                                        <label for="sfero"><?php echo $lang['sfero']; ?></label>
                                        <input name="sfero" type="text" id="sfero" class="input" value="<?php if(isset($_SESSION['register']['sfero'])) { echo $_SESSION['register']['sfero'];}?>">
                                    </div>
                                </div> <!-- end col -->
                            </div><!-- end row -->

                            <!-- anonsed to -->
                            <div class="row">
                                <div class="col-md-12 col-sm-12">
                                    <div class="form-group req">
                                        <label for="gender" style="display:block"><?php echo $lang['gender']; ?></label>
                                        <div class="radio">
                                            <input id="radio-1" class="radio_input" name="gender" type="radio" checked value="1">
                                            <label for="radio-1" class="radio-label"><?php echo $lang['male']; ?></label>
                                            <div class="control__indicator"></div>
                                        </div>
                                        <div class="radio">
                                            <input id="radio-2" class="radio_input" name="gender" type="radio" value="2">
                                            <label  for="radio-2" class="radio-label"><?php echo $lang['female']; ?></label>
                                            <div class="control__indicator"></div>
                                        </div>
                                    </div>

                                </div> <!-- end col -->

                            </div><!-- end row -->

                        </div><!-- end col-md-6 -->

                        <div class="col-md-6 col-sm-6">

                            <div class="row">
                                <div class="col-md-6 col-sm-6">
                                    <div class="form-group req">
                                        <label for="document_type"><?php echo $lang['document_type']; ?></label>
                                        <select name="document_type" id="document_type" class="input select2-container select2me">

                                            <option value=""><?php echo $lang['document_type']; ?></option>

                                            <?php foreach ($document_types as $type){ ?>

                                                <option value="<?php echo $type['id']; ?>" regex="<?php echo $type['regex']; ?>" <?php if (isset($_SESSION['register']['document_type']) && $_SESSION['register']['document_type'] == $type['id']){ echo "selected"; } ?>><?php echo $type['name']; ?></option>

                                            <?php } ?>

                                        </select>
                                    </div>
                                </div> <!-- end col -->
                                <div class="col-md-6 col-sm-6">
                                    <div class="form-group req">
                                        <label for="document_number"><?php echo $lang['document_number']; ?></label>
                                        <input name="document_number" type="text" maxlength="20" id="document_number" class="input" value="<?php if(isset($_SESSION['register']['document_number'])) { echo $_SESSION['register']['document_number'];}?>">
                                    </div>
                                </div> <!-- end col -->
                            </div><!-- end row -->


                            <div class="row">
                                <div class="col-md-12 col-sm-12">
                                    <div class="form-group req">
                                        <label for="issue_organisation"><?php echo $lang['issue_organisation']; ?></label>
                                        <input name="issue_organisation" type="text" maxlength="20" id="issue_organisation" class="input" value="<?php if(isset($_SESSION['register']['issue_organisation'])) { echo $_SESSION['register']['issue_organisation'];}?>">
                                    </div>
                                </div> <!-- end col -->
                            </div><!-- end row -->

                            <div class="row">
                                <div class="col-md-12 col-sm-12">
                                    <div class="form-group req">
                                        <label for="issue_date"><?php echo $lang['passport_registration_date']; ?></label>
                                        <div class="row date-row">
                                            <div class="col-md-4 col-sm-4 col-xs-4">
                                                <select name="issue_year" id="issue_year" class="input select2-container select2me">
                                                    <option value=""><?php echo $lang['year']; ?></option>

                                                    <?php for ($x = 2019; $x > 1920; $x--) { ?>

                                                        <option value="<?php echo $x; ?>" <?php if (isset($_SESSION['register']['issue_year']) && $_SESSION['register']['issue_year'] == $x){ echo "selected"; } ?>><?php echo $x; ?></option>

                                                    <?php } ?>

                                                </select>
                                            </div>
                                            <div class="col-md-4 col-sm-4 col-xs-4">
                                                <select name="issue_month" id="issue_month" class="input select2-container select2me">
                                                    <option value=""><?php echo $lang['month']; ?></option>

                                                    <?php foreach ($month_array as $key  => $value) { ?>

                                                        <option value="<?php echo $key;  ?>" <?php if (isset($_SESSION['register']['issue_month']) && $_SESSION['register']['issue_month'] == $key){ echo "selected"; } ?>><?php echo $value[$lang_id]; ?></option>

                                                    <?php } // end foreach ?>

                                                </select>
                                            </div>
                                            <div class="col-md-4 col-sm-4 col-xs-4">
                                                <select name="issue_day" id="issue_day" class="input select2-container select2me">
                                                    <option value=""><?php echo $lang['day']; ?></option>

                                                    <?php for ($x = 1; $x <= 31; $x++) { ?>

                                                        <option value="<?php echo $x;  ?>" <?php if (isset($_SESSION['register']['issue_day']) && $_SESSION['register']['issue_day'] == $x){ echo "selected"; } ?>><?php echo $x;  ?></option>

                                                    <?php } ?>

                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                </div> <!-- end col -->
                            </div><!-- end row -->

                            <div class="row">
                                <div class="col-md-9 col-sm-9 col-xs-9">

                                    <div class="form-group req">
                                        <label for="expiry_date"><?php echo $lang['passport_valid']; ?></label>
                                        <div class="row date-row">
                                            <div class="col-md-4 col-sm-4 col-xs-4">
                                                <select name="expiry_year" id="expiry_year" class="input select2-container select2me">
                                                    <option value=""><?php echo $lang['year']; ?></option>

                                                    <?php for ($x = 2019; $x < 2050; $x++) { ?>

                                                        <option value="<?php echo $x; ?>" <?php if (isset($_SESSION['register']['expiry_year']) && $_SESSION['register']['expiry_year'] == $x){ echo "selected"; } ?>><?php echo $x; ?></option>

                                                    <?php } ?>

                                                </select>
                                            </div>
                                            <div class="col-md-4 col-sm-4 col-xs-4">
                                                <select name="expiry_month" id="expiry_month" class="input select2-container select2me">
                                                    <option value=""><?php echo $lang['month']; ?></option>

                                                    <?php foreach ($month_array as $key  => $value) { ?>

                                                        <option value="<?php echo $key;  ?>" <?php if (isset($_SESSION['register']['expiry_month']) && $_SESSION['register']['expiry_month'] == $key){ echo "selected"; } ?>><?php echo $value[$lang_id]; ?></option>

                                                    <?php } // end foreach ?>

                                                </select>
                                            </div>
                                            <div class="col-md-4 col-sm-4 col-xs-4">
                                                <select name="expiry_day" id="expiry_day" class="input select2-container select2me">
                                                    <option value=""><?php echo $lang['day']; ?></option>

                                                    <?php for ($x = 1; $x <= 31; $x++) { ?>

                                                        <option value="<?php echo $x;  ?>" <?php if (isset($_SESSION['register']['expiry_day']) && $_SESSION['register']['expiry_day'] == $x){ echo "selected"; } ?>><?php echo $x;  ?></option>

                                                    <?php } ?>

                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                </div> <!-- end col -->
                                <div class="col-md-3 col-sm-3 col-xs-3" style="margin-top: 18px;">
                                    <div class="form-group checkbox">
                                        <div class="md-checkbox">
                                            <input id="expiry" name="expiry" type="checkbox">
                                            <label for="expiry"><?php echo $lang['expiry']; ?></label>
                                        </div>
                                    </div>
                                </div>
                            </div><!-- end row -->

                            <div class="row">
                                <div class="col-md-12 col-sm-12">

                                    <div class="images-c clear">
                                        <div class="up-item">
                                            <label for="front">
                                                <div class="icon"></div>
                                                <?php echo $lang['document_front']; ?>
                                                <input type="file" class="fileinput" id="front">
                                                <input type="hidden" name="document_front" id="document_front" value="">
                                            </label>
                                        </div>

                                        <div class="up-item">
                                            <label for="back">
                                                <div class="icon"></div>
                                                <?php echo $lang['document_back']; ?>
                                                <input type="file" class="fileinput" id="back">
                                                <input type="hidden" name="document_back" id="document_back" value="">
                                            </label>
                                        </div>

                                        <div class="up-item">
                                            <label for="self">
                                                <div class="icon2"></div>
                                                სელფი
                                                <input type="file" class="fileinput" id="self">
                                                <input type="hidden" name="selfie" id="selfie" value="">
                                            </label>
                                            <button type="button" name="button" id="buttonStart" onClick="start('front')">გადაღება</button>
                                        </div>

                                        <input type="hidden" name="pdf" value="pdf" id="pdf">
                                    </div> <!-- end row -->
                                    <div class="row">
                                        <div class="col-md-12 col-sm-12">
                                            <div class="form-group req">
                                                <label for="security"><?php echo $lang['security_code']; ?></label>
                                                <div id="registration-g-recaptcha"></div>
                                                <input id="hidden-grecaptcha" name="hidden-grecaptcha" type="text" style="visibility:hidden;height: 0;">
                                            </div>
                                        </div> <!-- end col -->
                                    </div><!-- end row -->
                                </div><!-- end row -->
                            </div> <!-- end col -->
                        </div><!-- end row div -->
                        <div class="col-md-12">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group checkbox">
                                        <div class="md-checkbox">
                                            <input id="checkbox1" name="checkbox1" type="checkbox">
                                            <label for="checkbox1"><?php echo $lang['agree']; ?> <a href="https://apw.ge/assets/pdf/aggrament.pdf" target="_blank" class=""> <?php echo $lang['agreements']; ?> </a> <?php echo $lang['agreement']; ?></label>
                                        </div>
                                    </div>
                                </div> <!-- end col -->
                            </div><!-- end row div -->
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group checkbox">
                                        <div class="md-checkbox">
                                            <input id="checkbox" name="checkbox" type="checkbox">
                                            <label for="checkbox">მე გავეცანი და ვეთანხმები კონფიდენციალურობისა და უსაფრთხოების <a href="https://apw.ge/register.php" onclick="generete_doc(1)" class="generete_doc">პირობებს </a> </label>
                                        </div>
                                    </div>
                                </div> <!-- end col -->
                            </div><!-- end row div -->
                        </div> <!-- end col -->

                        <div class="col-md-12">
                            <div class="row">
                                <div class="col-md-12">
                                    <br><hr><br>
                                </div> <!-- end col -->
                            </div><!-- end row div -->
                        </div> <!-- end col -->

                        <div class="col-md-12 text-center">
                            <button type="submit" class="g1-btn" name="submit"><i class="ic-reg"></i> <?php echo $lang['sing_up']; ?></button>
                        </div>
                    </div><!-- end row -->
                </form>
            </div><!-- end page-bg -->
        </div><!-- end col -->
    </div><!-- end row -->

</div><!-- end container -->

<?php

$page_script = '<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js"></script><script src="merchant/assets/js/registracion.js?'.time().'"></script>';

if (isset($page_script)) {
    echo $page_script;
}
?>
