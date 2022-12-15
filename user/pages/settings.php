<?php

    if (isset($post)) {

        $currentPassword = htmlspecialchars(trim($post['currentPassword']), ENT_QUOTES);
        $currentPassword = hash('sha256', $currentPassword);
        $newPassword = htmlspecialchars(trim($post['newPassword']), ENT_QUOTES);
        $newPassword = hash('sha256', $newPassword);
        $repeatPassword = htmlspecialchars(trim($post['repeatPassword']), ENT_QUOTES);
        $repeatPassword = hash('sha256', $repeatPassword);

        if ($db->checkPassword($currentPassword) == false) {

            $error = 'მიმდინარე პაროლი არასწორია!';

        } else if ($newPassword != $repeatPassword) {

            $error = 'გამეორებული პაროლი არ ემთხვევა!';

        } else {

            if ($db->updatePassword($repeatPassword) != false) {

                $success = 'პაროლი წარმატებით შეიცვალა';

            }
        }

    }

?>
    <div class="title"><?=$lang['change_password'] ?></div>
    <div class="sub-page-body col-md-12">
        <!--<div class="col-md-12 setting">
            <input id='google_authenticator' name="google_authenticator" class='ios-switch' type='checkbox'>
            <label for='google_authenticator' class='ios-switch-label'></label>
            <span>ავტორიზება Google Authenticator-ით</span>
        </div>
        <div class="col-md-12 setting">
            <input id='sms_authenticator' checked name="sms_authenticator" class='ios-switch' type='checkbox'>
            <label for='sms_authenticator' class='ios-switch-label'></label>
            <span>ავტორიზება SMS-ით</span>
        </div> -->
        <?php if (isset($error)) { ?>
            <div class="msg msg-error"><?=$error ?></div>
        <?php } ?>
        <?php if (isset($success)) { ?>
            <div class="msg msg-succses"><?=$success ?></div>
        <?php } ?>
        <div class="col-md-12">
            <form action="" id="password" method="post">
                <div class="form-group text-left">
                    <label for="currentPassword"><?=$lang['current_password'] ?></label>
                    <input type="password" name="currentPassword" id="currentPassword" class="input" autocomplete="off" required>
                </div>
                <div class="form-group text-left">
                    <label for="newPassword"><?=$lang['new_password'] ?></label>
                    <input minlength="8" type="password" name="newPassword" id="newPassword" class="input" autocomplete="off" required>
                </div>
                <div class="form-group text-left">
                    <label for="repeatPassword"><?=$lang['repeat_password'] ?></label>
                    <input minlength="8" type="password" name="repeatPassword" id="repeatPassword" class="input" autocomplete="off" required>
                </div>
                <div class="col-md-12 text-left" style="padding-left: 0;">
                    <button type="submit" class="g1-btn"><span><?=$lang['send'] ?></span></button>
                </div>
            </form>
        </div>
    </div>

<?php $page_script = '<script src="assets/pages/password.js?' . time() . '"></script>'; ?>
