<?php
    require_once('includes/head.php');

    $active = 'login';
    $page_title = $lang['log_in'];

    //check user
    if ($db->check_auch() == true) {
        header('Location: profile.php');
    }
    unset($_SESSION['sms']);

    require_once('includes/header.php');
?>

<div class="container page">
    <div class="row">
        <div class="col-md-12">
            <div class="login-box clear">
                <div class="col-md-6 col-sm-6">
                    <div class="modal-body">
                        <h4 class="login-title"><?=$lang['enter_the_wallet'] ?></h4>
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
                                <div class="m-text">
                                    <a href="lostpass.php">პაროლის აღდგენა</a>
                                </div>
                            </div>

                            <div class="form-group inputs-whit-icon text-center">
                                <input type="hidden" id="methid" value="user">
                                <button type="submit" name="login" class="g1-btn"><?=$lang['sign_in'] ?>  </button>
                            </div>
                        </form>
                    </div>
                </div>
                <div class="col-md-6 col-sm-6">
                    <div class="register-txt">
                        <a href="register.php">
                            <div class="reg-icon">
                                <img src="assets/img/add-user.png" alt="add user">
                            </div>
                        </a>
                        <p><?=$lang['login_txt_1'] ?><a href="register.php"><?=$lang['sign_up_1'] ?></a><?=$lang['create_wallet'] ?></p>
                    </div>
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

                            window.location.replace('profile.php');

                        } else if(json.errorCode == 2) {

                            $('.msg-error').show();
                            $('.msg-error').html(json.errorMessage);

                            setTimeout(function() {
                                window.location.replace('login.php');
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

<?php include 'includes/footer.php'; ?>

