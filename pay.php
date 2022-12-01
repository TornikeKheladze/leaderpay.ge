<?php

    require_once('includes/head.php');

    if (isset($get['id']) && $get['id'] != '' && isset($get['step']) ) {

        $service_id = (INT) $get['id'];
        $step = (INT) $get['step'];

        if ($service_id == 90) {

            if ($db->check_auch() != true) {
                header('Location: login.php');
            }

        }

    } else {

        header('Location: services.php');
    }

    if ($service_id == 90 && $db->check_auch() == true && $step == 1) {

        $pin = $user['pin_code'];
        if (strlen($pin) > 3) {

            header("Location: pay.php?step=2&id=90&rdu=$pin");

        } else {
            header("Location: pay.php?step=2&id=90&error=სერვისი თქვენთვის მიუწვდომელია, გთხოვთ დაუკავშირდით 'ოლლ ფეი ვეის'");
        }
    }
    if ($service_id == 90 && $db->check_auch() == true && $get['step'] == 2 && isset($get['rdu'])) {

        $rdu = htmlspecialchars($get['rdu'], ENT_QUOTES);
        $pin = $user['pin_code'];
        if ($pin != $rdu) {

            header("Location: pay.php?step=2&id=90&error=სერვისი თქვენთვის მიუწვდომელია, გთხოვთ დაუკავშირდით 'ოლლ ფეი ვეის'");

        }

    }

    $rdu2 = (isset($get['rdu2'])) ? htmlspecialchars($get['rdu2'], ENT_QUOTES) : null;
    $error = (isset($get['error'])) ? htmlspecialchars($get['error'], ENT_QUOTES) : null;

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
                        </div><!-- end col-md-4 div -->
                        <div class="col-md-8 b-left">
                            <div class="msg-area"></div>
                            <form class="payForm" id="service_form" action="<?=($step == 1) ? "pay.php?step=2&id=$service_id" : "" ?>" method="post">
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="msg msg-error" style="display: none"><?=$lang['required'] ?></div>
                                    </div>
                                </div>
                                <?php

                                foreach ($service['params_info'] as $key) {

                                    // if is birthdate
                                    if ($key['name'] == 'birthdate') { ?>

                                        <div class="form-group text-left">
                                            <label for="<?=$key['name'] ?>"><?=$key['description'] ?></label>

                                            <div class="row date-row">
                                                <div class="col-md-4 col-sm-4 col-xs-4">
                                                    <select name="year" id="year" class="input select2-container select2me">
                                                        <option value=""><?=$lang['year'] ?></option>

                                                        <?php foreach ($year_array as $year) { ?>

                                                            <?php if ($year > 2010 ) { ?>
                                                                <?php continue; ?>
                                                            <?php } ?>

                                                            <option value="<?=$year ?>" <?=($step == 2 && isset($post['year']) && $post['year'] == $year) ? 'selected readonly' : '' ?>><?=$year ?></option>

                                                        <?php } ?>

                                                    </select>
                                                </div>
                                                <div class="col-md-4 col-sm-4 col-xs-4">
                                                    <select name="month" id="month" class="input select2-container select2me">
                                                        <option value=""><?=$lang['month'] ?></option>

                                                        <?php foreach ($month_array as $key  => $value) { ?>

                                                            <option value="<?=$key ?>" <?=($step == 2 && isset($post['month']) && $post['month'] == $key) ? 'selected readonly' : '' ?>><?=$value[$lang_id] ?></option>

                                                        <?php } ?>

                                                    </select>
                                                </div>
                                                <div class="col-md-4 col-sm-4 col-xs-4">
                                                    <select name="day" id="day" class="input select2-container select2me">
                                                        <option value=""><?=$lang['day'] ?></option>

                                                        <?php foreach ($day_array as $key  => $value) { ?>

                                                            <option value="<?=$key ?>" <?=($step == 2 && isset($post['day']) && $post['day'] == $key) ? 'selected readonly' : '' ?>><?=$value ?></option>

                                                        <?php } ?>

                                                    </select>
                                                </div>
                                            </div>
                                        </div>

                                    <?php } else { ?>

                                        <div class="form-group text-left">
                                            <label for="<?=$key['name'] ?>"><?=$key['description'] ?></label>
                                            <input name="<?=$key['name'] ?>" type="text" id="<?=$key['name'] ?>" value="<?=($step == 2 && isset($post)) ? $post[$key['name']] : '' ?>" <?=($get['step'] == 2 && isset($post)) ? 'readonly' : '' ?> class="input user_input" autocomplete="off">
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

                                            <div class="msg msg-error" role="alert"><?=$info['errorMessage'] ?></div>

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

                        <!-- validation -->
                        <script type="text/javascript" src="assets/plugins/jquery-validation/js/jquery.validate.min.js"></script>
                        <script type="text/javascript" src="assets/plugins/jquery-validation/js/additional-methods.min.js"></script>
                        <script type="text/javascript" src="./assets/plugins/jquery-validation/js/localization/messages_<?=$lang_id ?>.js"></script>
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
                                        amount: {required: true,min: <?=$service['commission']['min_amount'] ?>,max: <?=$service['commission']['max_amount'] ?>,},
                                        generated: {required: true,min: <?=$service['commission']['min_amount'] ?>,max: <?=$service['commission']['max_amount'] ?>,},

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

                                        payPopup('card', 0);

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
