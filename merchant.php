<?php
require_once('includes/head.php');
require_once ('merchant/login.php');
?>
<!DOCTYPE html>
<head>
    <title>Merchant</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/js/bootstrap.min.js"></script>
    <link rel="stylesheet" href="assets/css/merchant.css">
    <link rel="stylesheet" href="assets/css/style.css?<?php echo time(); ?>">
    <link rel='stylesheet prefetch' href='https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.7/css/bootstrap.min.css'>
    <link rel="stylesheet" href="assets/css/fonts_<?php echo $lang_id ?>.css?<?php echo time(); ?>">
    <link rel="stylesheet" href="assets/plugins/intl-tel-input/intlTelInput.css">
    <link rel="stylesheet" href="assets/plugins/boxslider/jquery.bxslider.css?<?php echo time(); ?>">
    <link rel="stylesheet" href="assets/plugins/toastr/toastr.min.css">
    <link rel="stylesheet" href="assets/plugins/select2/select2.css?<?php echo time(); ?>">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
</head>
<body>
<article class="info_box">
    <section class="heading">
        <h4>გადახდის დეტალები</h4>
    </section>
        <table class="table table-dark">
            <thead>
            <tr>
                <th scope="col" style="font-size: 14px;">ID</th>
                <th scope="col" style="font-size: 14px;">მაღაზია</th>
                <th scope="col" style="font-size: 14px;">შეკვეთის აღწერა</th>
                <th scope="col" style="font-size: 14px;">თანხა</th>
                <th scope="col" style="font-size: 14px;">საკომისიო</th>
            </tr>
            </thead>
            <tbody>
            <tr>
                <td>265715</td>
                <th scope="row">
                    <div><?= isset($_SESSION['saller_name']) ? $_SESSION['saller_name'] : ''; ?>!</div>
                    <?php $_SESSION['saller_name'] = 'Amazon.com'; ?>
                </th>
                <td>პროდუქტი N23</td>
                <td>65</td>
                <td>1.5</td>


            </tr>
            </tbody>
        </table>
        <?php if ($db->check_auch() == false) : ?>
            <article class="merchant_btn_box">
                <p class="enter_sistem"> <button id="btn_login" class="button login_button down">ავტორიზაცია</button></p>
                <button class="button pay_button"style="display: none;">გადახდა</button>
            </article>
        <?php else : ?>
            <button type="button" class="button pay_button merchant_pay_btn">გადახდა</button>
        <?php endif; ?>

</article>
<?php
    $page_style = "<script src='https://www.google.com/recaptcha/api.js?onload=CaptchaCallback&render=explicit\" async defer'></script>";
if (isset($page_style)) {

    echo $page_style;
}
    include 'merchant/login_form.php';
    include 'merchant/registration_form.php';
?>
</body>
</html>

<script src="merchant/assets/js/merchant.js"></script>

<!-- validation -->
<script type="text/javascript" src="./assets/plugins/jquery-validation/js/jquery.validate.min.js"></script>
<script type="text/javascript" src="./assets/plugins/jquery-validation/js/localization/messages_<?=$lang_id ?>.js"></script>
<script type="text/javascript" src="./assets/plugins/jquery-validation/js/additional-methods.min.js"></script>
<!-- input masks -->
<script type="text/javascript" src="./assets/plugins/inputmask/jquery.inputmask.bundle.js"></script>
<!-- telephone -->
<script src="./assets/plugins/intl-tel-input/intlTelInput.js"></script>
<!-- slider -->
<script src="./assets/plugins/boxslider/jquery.bxslider.js?"></script>
<script  src="assets/js/index.js?<?php echo time(); ?>"></script>
<!-- toastr -->
<script src="./assets/plugins/toastr/toastr.min.js"></script>
<!-- select2 -->
<script src="./assets/plugins/select2/select2.min.js?<?php echo time(); ?>"></script>