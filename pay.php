<?php

    require_once('includes/head.php');

    if (isset($get['id']) && $get['id'] != '' && isset($get['step']) ) {

        $service_id = (INT) $get['id'];
        $step = (INT) $get['step'];

        if ($service_id == 90 || $service_id == 2) {

            if ($db->check_auch() != true) {
                header('Location: login.php');
            }

        }

    } else {

        header('Location: services.php');
    }

    $rdu2 = (isset($get['rdu2'])) ? htmlspecialchars($get['rdu2'], ENT_QUOTES) : null;

    require 'classes/Billing.php';
    $Billing = new Billing($db, 'Wallet');

    $service = $Billing->service($service_id);
    if ($service['errorCode'] != 1000 ) {
        header('Location: services.php');
    }
    $service = $service['service'];
    $services = $Billing->services();

    $lng = strtoupper($lang_id);
    $page_title = $service['lang'][$lng] . '-ის გადახდა';
    $active = '';
    unset($_SESSION['smsCode']);

    if ($db->check_auch() == true) {
        $saveSrv = $db->get_date('save_service', "service_id = $service_id AND user_id = $username");
    }

    if ($step == 1 && $service['id'] == 2 && $db->check_auch() == true) {

        $serviceId = $service['id'];
        $personalNumber = $user['personal_number'];
        list($year, $month, $day) = explode('-', $user['birth_date']);

        echo "<form id='myForm' method='POST' action='pay.php?step=2&id=$serviceId' style='display: none'>
                    <input name='personal_number' value='$personalNumber'>
                    <input name='year' value='$year'>
                    <input name='month' value='$month'>
                    <input name='day' value='$day'>
                    <input name='service_id' value='$serviceId'>
                </form>
                <script type='text/javascript'>
                    document.getElementById('myForm').submit();
                </script>";

    }

    if ($service['id'] == 2 && $db->check_auch() == true) {
        if ($user['personal_number'] == '' || $user['personal_number'] == null) {
            $error = "სერვისი თქვენთვის მიუწვდომელია, გთხოვთ დაუკავშირდით 'ოლლ ფეი ვეის'";
        }
        if (!isset($post['personal_number']) || $post['personal_number'] != $user['personal_number']) {
            $error = "სერვისი თქვენთვის მიუწვდომელია, გთხოვთ დაუკავშირდით 'ოლლ ფეი ვეის'";
        }
    }

    if ($step == 1 && $service['id'] == 90 && $db->check_auch() == true) {

        $serviceId = $service['id'];
        $account = $user['pin_code'];

        echo "<form id='myForm' method='POST' action='pay.php?step=2&id=$serviceId' style='display: none'>
                    <input name='account' value='$account'>
                    <input name='service_id' value='$serviceId'>
                </form>
                <script type='text/javascript'>
                    document.getElementById('myForm').submit();
                </script>";

    }

    if ($service['id'] == 90 && $db->check_auch() == true) {
        if ($user['pin_code'] == '' || $user['pin_code'] == null) {
            $error = "სერვისი თქვენთვის მიუწვდომელია, გთხოვთ დაუკავშირდით 'ოლლ ფეი ვეის'";
        }
        if (!isset($post['account']) || $post['account'] != $user['pin_code']) {
            $error = "სერვისი თქვენთვის მიუწვდომელია, გთხოვთ დაუკავშირდით 'ოლლ ფეი ვეის'";
        }
    }


include 'includes/header.php';

?>
    <div class="service_list service-page" id="services">
        <div class="container">
            <div class="row">
                <div class="col-md-12 text-right col-xs-text-center">
                    <div class="ser-search-box">
                        <form class="search" action="" method="post" id="Search">
                            <input autocomplete="off" type="text" class="serach-inp" id="service_search_input" name="search" placeholder="<?=$lang['search_service'] ?>">
                            <button type="submit" name="search" class="service-search-btn btn-icon"><img src="assets/img/magnifer1.png" alt="lang"></button>
                        </form>
                        <div class="service-search-result text-left">

                            <?php foreach ($services['services'] as $s) {

                                if ($s['id'] == 46) {
                                    continue;
                                } ?>

                                <a class="service-search-item none" alt="<?=$s['lang']['GE'] ?>, <?=$s['lang']['EN'] ?>, <?=$s['lang']['RU'] ?>" title="<?=$s['lang'][$lng] ?>" href="pay.php?step=1&id=<?=$s['id'] ?>">
                                    <div class="inline-block">
                                        <div class="item-image" style="background-image: url('https://uploads.allpayway.ge/files/services/<?=$s['image'] ?>');"></div>
                                        <strong><?=$s['lang'][$lng] ?></strong>
                                    </div>
                                </a>
                            <?php } ?>

                            <strong class="none service_no_found"><?=$lang['service_no_found'] ?></strong>
                        </div>
                    </div>
                </div><!-- end col -->
            </div><!-- end row -->

            <div class="row">
                <div class="col-md-12">
                    <?php if (isset($error)) { ?>
                        <div class="msg msg-error"><?=$error ?></div>
                    <?php } ?>
                    <div style="background: #fff; border-radius: 2px; box-shadow: 0 1px 1px #dad2d2; padding: 30px; <?=(isset($error)) ? 'display: none' : '' ?>">

                    <?php if (is_array($service) AND $service['id'] != 46) { ?>

                        <div class="col-md-4">
                            <a href="?action=services#cat=<?=$service['category_id'] ?>" class="go-back"> <img src="assets/img/back.png" alt=""> <?=$lang['go_to_back'] ?></a>
                            <h4 class="pay-service-t"><?=$service['lang'][$lng] ?></h4>
                            <div class="pay_service-logo">
                                <img src="https://uploads.allpayway.ge/files/services/<?=$service['image'] ?>" class="img-responsive" alt="<?=$service['lang'][$lng] ?>">
                            </div>
                            <div class="save-service">

                                <?php if ($db->check_auch() == true) { ?>

                                    <?php if ($saveSrv == false) { ?>
                                        <button type="submit" class="g1-btn s-btn save_srv"><i class="fa fa-floppy-o" aria-hidden="true"></i> <span>შაბლონად შენახვა</span></button>
                                    <?php } else { ?>
                                        <button type="submit" class="g1-btn s-btn save_srv" disabled="disabled"><i class="fa fa-check-circle" aria-hidden="true"></i> <span>დამატებულია შაბლონებში</span></button>
                                    <?php }  ?>

                                <?php }  ?>

                            </div>
                        </div><!-- end col-md-4 div -->
                        <div class="col-md-8 b-left">
                            <div class="msg-area"></div>
                            <form class="payForm" id="service_form" action="<?=($step == 1) ? "pay.php?step=2&id=$service_id" : "" ?>" method="post">
                                <div class="row">
                                    <!-- <div class="col-md-12">
                                        <div class="msg msg-error" style="display: none"><?=$lang['required'] ?></div>
                                    </div> -->
                                </div>
                                <?php

                                foreach ($service['params_info'] as $key) {

                                    // if is birthdate
                                    if ($key['name'] == 'birthdate') {
                                        if ($service_id == 2) { ?>

                                            <input name="year" type="hidden" id="year" value="<?=$post['year'] ?>" readonly>
                                            <input name="month" type="hidden" id="month" value="<?=$post['month'] ?>" readonly>
                                            <input name="day" type="hidden" id="day" value="<?=$post['day'] ?>" readonly>

                                        <?php } else { ?>

                                            <div class="form-group text-left">
                                                <label for="<?=$key['name'] ?>"><?=$key['description'] ?></label>

                                                <div class="row date-row">
                                                    <div class="col-md-4 col-sm-4 col-xs-4">
                                                        <select name="year" id="year" class="input select2-container select2me for_save" readonly>
                                                            <option value=""><?=$lang['year'] ?></option>

                                                            <?php foreach ($year_array as $year) { ?>

                                                                <?php if ($year > 2010 ) { ?>
                                                                    <?php continue; ?>
                                                                <?php } ?>

                                                                <option value="<?=$year ?>" <?=($step == 2 && isset($post['year']) && $post['year'] == $year) ? 'selected' : '' ?>><?=$year ?></option>

                                                            <?php } ?>

                                                        </select>
                                                    </div>
                                                    <div class="col-md-4 col-sm-4 col-xs-4">
                                                        <select name="month" id="month" class="input select2-container select2me for_save">
                                                            <option value=""><?=$lang['month'] ?></option>

                                                            <?php foreach ($month_array as $key  => $value) { ?>

                                                                <option value="<?=$key ?>" <?=($step == 2 && isset($post['month']) && $post['month'] == $key) ? 'selected' : '' ?>><?=$value[$lang_id] ?></option>

                                                            <?php } ?>

                                                        </select>
                                                    </div>
                                                    <div class="col-md-4 col-sm-4 col-xs-4">
                                                        <select name="day" id="day" class="input select2-container select2me for_save">
                                                            <option value=""><?=$lang['day'] ?></option>

                                                            <?php foreach ($day_array as $key  => $value) { ?>

                                                                <option value="<?=$key ?>" <?=($step== 2 && isset($post['day']) && $post['day'] == $key) ? 'selected' : '' ?>><?=$value ?></option>

                                                            <?php } ?>

                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                        <?php } ?>

                                    <?php } else { ?>

                                        <div class="form-group text-left">
                                            <label for="<?=$key['name'] ?>"><?=$key['description'] ?></label>
                                            <input name="<?=$key['name'] ?>" type="text" id="<?=$key['name'] ?>" value="<?=($step == 2 && isset($post)) ? $post[$key['name']] : '' ?>" <?=($get['step'] == 2 && isset($post)) ? 'readonly' : '' ?> class="input user_input for_save" autocomplete="off">
                                            <div class="input-icon-right">
                                                <img src="assets/img/warning.png?1" alt="example">
                                            </div>
                                            <div class="input-example">
                                                მიუთითეთ <?=$key['description'] ?>  <?=(isset($key['example'])) ? $key['example'] : ' .....' ?>
                                            </div>
                                        </div>

                                    <?php }
                                } ?>
                                <div class="loads">
                                    <?php if ($step == 2 && isset($post)) {

                                        $params = $post;
                                        if (isset($params['year']) && isset($params['month']) && isset($params['day'])) {
                                            $birthdate = $params['year'] . '-' . $params['month'] . '-' . $params['day'];
                                            $birthdate = ['birthdate' => $birthdate];

                                            unset($params['year']);
                                            unset($params['month']);
                                            unset($params['day']);

                                            $params = array_merge($params, $birthdate);
                                        }

                                        // get payment params
                                        $params_info = $service['params_info'];
                                        $info_params = [];
                                        foreach ($params_info as $param) {
                                            $info_params[$param['name']] = urlencode($params[$param['name']]);
                                            $info_params['service_id'] = $service_id;
                                        }

                                        $info = $Billing->info($info_params);

                                        if ($info['errorCode'] != 1000) { ?>

                                            <?php if (isset($info['errorCode'])) { ?>
                                                <div class="msg msg-error" role="alert"><?=$info['errorMessage'] ?></div>
                                            <?php } else { ?>
                                                <div class="msg msg-error" role="alert">კიდევ სცადეთ!</div>
                                            <?php } ?>

                                        <?php } else {

                                            if ($service_id == 3) {

                                                $operator = $info['data']['operator'];

                                                $servicesLst = $Billing->services();
                                                foreach ($servicesLst['services'] as $s) {
                                                    if ($s['name'] == $operator) {
                                                        ?>
                                                        <script>
                                                            window.location.replace('pay.php?step=2&id=<?=$s['id'] ?>&rdu=<?=urlencode($params['phone_number']) ?>');
                                                        </script>
                                                        <?php

                                                    }
                                                }

                                            }

                                            // for xpay
                                            if ($post['service_id'] == 114 && isset($post['loan']) && isset($post['personal_number'])) {

                                                    $xp_service_id = (INT) $post['xp_service_id'];
                                                    $loan_id = (INT) $post['loan'];
                                                    $personal_number = $post['personal_number'];

                                                ?>
                                                    <script>
                                                        window.location.replace('pay.php?step=2&id=<?=$xp_service_id ?>&rdu=<?=$loan_id ?>&rdu2=<?=$personal_number ?>');
                                                    </script>
                                                <?php

                                            }

                                            if ($service_id == 114) { ?>
                                                <input type="hidden" name="xp_service_id" id="xp_service_id" value="<?=current($info['data']['loan'])['service_id'] ?>">
                                            <?php }

                                            foreach ($info['data'] as $key => $value) {

                                                $params = $Billing->names();
                                                $params = $params['params'];

                                                foreach($params as $k => $v) {

                                                    if ($v['name'] == $key) {
                                                        $paramName = $v['description'];
                                                    }
                                                }

                                                if (is_array($value)) {

                                                    // for xpay
                                                    if ($service_id == 114) { ?>

                                                        <div class="form-group text-left"><label for="<?=$key ?>"><?=$paramName ?></label>
                                                            <select class="input select2-container select2me" name="<?=$key ?>" id="xpay_<?=$key ?>">

                                                                <?php foreach ($value as $key => $value) { ?>
                                                                    <option rel="<?=$value['service_id'] ?>" value="<?=$value['value'] ?>"><?=$value['service'] ?> მიმდინარე დავალიანება <?=$value['montly_payment'] ?> გადახდის თარიღი <?=$value['next_pay'] ?></option>
                                                                <?php } ?>

                                                            </select>
                                                        </div>

                                                    <?php } else { ?>

                                                        <div class="form-group text-left"><label for="<?=$key ?>"><?=$paramName ?></label>
                                                            <select class="input select2-container select2me" name="<?=$key ?>" id="<?=$key ?>">

                                                                <?php foreach ($value as $key => $value) { ?>
                                                                    <option value="<?=$value['account'] ?>"><?=$value['name'] ?></option>
                                                                <?php } ?>

                                                            </select>
                                                        </div>
                                                    <?php }

                                                } else { ?>
                                                    <div class="form-group text-left"><label for="<?=$key ?>"><?=$paramName ?></label><input type="text" name="<?=$key ?>" id="<?=$key ?>" value="<?=$value?>" class="input" readonly></div>
                                                <?php }
                                                }

                                            if ($service_id != 114) { ?>

                                                <div class="form-group text-left"><label for="amount">თანხა</label><input name="amount" type="text" id="amount" class="input float" autocomplete="off"></div>
                                                <input name="procent" type="hidden" disabled="" id="procent" class="input" autocomplete="off">
                                                <input name="generated" type="hidden" id="generated" class="input" autocomplete="off">

                                            <?php }

                                                // if need sms validate
                                                $type = $db->get_date('service_options', " `service_id` = '$service_id' ");
                                                if (isset($type['sms']) AND $type['sms'] == 1) { ?>
                                                    <input name="code" type="hidden" id="code" class="input" autocomplete="off">
                                        <?php }
                                        }
                                    } ?>
                                </div>

                                <div class="forCard" style="display: none">
                                    <div class="form-group text-left">
                                        <label for="mFirstName"><?=$lang['first_name'] ?></label>
                                        <input minlength="2" maxlength="20" type="text" name="mFirstName" id="mFirstName" class="input" autocomplete="off" required style="padding-left: 15px">
                                        <div class="input-icon-right">
                                            <img src="assets/img/warning.png?1" alt="example">
                                        </div>
                                        <div class="input-example">მაგალითი: <?=$lang['first_name'] ?></div>
                                    </div>
                                    <div class="form-group text-left">
                                        <label for="mLastName"><?=$lang['last_name'] ?></label>
                                        <input minlength="2" maxlength="20" type="text" name="mLastName" id="mLastName" class="input" autocomplete="off" required style="padding-left: 15px">
                                        <div class="input-icon-right">
                                            <img src="assets/img/warning.png?1" alt="example">
                                        </div>
                                        <div class="input-example">მაგალითი: <?=$lang['last_name'] ?></div>
                                    </div>
                                    <div class="form-group text-left">
                                        <label for="mPersonal_no"><?=$lang['personal_number'] ?></label>
                                        <input minlength="5" maxlength="15" type="text" name="mPersonal_no" id="mPersonal_no" class="input" autocomplete="off" required style="padding-left: 15px">
                                        <div class="input-icon-right">
                                            <img src="assets/img/warning.png?1" alt="example">
                                        </div>
                                        <div class="input-example">მაგალითი: 01001010112</div>
                                    </div>
                                    <div class="form-group text-left">
                                        <label for="mBirthDate"><?=$lang['date_of_birth'] ?></label>
                                        <input type="text" name="mBirthDate" id="mBirthDate" class="input" autocomplete="off" required style="padding-left: 15px">
                                        <div class="input-icon-right">
                                            <img src="assets/img/warning.png?1" alt="example">
                                        </div>
                                        <div class="input-example">მაგალითი: 1999-09-19</div>
                                    </div>
                                </div>

                                <!-- sender/reciver -->
                                <?php

                                if ($db->check_auch() == true) {

                                    $document = $db->get_date('users_documents', "personal_number = $username");
                                    $document = @$document['document_number'];

                                    if (isset($info['person']['required']['sender_firstname']) && $info['person']['required']['sender_firstname'] == 1) { ?>
                                        <input name="sender_firstname" type="hidden" id="sender_firstname" value="<?=$user['first_name'] ?>">
                                    <?php }
                                    if (isset($info['person']['required']['sender_lastname']) && $info['person']['required']['sender_lastname'] == 1) { ?>
                                        <input name="sender_lastname" type="hidden" id="sender_lastname" value="<?=$user['last_name'] ?>">
                                    <?php }
                                    if (isset($info['person']['required']['sender_document_number']) && $info['person']['required']['sender_document_number'] == 1) { ?>
                                        <input name="sender_document_number" type="hidden" id="sender_document_number" value="<?=$document ?>">
                                    <?php }
                                } else {

                                    if (isset($info['person']['required']['sender_firstname']) && $info['person']['required']['sender_firstname'] == 1) { ?>
                                        <input name="sender_firstname" type="hidden" id="sender_firstname" value="1">
                                    <?php }
                                    if (isset($info['person']['required']['sender_lastname']) && $info['person']['required']['sender_lastname'] == 1) { ?>
                                        <input name="sender_lastname" type="hidden" id="sender_lastname" value="1">
                                    <?php }
                                    if (isset($info['person']['required']['sender_document_number']) && $info['person']['required']['sender_document_number'] == 1) { ?>
                                        <input name="sender_document_number" type="hidden" id="sender_document_number" value="1">
                                    <?php }

                                }

                                if (isset($info['person']['required']['receiver_firstname']) && $info['person']['required']['receiver_firstname'] == 1) { ?>
                                    <input name="receiver_firstname" type="hidden" id="receiver_firstname" value="<?=$info['person']['receiver']['firstname'] ?>">
                                <?php }
                                if (isset($info['person']['required']['receiver_lastname']) && $info['person']['required']['receiver_lastname'] == 1) { ?>
                                    <input name="receiver_lastname" type="hidden" id="receiver_lastname" value="<?=$info['person']['receiver']['lastname'] ?>">
                                <?php }
                                if (isset($info['person']['required']['receiver_type']) && $info['person']['required']['receiver_type'] == 1) { ?>
                                    <input name="receiver_type" type="hidden" id="receiver_type" value="<?=$info['person']['receiver']['type'] ?>">
                                <?php }

                                ?>

                                <input name="service_id" type="hidden" id="service_id" value="<?=$service_id ?>">
                                <input name="client_commission_percent" type="hidden" id="client_commission_percent" value="<?=$service['commission']['client_commission_percent'] ?>" disabled>
                                <input name="client_commission_fixed" type="hidden" id="client_commission_fixed" value="<?=$service['commission']['client_commission_fixed'] ?>" disabled>
                                <input name="min_client_commission" type="hidden" id="min_client_commission" value="<?=$service['commission']['min_client_commission'] ?>" disabled>
                                <input name="rate" type="hidden" id="rate" value="<?=$service['commission']['rate'] ?>" disabled>
                                <input name="rate_percent" type="hidden" id="rate_percent" value="<?=$service['commission']['rate_percent'] ?>" disabled>
                                <input name="step" type="hidden" value="<?=$step ?>">
                                <div class="form-group text-right">
                                    <br>
                                    <?php if ($step == 2 && isset($post) && $service_id != 114 && $info['errorCode'] == 1000) { ?>

                                        <div class="row">
                                            <?php if ($service['category_id'] != 30) { ?>
                                                <div class="col-md-6">
                                                    <button type="button" class="g1-btn btn-load pay_by_wallet" style="width: 100%;"><span><i class="fa fa-id-badge" aria-hidden="true"></i> საფულით გადახდა</span></button>
                                                </div>
                                                <div class="col-md-6">
                                                    <button type="button" class="g2-btn btn-load pay_by_card" style="width: 100%;"><span><i class="fa fa-credit-card-alt" aria-hidden="true"></i> ბარათით გადახდა</span></button>
                                                </div>
                                            <?php } else { ?>
                                                <div class="col-md-12">
                                                    <button type="button" class="g1-btn btn-load pay_by_wallet" style="width: 100%;"><span><i class="fa fa-id-badge" aria-hidden="true"></i> საფულით გადახდა</span></button>
                                                </div>
                                            <?php } ?>

                                        </div>

                                    <?php } else { ?>

                                    <div class="row">
                                        <div class="col-md-12">
                                            <button type="submit" class="g1-btn" style="width: 100%;"><span><?=$lang['check'] ?></span></button>
                                        </div>
                                    </div>

                                    <?php } ?>
                                </div>
                            </form>
                        </div><!-- end col-md-8 div -->

                        <script>

                            if ($('.msg-error')[0]) {
                                $('.user_input').attr('readonly', false);
                            }

                            // count percent
                            $('#service_form').on('keyup', '#amount', function() {

                                calc1();

                            });

                            $('#service_form').on('keyup', '#generated', function() {

                                re_calc();

                            });

                            $(document).ready(function(){

                                var service_form = $('#service_form');

                                $.validator.addMethod(
                                    'pattern',
                                    function(value, element, pattern) {
                                        var re = new RegExp(pattern);
                                        return this.optional(element) || re.test(value);
                                    },
                                    'ფორმატი არასწორია..'
                                );

                                service_form.validate({
                                    focusInvalid: false,
                                    errorElement: 'span',

                                    rules: {

                                        <?php foreach ($service['params_info'] as $key) {

                                            echo $key['name'] . ": {required: true, pattern: ".$key['regexp']."},";

                                        } ?>
                                        amount: {required: true, min: <?=$service['commission']['min_amount'] ?>,max: <?=$service['commission']['max_amount'] ?>,},
                                        generated: {required: true, min: <?=$service['commission']['min_amount'] ?>,max: <?=$service['commission']['max_amount'] ?>,},
                                        mFirstName: {required: true,  pattern: '^[a-zA-Zა-ჰ]{2,20}$'},
                                        mLastName: {required: true, pattern: '^[a-zA-Zა-ჰ]{2,20}$'},
                                        mPersonal_no: {required: true, pattern: '^[a-zA-Z0-9]{5,15}$'},
                                        mBirthDate: {required: true, pattern: '^[0-9]{4}-(0[1-9]|1[0-2])-(0[1-9]|[1-2][0-9]|3[0-1])$'},

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

                                });

                                function sendSms() {
                                    $('.smsDiv').show();
                                    $.ajax({
                                        type: 'POST',
                                        url: 'loads/payByWallet.php?action=sendSms',
                                        data: [],
                                        dataType: 'json',
                                        success: function (json) {},
                                    });
                                }

                                function deleteSmsSession() {
                                    $.ajax({
                                        type: 'POST',
                                        url: 'loads/payByWallet.php?action=deleteSmsSession',
                                        data: [],
                                        dataType: 'json',
                                        success: function (json) {
                                            $('.send_btn').show();
                                        },

                                    });
                                }

                                $(document).on('click', '.send_btn', function(e) {

                                    sendSms();
                                    $('.send_btn').hide();

                                });

                                $('.pay_by_wallet').on('click', function() {

                                    $('.forCard').hide();

                                    if (service_form.valid()) {

                                        // check auth
                                        $.ajax({
                                            type: 'POST',
                                            url: 'loads/login.php',
                                            data: { checkAuth: 1},
                                            dataType: 'json',
                                            success: function (json) {

                                                if (json.errorCode == 1) {

                                                    <?php  if (isset($type['sms']) AND $type['sms'] == 1) { ?>

                                                        sendSms();
                                                        payPopup('wallet', 1);

                                                        setTimeout(function() {
                                                            deleteSmsSession();
                                                        }, 300000);

                                                    <?php } else { ?>

                                                        payPopup('wallet', 0);

                                                    <?php } ?>

                                                } else {
                                                    $('#loginPay').modal('show');
                                                    setInterval(function() {
                                                        var height = $('.loginIframe').contents().height();
                                                        $('.loginIframe').attr('height', height);

                                                    }, 500);
                                                }

                                            },

                                        });

                                    }
                                });

                                // pay ba merchant
                                $('.pay_by_card').on('click', function() {

                                    if (service_form.valid()) {

                                        if ($('.forCard').is(':visible')) {

                                            payPopup('card', 0);

                                        }
                                        if ($('.forCard').css('display') == 'none') {

                                            $('.forCard').show();

                                        }

                                    }

                                });

                                $('#loginPay').on('hidden.bs.modal', function () {

                                    $('.loginIframe').attr('src', 'https://leaderpay.ge/loginPay.php?1');

                                    // check auth
                                    $.ajax({
                                        type: 'POST',
                                        url: 'loads/login.php',
                                        data: { checkAuth: 1},
                                        dataType: 'json',
                                        success: function (json) {

                                            if (json.errorCode == 1) {

                                                $('.pay_by_wallet').trigger('click');

                                            }

                                        },

                                    });

                                });

                                window.closeModal = function() {
                                    $('#loginPay').modal('hide');
                                };

                                <?php
                                    if (isset($rdu)) {
                                        ?>
                                            $('.user_input').val('<?=$rdu ?>');
                                            $('.g1-btn').trigger('click');
                                        <?php
                                    }
                                    if (isset($rdu) && isset($rdu2)) {
                                        ?>
                                            $('#loan').val('<?=$rdu ?>');
                                            $('#personal_number').val('<?=$rdu2 ?>');
                                            $('.g1-btn').trigger('click');
                                        <?php
                                    }
                                ?>

                            });

                        </script>

                    <?php } else { ?>

                        <div class="msg msg-error">
                            დროებითი ტექნიკური შეფერხებაა
                            <div class="close-p msg-colose" rel="0"></div>
                        </div>

                    <?php } ?>
                    <div class="clearfix"></div>
                </div>
            </div><!-- end col -->
        </div><!-- end row -->
    </div><!-- end container -->
</div><!-- end service_list -->

<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>

<!-- Modal -->
<div class="modal fade" id="loginPay" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">ავტორიზაცია
                    <button type="button" style="border: none;background: transparent;float: right;" data-dismiss="modal"><i style="font-size: 2em;color: #e71f1f;" class="fa fa-times-circle" aria-hidden="true"></i></button>
                </h5>
            </div>
            <div class="modal-body">
                <iframe src="https://leaderpay.ge/loginPay.php" width="100%" height="310" frameborder="0" sandbox="allow-same-origin allow-scripts allow-popups allow-forms allow-top-navigation" allowtransparency="true" scrolling="no" class="loginIframe"></iframe>
            </div>
        </div>
    </div>
</div>

<?php
    include 'includes/footer.php';
?>

<script>
    $(document).on('click', '.save_srv', function(e) {

        if($('#service_form').valid()) {

            json = {};

            $('.for_save').each(function(index, data) {
                var value = $(this).val();
                var name = $(this).attr('name');

                json[name] = value;

            });

            json['service_id'] = <?=$service_id  ?>;

            $.ajax({
                type: 'POST',
                url: 'loads/payByWallet.php?action=saveService',
                data: json,
                dataType: 'json',
                success: function(data) {

                    $('.save_srv').prop('disabled', true);
                    $('.save_srv').html('<i class="fa fa-check-circle" aria-hidden="true"></i> <span>დამატებულია შაბლონებში</span>');

                }

            });

        }

    });
</script>
