<?php
exit();
  require_once('includes/head.php');

  //
  $active = 'register';
  $page_title = 'ვერიფიკაცია';


  $page_style = "<link rel='stylesheet' type='text/css' href='https://manager.allpayway.ge/assets/global/plugins/cropperjs/cropper.min.css'><script src='https://www.google.com/recaptcha/api.js'></script>";

 include 'includes/header.php';

 $users_document_types = $db->get_unlimited_list('users_document_types',' `id` > 0', "id", "ASC");

 $sferos = $db->get_unlimited_list('sferos',' `id` > 0', "id", "ASC");


?>

  <div class="container page">
    <div class="row">
      <div class="col-md-12">
        <div class="page-bg fluid clear">
          <h3 class="page-title">
            <span class="t r">ვერიფიკაცია<?php // echo $lang['sing_up']; ?></span>
          </h3>

          <div class="steps">
            <div class="steps-head">
            <ul class="list-unstyled multi-steps">
              <li class="is-active">შემოწმება</li>
              <li>SMS დადასტურება</li>
              <li>დოკუმენტის ატვირთვა</li>
              <li>დადასტურება</li>
            </ul>
            </div><!-- end steps-head -->
            <div class="steps-body">
              <div class="step active">

                <form class="form_step st_1" rel="1" action="https://leaderpay.ge/loads/verification.php?action=sms" method="post" autocomplete="off">
                  <div class="msg msg-error" style="display:none">შეავსე სავალდებულო ველები.</div>

                  <div class="fields">

                    <div class="form-group">
                      <label for="personal_number">პირადი ნომერი</label>
                      <input onkeypress="return isIntKey(event);" maxlength="11" type="text" name="personal_number" required="true" id="personal_number" class="input" value="">
                    </div>
                    <div class="form-group">
                      <label for="document_number">დოკუმენტის ნომერი</label>
                      <input  maxlength="20" type="text" name="document_number" required="true" id="document_number" class="input" value="">
                    </div>

                  </div>

                  <br><hr>
                  <div class="form-group text-center">
                    <button type="submit" name="submit" class="g1-btn">გაგზავნა</button>
                  </div>
                </form>

              </div>
              <div class="step">

                <form class="form_step st_2" rel="2" action="https://leaderpay.ge/loads/verification.php?action=check" method="get" autocomplete="off">
                  <div class="msg msg-error" style="display:none">შეავსე სავალდებულო ველები.</div>

                  <div class="fields">

                    <div class="form-group">
                      <label for="sms">sms-ით მიღებული კოდი</label>
                      <input onkeypress="return isIntKey(event);" maxlength="6" type="text" name="sms" required="true"  id="sms" class="input" value="">
                    </div>

                  </div>

                  <br><hr>
                  <div class="form-group text-center">
                    <button type="submit" name="submit" class="g1-btn">გაგზავნა</button>
                  </div>
                </form>

              </div>
              <div class="step">

                <form class="form_step st_3" rel="3" action="https://leaderpay.ge/loads/verification.php?action=file" method="get" autocomplete="off">

                  <div class="modal fade bs-modal-lg in" id="cropModal" tabindex="-1" role="dialog" aria-hidden="false">
                    <div class="modal-backdrop fade in"></div>
                    <div class="modal-dialog modal-lg">
                      <div class="modal-content">
                        <div class="modal-header">
                          <h4 class="modal-title" id="cropImageTitle">სურათის მოჭრა</h4>
                          <div class="cropButtons">
                              <i class="fa fa-search-plus" onClick='$image.cropper("zoom", 0.1)' aria-hidden="true"></i>
                            <i class="fa fa-search-minus" onClick='$image.cropper("zoom", -0.1)' aria-hidden="true"></i>
                            <i class="fa fa-repeat" onClick='$image.cropper("rotate", -90)' aria-hidden="true"></i>
                            <i class="fa fa-undo" onClick='$image.cropper("rotate", 90)' aria-hidden="true"></i>
                          </div>
                          </div>
                        <div class="modal-body">
                          <div class="row">
                            <div class="col-md-12">
                              <img src="" id="cropImage">
                            </div>
                          </div>
                        </div>
                        <div class="modal-footer">
                          <div class="new_ph inline-block"></div>
                          <button type="button" class="btn btn-default" id="closeCrop" onClick="closeModal();">დახურვა</button>
                          <button type="button" class="btn btn-success" id="cropImageButton" onClick="saveImage();">შენახვა</button>
                        </div>
                      </div>
                    </div>
                  </div>

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

                  <div class="form-group">
                    <label for="document_type">საბუთის ტიპი</label>
                    <select name="document_type" id="document_type" class="input select2me select2-offscreen" placeholder="აირჩიეთ" title="საბუთის ტიპი: * ">
                       <option value=""></option>

                       <?php foreach ($users_document_types as $type) { ?>

                         <option value="<?php echo $type['id']; ?>"><?php echo $type['name']; ?></option>


                       <?php } ?>

                     </select>
                  </div>

                  <div class="upload-doc">
                    <div class="box">
                      <div class="upload-options">საბუთის წინა მხარე</div>
                      <div class="image-preview front"></div>
                      <div class="or-btns clear">
                        <label class="control-label" for="front">ატვირთე</label>
                        <input type="file" class="bs64" name="front" id="front">
                        <input type="hidden" name="document_front" id="document_front" value="">
                        <span>ან</span>
                        <button type="button" name="button" id="buttonStart" onClick="start('front')">გადაუღე</button>
                      </div>
                    </div>

                    <div class="box backside">
                      <div class="upload-options">საბუთის უკანა მხარე</div>
                      <div class="image-preview back"></div>
                      <div class="or-btns clear">
                        <label class="control-label" for="back">ატვირთე</label>
                        <input type="file" class="bs64" name="back" id="back">
                        <input type="hidden" name="document_back" id="document_back" value="">
                        <span>ან</span>
                        <button type="button" name="button" id="buttonStart" onClick="start('back')">გადაუღე</button>
                      </div>
                    </div>
                  </div>

                  <div class="form-group">
                    <label for="issue_date"><?php echo $lang['passport_registration_date']; ?></label>
                    <div class="row date-row">
                      <div class="col-md-4 col-sm-4 col-xs-4">
                        <select name="issue_year" id="issue_year" class="input select2-container select2me" title="<?php echo $lang['year']; ?>: * ">
                          <option value=""><?php echo $lang['year']; ?></option>

                          <?php foreach ($year_array as $year) { ?>

                            <option value="<?php echo $year ?>"><?php echo $year ?></option>

                          <?php } // end foreach ?>

                        </select>
                      </div>
                      <div class="col-md-4 col-sm-4 col-xs-4">
                        <select name="issue_month" id="issue_month" class="input select2-container select2me" title="<?php echo $lang['month']; ?>: * ">
                          <option value=""><?php echo $lang['month']; ?></option>

                          <?php foreach ($month_array as $key  => $value) { ?>

                            <option value="<?php echo $key;  ?>"><?php echo $value[$lang_id]; ?></option>

                          <?php } // end foreach ?>

                        </select>
                      </div>
                      <div class="col-md-4 col-sm-4 col-xs-4">
                        <select name="issue_day" id="issue_day" class="input select2-container select2me" title="<?php echo $lang['day']; ?>: * ">
                          <option value=""><?php echo $lang['day']; ?></option>

                          <?php foreach ($day_array as $key  => $value) { ?>

                            <option value="<?php echo $key;  ?>"><?php echo $value;  ?></option>

                          <?php } // end foreach ?>

                          </select>
                      </div>
                    </div>
                  </div>

                  <div class="form-group">
                    <label for="expiry_date">მოქმედების ვადა</label>
                    <div class="row date-row">
                      <div class="col-md-4 col-sm-4 col-xs-4">
                        <select name="expiry_year" id="expiry_year" class="input select2-container select2me" title="<?php echo $lang['year']; ?>: * ">>
                          <option value=""><?php echo $lang['year']; ?></option>

                          <?php

                            for ($i = 2019; $i < 2050; $i++) {
                              ?>

                              <option value="<?php echo $i; ?>"><?php echo $i; ?></option>

                              <?php
                            }

                           ?>

                        </select>
                      </div>
                      <div class="col-md-4 col-sm-4 col-xs-4">
                        <select name="expiry_month" id="expiry_month" class="input select2-container select2me" title="<?php echo $lang['month']; ?>: * ">>
                          <option value=""><?php echo $lang['month']; ?></option>

                          <?php foreach ($month_array as $key  => $value) { ?>

                            <option value="<?php echo $key;  ?>" ><?php echo $value[$lang_id]; ?></option>

                          <?php } // end foreach ?>

                        </select>
                      </div>
                      <div class="col-md-4 col-sm-4 col-xs-4">
                        <select name="expiry_day" id="expiry_day" class="input select2-container select2me" title="<?php echo $lang['day']; ?>: * ">>
                          <option value=""><?php echo $lang['day']; ?></option>

                          <?php foreach ($day_array as $key  => $value) { ?>

                            <option value="<?php echo $key;  ?>"><?php echo $value;  ?></option>

                          <?php } // end foreach ?>

                        </select>
                      </div>
                    </div>
                  </div>

                  <div class="form-group">
                    <label for="sfero_id">საქმიანობის სფერო</label>
                    <select name="sfero_id" id="sfero_id" class="input select2me select2-offscreen" placeholder="აირჩიეთ" title="საქმიანობის სფერო: * ">
    								   <option value=""></option>

                       <?php foreach ($sferos as $sfero) { ?>

                         <option value="<?php echo $sfero['id']; ?>"><?php echo $sfero['name']; ?></option>


                       <?php } ?>

    								 </select>
                  </div>

                  <div class="form-group sfero_div" style="display:none;">
                    <label for="sfero">სფეროს დასახელება</label>
                      <input type="text" class="input" name="sfero" id="sfero"  maxlength="50"  title="სფეროს დასახელება: * ">
                  </div>

                  <br><hr>
                  <div class="form-group text-center">
                    <button type="submit" name="submit" class="g1-btn">გაგზავნა</button>
                  </div>
                </form>

              </div>
              <div class="step">

                <form class="form_step st_4" rel="4" action="https://leaderpay.ge/loads/verification.php?action=verification" method="get" autocomplete="off">
                  <div class="aggement">
                    <iframe id="aggement" style="width:100%;min-height:400px;" src=""></iframe>
                  </div>

                  <div class="form-group checkbox">
                    <div class="md-checkbox">
                      <input id="checkbox" name="checkbox" type="checkbox">
                      <label for="checkbox" style="padding: 0 5px 0 5px;">გავეცანი და ვეთანხმები ხელშეკრულებას ელექტრონულ საფულეში რეგისტრაციასა და მის სარგებლობასთან დაკავშირებით</label>
                    </div>
                  </div>

                  <br><hr>
                  <div class="form-group text-center">
                    <button type="submit" name="submit" class="g1-btn">გაგზავნა</button>
                  </div>
                </form>

              </div>
            </div><!-- end steps-body -->
          </div><!-- end steps -->

        </div><!-- end page-bg -->
      </div><!-- end col -->
    </div><!-- end row -->

  </div><!-- end container -->

<?php

  $page_script = '<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js"></script><script src="https://manager.allpayway.ge/assets/global/plugins/cropperjs/cropper.min.js"></script><script src="assets/pages/verification.js?'.time().'"></script>';

  include 'includes/footer.php';
?>
