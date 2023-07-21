<?php
    require_once 'includes/head.php';

    $active = 'register';
    $page_title = $lang['sing_up'];

    //check user
    if ($db->check_auch() == true) {
        header('Location: profile.php');
    }

    include 'includes/header.php';

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

                <div class="msg msg-danger">რეგისტრაცია დროებით გათიშულია!</div>

                <form action="" method="post" autocomplete="off" id="registracion_form" style="display:none;">

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
                                            <div class="col-md-12 col-sm-6">
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

                                        <div class="row">
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

