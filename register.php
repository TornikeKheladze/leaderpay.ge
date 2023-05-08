<?php
    require_once 'includes/head.php';

    $active = 'register';
    $page_title = $lang['sing_up'];

    //check user
    if ($db->check_auch() == true) {
        header('Location: profile.php');
    }

    include 'includes/header.php';

    $countries = $db->get_unlimited_list('countries', ' code > 0 ', 'code', 'desc');
    $sferos = $db->get_unlimited_list('sferos', ' id > 0 ', 'id', 'ASC');

    $employee_status = $db->get_unlimited_list('user_employee_status', 'id > 0', 'id', 'asc');

    $self_employed = $db->get_unlimited_list('user_self_employed', 'id > 0', 'id', 'asc');
    $monthly_income = $db->get_unlimited_list('user_monthly_income', 'id > 0', 'id', 'asc');
    $expected_turnover = $db->get_unlimited_list('user_expected_turnover', 'id > 0', 'id', 'asc');
    $purpose_relationship = $db->get_unlimited_list('user_purpose_relationship', 'id > 0', 'id', 'asc');
    $user_pep = $db->get_unlimited_list('user_pep', 'id > 0', 'id', 'asc');

?>
<style>
    .select2-container {
        max-width: 100%;
    }
</style>
<div class="container page">
    <div class="row">
        <div class="col-md-12">
            <div class="page-bg fluid clear">
                <h3 class="page-title" style="margin: 15px 0 0 0;">
                    <span class="t r"><?=$lang['sing_up'] ?></span>
                </h3>
                <form action="" method="post" autocomplete="off" id="registracion_form">

                    <div class="reg_loader" style="display: none">
                        <span class="helper"></span>
                        <img src="assets/img/g_loader.gif" alt="">
                    </div>

                    <div id="rootwizard">
                        <ul>
                            <li><a href="#tab1" data-toggle="tab"><?=$lang['first_step'] ?></a></li>
                            <li><a href="#tab2" data-toggle="tab"><?=$lang['second_step'] ?></a></li>
                            <li><a href="#tab3" data-toggle="tab"><?=$lang['finish'] ?></a></li>
                        </ul>
                        <div class="tab-content">
                            <div class="tab-pane" id="tab1">

                                <div class="row">
                                    <div class="col-md-12 col-sm-12">

                                        <div class="row">
                                            <div class="col-md-6 col-sm-6">
                                                <div class="form-group req">
                                                    <label for="first_name1">სახელი</label>
                                                    <input name="first_name1" type="text" id="first_name1" class="input" value="" readonly onfocus="this.removeAttribute('readonly');">
                                                </div>
                                            </div> <!-- end col -->
                                            <div class="col-md-6 col-sm-6">
                                                <div class="form-group req">
                                                    <label for="last_name1">გვარი</label>
                                                    <input name="last_name1" type="text" id="last_name1" class="input" value="" readonly onfocus="this.removeAttribute('readonly');">
                                                </div>
                                            </div> <!-- end col -->
                                        </div><!-- end row -->

                                        <div class="row">
                                            <div class="col-md-12 col-sm-6">
                                                <div class="form-group req">
                                                    <label for="personal_number1">პირადი ნომერი</label>
                                                    <input name="personal_number1" type="text" id="personal_number1" minlength="11" maxlength="11" class="input" value="" readonly onfocus="this.removeAttribute('readonly');">
                                                </div>
                                            </div> <!-- end col -->
                                        </div><!-- end row -->

                                        <div class="row">
                                            <div class="col-md-6 col-sm-6">
                                                <div class="form-group req">
                                                    <label for="phone"><?=$lang['telephone_number'] ?></label>
                                                    <input onkeypress="return isIntKey(event);" name="phone" type="tel" id="phone" class="input" value="" readonly onfocus="this.removeAttribute('readonly');">
                                                </div>
                                            </div> <!-- end col -->
                                            <div class="col-md-6 col-sm-6">
                                                <div class="form-group req">
                                                    <label for="phone"><?=$lang['email'] ?></label>
                                                    <input name="email" type="email" id="email" class="input" value="" readonly onfocus="this.removeAttribute('readonly');">
                                                </div>
                                            </div> <!-- end col -->
                                        </div><!-- end row -->

                                        <div class="row">
                                            <div class="col-md-6 col-sm-6">
                                                <div class="form-group req">
                                                    <label for="legal_address"><?=$lang['legal_address'] ?></label>
                                                    <input name="legal_address" type="text" id="legal_address" class="input" value="" readonly onfocus="this.removeAttribute('readonly');">
                                                </div>
                                            </div> <!-- end col -->
                                            <div class="col-md-6 col-sm-6">
                                                <div class="form-group req">
                                                    <label for="real_address"><?=$lang['real_address'] ?></label>
                                                    <input name="real_address" type="text" id="real_address" class="input" value="" readonly onfocus="this.removeAttribute('readonly');">
                                                </div>
                                            </div> <!-- end col -->
                                        </div> <!-- end row -->

                                        <div class="row">
                                            <div class="col-md-6 col-sm-6">
                                                <div class="form-group req">
                                                    <label for="password"><?=$lang['password'] ?></label>
                                                    <input name="password" type="password" id="password" class="input" value="" readonly onfocus="this.removeAttribute('readonly');">
                                                </div>
                                            </div> <!-- end col -->
                                            <div class="col-md-6 col-sm-6">
                                                <div class="form-group req">
                                                    <label for="repeat_password"><?=$lang['repeat_password'] ?></label>
                                                    <input name="repeat_password" type="password" id="repeat_password" class="input" value="" readonly onfocus="this.removeAttribute('readonly');">
                                                </div>
                                            </div> <!-- end col -->
                                        </div> <!-- end row -->
                                        
                                    </div><!-- end col-md-6 -->
                                </div> <!-- end row -->

                            </div> <!-- end tab 1 -->
                            <div class="tab-pane" id="tab2">

                                <iframe
                                    src=""
                                    allow="camera"
                                    width="100%"
                                    height="800px"
                                    frameBorder="0"
                                    class="identomat">
                                </iframe>
                                <input type="hidden" name="iToken" id="iToken" value="">
                                <input type="hidden" name="pNumber" id="pNumber" value="">
                                
                            </div> <!-- end tab 2 -->
                            <div class="tab-pane" id="tab3">
                                
                                <div class="row">
                                    <div class="col-md-6 col-sm-6">
                                        <div class="form-group req">
                                            <label for="dual_citizen"><?=$lang['dual_citizen'] ?></label>
                                            <select name="dual_citizen" id="dual_citizen" class="input select2-container select2me" onChange="checkDualCitizen(this.value);">
                                                <option value=""><?=$lang['select'] ?></option>
                                                <option value="1"><?=$lang['yes'] ?></option>
                                                <option value="2"><?=$lang['no'] ?></option>
                                            </select>
                                        </div>
                                    </div> <!-- end col -->

                                    <div class="col-md-6 col-sm-6 country2 none">
                                        <div class="form-group req">
                                            <label for="country2"><?=$lang['second_country'] ?></label>
                                            <select name="country2" id="country2" class="input select2-container select2me">
                                                <option value=""><?=$lang['select'] ?></option>

                                                <?php foreach($countries as $c) { ?>
                                                    <option value="<?=$c['ccode'] ?>"><?=$c['country'] ?></option>
                                                <?php } ?>

                                            </select>
                                        </div>
                                    </div> <!-- end col -->

                                    <div class="col-md-6 col-sm-6">
                                        <div class="form-group req">
                                            <label for="birth_country"><?=$lang['country_of_birth'] ?></label>
                                            <select name="birth_country" id="birth_country" class="input select2-container select2me">
                                                <option value=""><?=$lang['select'] ?></option>

                                                <?php foreach($countries as $c) { ?>
                                                    <option value="<?=$c['ccode'] ?>"><?=$c['country'] ?></option>
                                                <?php } ?>

                                            </select>
                                        </div>
                                    </div> <!-- end col -->

                                    <div class="col-md-6 col-sm-6">
                                        <div class="form-group req">
                                            <label for="employee_status"><?=$lang['employee_status'] ?></label>
                                            <select name="employee_status" id="employee_status" class="input select2-container select2me" onChange="checkEmployeeStatus(this.value);">
                                                <option value=""><?=$lang['select'] ?></option>

                                                <?php foreach($employee_status as $i) { ?>
                                                    <option value="<?=$i['id'] ?>"><?=$i['name'] ?></option>
                                                <?php } ?>

                                            </select>
                                        </div>
                                    </div> <!-- end col -->

                                    <div class="col-md-6 col-sm-6 sferoIdDiv none">
                                        <div class="form-group req">
                                            <label for="sfero_id"><?=$lang['field_of_activity'] ?></label>
                                            <select name="sfero_id" id="sfero_id" class="input select2-container select2me">
                                                <option value=""><?=$lang['select'] ?></option>

                                                <?php foreach($sferos as $i) { ?>
                                                    <option value="<?=$i['id'] ?>"><?=$i['name'] ?></option>
                                                <?php } ?>

                                            </select>
                                        </div>
                                    </div> <!-- end col -->

                                    <div class="col-md-6 col-sm-6 selfEmployeeDiv none">
                                        <div class="form-group req">
                                            <label for="self_employed"><?=$lang['self_employed'] ?></label>
                                            <select name="self_employed" id="self_employed" class="input select2-container select2me">
                                                <option value=""><?=$lang['select'] ?></option>
                                                
                                                <?php foreach($self_employed as $i) { ?>
                                                    <option value="<?=$i['id'] ?>"><?=$i['name'] ?></option>
                                                <?php } ?>

                                            </select>
                                        </div>
                                    </div> <!-- end col -->

                                    <div class="col-md-6 col-sm-6 sourceIncomeDiv none">
                                        <div class="form-group req">
                                            <label for="source_of_income"><?=$lang['source_of_income'] ?></label>
                                            <input name="source_of_income" type="text" id="source_of_income" class="input" value="" readonly onfocus="this.removeAttribute('readonly');">
                                        </div>
                                    </div> <!-- end col -->

                                    <div class="col-md-6 col-sm-6 jobTitleDiv none">
                                        <div class="form-group req">
                                            <label for="job_title"><?=$lang['job_title'] ?></label>
                                            <input name="job_title" type="text" id="job_title" class="input" value="" readonly onfocus="this.removeAttribute('readonly');">
                                        </div>
                                    </div> <!-- end col -->

                                    <div class="col-md-6 col-sm-6 jobTitleDiv none">
                                        <div class="form-group req">
                                            <label for="occupied_position"><?=$lang['occupied_position'] ?></label>
                                            <input name="occupied_position" type="text" id="occupied_position" class="input" value="" readonly onfocus="this.removeAttribute('readonly');">
                                        </div>
                                    </div> <!-- end col -->

                                    <div class="col-md-6 col-sm-6">
                                        <div class="form-group req">
                                            <label for="monthly_income"><?=$lang['monthly_income'] ?></label>
                                            <select name="monthly_income" id="monthly_income" class="input select2-container select2me">
                                                <option value=""><?=$lang['select'] ?></option>

                                                <?php foreach($monthly_income as $i) { ?>
                                                    <option value="<?=$i['id'] ?>"><?=$i['name'] ?></option>
                                                <?php } ?>

                                            </select>
                                        </div>
                                    </div> <!-- end col -->

                                    <div class="col-md-6 col-sm-6">
                                        <div class="form-group req">
                                            <label for="expected_turnover"><?=$lang['expected_turnover'] ?></label>
                                            <select name="expected_turnover" id="expected_turnover" class="input select2-container select2me">
                                                <option value=""><?=$lang['select'] ?></option>

                                                <?php foreach($expected_turnover as $i) { ?>
                                                    <option value="<?=$i['id'] ?>"><?=$i['name'] ?></option>
                                                <?php } ?>

                                            </select>
                                        </div>
                                    </div> <!-- end col -->

                                    <div class="col-md-6 col-sm-6">
                                        <div class="form-group req">
                                            <label for="purpose_id"><?=$lang['purpose_id'] ?></label>
                                            <select name="purpose_id" id="purpose_id" class="input select2-container select2me">
                                                <option value=""><?=$lang['select'] ?></option>
                                                
                                                <?php foreach($purpose_relationship as $i) { ?>
                                                    <option value="<?=$i['id'] ?>"><?=$i['name'] ?></option>
                                                <?php } ?>

                                            </select>
                                        </div>
                                    </div> <!-- end col -->

                                    <div class="col-md-6 col-sm-6">
                                        <div class="form-group req">
                                            <label for="pep_status"><?=$lang['pep_status'] ?></label>
                                            <select name="pep_status" id="pep_status" class="input select2-container select2me" onChange="checkPepStatus(this.value);">
                                                <option value=""><?=$lang['select'] ?></option>
                                                <option value="1"><?=$lang['yes'] ?></option>
                                                <option value="0"><?=$lang['no'] ?></option>
                                            </select>
                                        </div>
                                    </div> <!-- end col -->

                                    <div class="col-md-6 col-sm-6 pep_div none">
                                        <div class="form-group req">
                                            <label for="pep"><?=$lang['pep'] ?></label>
                                            <select name="pep" id="pep" class="input select2-container select2me">
                                                <option value=""><?=$lang['select'] ?></option>

                                                <?php foreach($user_pep as $i) { ?>
                                                    <option value="<?=$i['id'] ?>"><?=$i['name'] ?></option>
                                                <?php } ?>

                                            </select>
                                        </div>
                                    </div> <!-- end col -->
                                </div><!-- end row -->

                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="form-group checkbox">
                                                    <div class="md-checkbox">
                                                        <input id="limits" name="limits" type="checkbox">
                                                        <label for="limits">გავეცანი და ვეთანხმები <a href="assets/files/limits.pdf" target="_blank">ტარიფებს და საოპერაციო ლიმიტებს</a></label>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div> <!-- end col -->
                                </div><!-- end row div -->

                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="form-group checkbox">
                                                    <div class="md-checkbox">
                                                        <input id="privacy_policy" name="privacy_policy" type="checkbox">
                                                        <label for="privacy_policy">გავეცანი და ვეთანხმები <a href="assets/files/privacy_policy.pdf" target="_blank">პერსონალური ინფორმაცია და კონფიდენციალურობის პოლიტიკას</a></label>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div> <!-- end col -->
                                </div><!-- end row div -->

                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="form-group checkbox">
                                                    <div class="md-checkbox">
                                                        <input id="contract" name="contract" type="checkbox">
                                                        <label for="contract">გავეცანი და ვეთანხმები <a href="assets/files/contract.pdf" target="_blank"> ხელშეკრულებას ელექტრონული საფულეში რეგისტრაციასა და მის სარგებლობასთან დაკავშირებით</a></label>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div> <!-- end col -->
                                </div><!-- end row div -->

                            </div> <!-- end tab 3 -->

                            <div class="row">
                                <div class="col-md-12">
                                    <div class="row">
                                        <div class="col-md-12">
                                            <br><hr><br>
                                        </div> <!-- end col -->
                                    </div><!-- end row div -->
                                </div> <!-- end col -->
                            </div><!-- end row div -->

                            <ul class="pager wizard">
                                <!-- <li class="previous first" style="display:none;"><a href="#">პირველი</a></li> -->
                                <li class="previous" style="visibility: hidden;"><a href="#"><?=$lang['back'] ?></a></li> 
                                <li class="next last" style="display:none;"><a href="#" class="g1-btn"><i class="fa fa-check-circle" aria-hidden="true"></i> <?=$lang['finish'] ?></a></li>
                                <li class="next"><a href="#" class="g1-btn"><?=$lang['next'] ?> <i class="fa fa-long-arrow-right" aria-hidden="true"></i></a></li>
                            </ul>
                        </div>
                    </div>
            
                </form>
            </div><!-- end page-bg -->
        </div><!-- end col -->
    </div><!-- end row -->

</div><!-- end container -->

<?php

    $page_script = '<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js"></script><script src="https://vinceg.github.io/twitter-bootstrap-wizard/jquery.bootstrap.wizard.js"></script><script src="assets/pages/registration.js?' . time() . '"></script>';

    include 'includes/footer.php';
?>

