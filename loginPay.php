<?php

    require_once 'includes/head.php';
    unset($_SESSION['sms']);

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <link rel='stylesheet prefetch' href='https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.7/css/bootstrap.min.css'>
    <link rel="stylesheet" href="assets/css/style.css?<?=time() ?>">
    <link rel="stylesheet" href="assets/css/fonts_ge.css?<?=time() ?>">
    <script
            src="https://code.jquery.com/jquery-3.6.1.min.js"
            integrity="sha256-o88AwQnZB+VDvE9tvIXrMQaPlFFSUTR+nldQm1LuPXQ="
            crossorigin="anonymous">
    </script>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
</head>
<body>
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="clear">
                    <div class="modal-body">
                        <form action="" method="post" autocomplete="off" id="login" novalidate="novalidate">
                            <div class="loader" style="display: none;"></div>
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="msg msg-error" style="display: none"></div>
                                </div>
                            </div>

                            <div class="smsDiv" <?=(isset($_SESSION['sms'])) ? 'style="display: block"' : 'style="display: none"' ?>>
                                <div class="form-group inputs-whit-icon">
                                    <label for="sms_code"><?=$lang['sms_code']?></label>
                                    <span class="form-icon" style="background: url('assets/img/sms.png'); opacity: 3;"></span>
                                    <input type="text" name="sms_code" id="sms_code" class="input" autocomplete="off" required>
                                </div>
                            </div>

                            <div class="userDiv" <?=(isset($_SESSION['sms'])) ? 'style="display: none"' : 'style="display: block"' ?>>
                                <div class="form-group inputs-whit-icon">
                                    <label for="username"><?=$lang['wallet_number'] ?></label>
                                    <span class="form-icon" style="background: url('assets/img/personal.png')"></span>
                                    <input onkeypress="return isIntKey(event);" maxlength="11" type="text" name="username" id="username" class="input" autocomplete="off" required>
                                </div>
                                <div class="form-group inputs-whit-icon">
                                    <label for="password"><?=$lang['password'] ?></label>
                                    <span class="form-icon" style="background: url('assets/img/key.png')"></span>
                                    <input type="password" name="password" id="password" class="input" autocomplete="off" required>
                                </div>
                            </div>

                            <div class="form-group inputs-whit-icon text-center">
                                <input type="hidden" id="methid" value="user">
                                <button type="submit" name="login" class="g1-btn"><?=$lang['sign_in'] ?>  </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script>
        $( document ).ready(function() {

            $(document).on('submit', '#login', function (e) {

                e.preventDefault();

                var username = $('#username').val();
                var password = $('#password').val();
                var sms_code = $('#sms_code').val();

                $('.loader').show();

                var method = $('#methid').val();

                $.ajax({
                    type: 'POST',
                    url: 'loads/login.php',
                    data: { username: username, password: password, sms_code: sms_code, method: method },
                    dataType: 'json',
                    success: function (json) {

                        $('.loader').hide();

                        if (method == 'user') {

                            if (json.errorCode == 1) {

                                $('#methid').val('sms');

                                $('.msg-error').hide();

                                $('.userDiv').hide();
                                $('.smsDiv').show();

                            } else {

                                $('.msg-error').show();
                                $('.msg-error').html(json.errorMessage);

                            }

                        }

                        if (method == 'sms') {

                            if (json.errorCode == 1) {

                                window.parent.closeModal();

                            } else if(json.errorCode == 2) {

                                $('.msg-error').show();
                                $('.msg-error').html(json.errorMessage);

                                setTimeout(function() {
                                    window.location.replace('loginPay.php');
                                }, 2000);

                            } else {

                                $('.msg-error').show();
                                $('.msg-error').html(json.errorMessage);

                            }

                        }

                    },

                });

            });
        });

        </script>
    </body>
</html>

